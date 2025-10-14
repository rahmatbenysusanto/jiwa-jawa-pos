<?php

namespace App\Http\Controllers;

use App\Events\TransactionEvent;
use App\Models\PaymentMethod;
use App\Models\Transaction;
use App\Models\TransactionData;
use App\Models\TransactionDetail;
use App\Models\TransactionDetailVariant;
use App\Models\TransactionDetailVariantAddon;
use App\Models\TransactionDiscount;
use App\Models\TransactionSplitPayment;
use App\Services\MidtransService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class TransactionController extends Controller
{
    public function __construct(
        protected MidtransService $midtransService
    ) {}

    public function index(): View
    {
        $transaction = Transaction::with('paymentMethod')->where('outlet_id', Auth::user()->outlet_id)->latest()->paginate(10);

        $title = 'Transaction';
        return view('transaction.index', compact('title', 'transaction'));
    }

    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            DB::beginTransaction();

            $orderNumber = Transaction::where('outlet_id', Auth::user()->outlet_id)
                ->whereDate('transaction_date', date('Y-m-d'))
                ->count() + 1;

            $paymentMethod = PaymentMethod::where('name', $request->post('paymentMethod'))->first();

            $transaction = Transaction::create([
                'outlet_id'         => Auth::user()->outlet_id,
                'invoice_number'    => $request->post('invoice'),
                'order_number'      => str_pad($orderNumber, 2, '0', STR_PAD_LEFT),
                'qty'               => count($request->post('cart')),
                'subtotal'          => $request->post('subTotal'),
                'discount'          => $request->post('discount'),
                'tax'               => $request->post('totalTax'),
                'total'             => $request->post('grandTotal'),
                'payment_method_id' => $paymentMethod->id ?? 0,
                'payment_status'    => 'pending',
                'transaction_type'  => 'sales',
                'note'              => $request->post('note'),
                'transaction_date'  => date('Y-m-d H:i:s'),
                'created_by'        => Auth::id()
            ]);

            foreach ($request->post('cart') as $item) {
                $detail = TransactionDetail::create([
                    'transaction_id'   => $transaction->id,
                    'menu_id'          => $item['menuId'],
                    'qty'              => $item['qty'],
                    'base_price'       => $item['basePrice'],
                    'price'            => $item['totalPrice'],
                    'discount'         => $item['priceDiscount'],
                    'total'            => $item['grandTotal'],
                    'note'             => null,
                ]);

                foreach ($item['data']['variant'] ?? [] as $variant) {
                    foreach ($variant['option'] as $option) {
                        if ($option['select'] == 1) {
                            TransactionDetailVariant::create([
                                'transaction_detail_id'     => $detail->id,
                                'menu_variant_option_id'    => $option['id'],
                                'variant_name'              => $variant['name'],
                                'variant_value'             => $option['name'],
                                'variant_price'             => $option['price'],
                            ]);
                        }
                    }
                }

                foreach ($item['data']['addon'] ?? [] as $addon) {
                    TransactionDetailVariantAddon::create([
                        'transaction_detail_id' => $detail->id,
                        'addon_variant_id'      => $addon['id'],
                        'addon_name'            => $addon['name'],
                        'addon_price'           => $addon['price'],
                        'qty'                   => $addon['qty'],
                        'total_price'           => $addon['total'],
                    ]);
                }

                if ($item['priceDiscount'] != 0) {
                    foreach ($item['data']['discountProduct'] ?? [] as $discountProduct) {
                        TransactionDiscount::create([
                            'transaction_id'        => $transaction->id,
                            'transaction_detail_id' => $detail->id,
                            'discount_id'           => $discountProduct['id'],
                            'price'                 => $item['priceDiscount']
                        ]);
                    }
                }
            }

            if ($request->post('discountTransaction') != null) {
                $discountTransaction = $request->post('discountTransaction');
                TransactionDiscount::create([
                    'transaction_id'   => $transaction->id,
                    'discount_id'      => $discountTransaction[0]['id'],
                    'price'            => $discountTransaction[0]['value'],
                ]);
            }

            if ($request->post('splitPayment') != null) {
                foreach ($request->post('splitPayment') as $value) {
                    $paymentMethod = PaymentMethod::where('name', $value['paymentMethod'])->first();

                    TransactionSplitPayment::create([
                        'transaction_id'    => $transaction->id,
                        'payment_method_id' => $paymentMethod->id,
                        'price'             => $value['amount'],
                    ]);
                }
            }

            if ($request->post('paymentMethod') == 'QRIS') {
                $midtrans = $this->midtransService->createQRIS($transaction->id);

                // Payment QRIS Customer Display
                TransactionEvent::dispatch([
                    'username'  => Auth::user()->username,
                    'type'      => 'payment',
                    'invoice'   => $request->post('invoice'),
                    'data'      => $midtrans
                ]);
            }

            DB::commit();
            return response()->json([
                'status' => true,
                'data'   => $midtrans ?? [],
            ]);
        } catch (\Exception $err) {
            DB::rollBack();
            Log::error($err->getMessage());
            Log::error($err->getLine());
            return response()->json([
                'status' => false,
            ]);
        }
    }

    public function dataStore(Request $request): \Illuminate\Http\JsonResponse
    {
        $check = TransactionData::where('invoice_number', $request->post('invoiceNumber'))->first();
        if ($check == null) {
            TransactionData::create([
                'invoice_number'        => $request->post('invoiceNumber'),
                'cart'                  => json_encode($request->post('cart')),
                'discountTransaction'   => json_encode($request->post('discountTransaction')),
                'paymentMethod'         => json_encode($request->post('paymentMethod')),
                'splitPayment'          => json_encode($request->post('splitPayment')),
            ]);
        } else {
            TransactionData::where('invoice_number', $request->post('invoiceNumber'))->update([
                'cart'                  => json_encode($request->post('cart')),
                'discountTransaction'   => json_encode($request->post('discountTransaction')),
                'paymentMethod'         => json_encode($request->post('paymentMethod')),
                'splitPayment'          => json_encode($request->post('splitPayment')),
            ]);
        }

        TransactionEvent::dispatch([
            'username'  => Auth::user()->username,
            'type'      => 'transaction-data',
            'invoice'   => $request->post('invoiceNumber'),
            'data'      => [],
        ]);

        return response()->json([
            'status' => true,
        ]);
    }

    public function findDataCart(Request $request): \Illuminate\Http\JsonResponse
    {
        $result = TransactionData::where('invoice_number', $request->get('invoiceNumber'))->first();

        return response()->json([
            'status' => true,
            'data'   => $result
        ]);
    }
}
