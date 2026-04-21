<?php

namespace App\Http\Controllers;

use App\Events\TransactionEvent;
use App\Models\AddonVariant;
use App\Models\Inventory;
use App\Models\MaterialUsage;
use App\Models\Menu;
use App\Models\MenuRecipeMaterial;
use App\Models\MenuVariantOption;
use App\Models\PaymentMethod;
use App\Models\Transaction;
use App\Models\TransactionData;
use App\Models\TransactionDetail;
use App\Models\TransactionDetailVariant;
use App\Models\TransactionDetailVariantAddon;
use App\Models\TransactionDiscount;
use App\Models\TransactionPayment;
use App\Models\TransactionSplitPayment;
use App\Services\MidtransService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class TransactionController extends Controller
{
    public function __construct(
        protected MidtransService $midtransService
    ) {}

    public function index(Request $request): View
    {
        $transaction = Transaction::with('paymentMethod')
            ->where('outlet_id', Auth::user()->outlet_id)
            ->when($request->query('invoice'), function ($query) use ($request) {
                return $query->where('invoice_number', $request->query('invoice'));
            })
            ->when($request->query('orderNumber'), function ($query) use ($request) {
                return $query->where('order_number', $request->query('orderNumber'));
            })
            ->when($request->query('paymentStatus'), function ($query) use ($request) {
                return $query->where('payment_status', $request->query('paymentStatus'));
            })
            ->whereHas('paymentMethod', function ($query) use ($request) {
                if ($request->query('paymentMethodId') != null) {
                    return $query->where('name', $request->query('paymentMethod'));
                }
            })
            ->latest()
            ->paginate(10);

        $title = 'Transaction';
        return view('transaction.index', compact('title', 'transaction'));
    }

    public function store(Request $request): JsonResponse
    {
        try {
            DB::beginTransaction();

            // Baca dari JSON body (frontend kirim contentType: application/json)
            // Fallback ke $request->post() untuk backward compatibility
            $input             = $request->isJson() ? $request->json()->all() : $request->post();
            $cartItems         = $input['cart']                ?? [];
            $discountTrxIn     = $input['discountTransaction'] ?? [];
            $splitPayIn        = $input['splitPayment']        ?? [];
            $paymentMethodName = $input['paymentMethod']       ?? '';
            $invoiceNumber     = $input['invoice']             ?? '';
            $noteInput         = $input['note']                ?? '';
            $subTotal          = $input['subTotal']            ?? 0;
            $totalTax          = $input['totalTax']            ?? 0;
            $discountAmt       = $input['discount']            ?? 0;
            $grandTotal        = $input['grandTotal']          ?? 0;
            $delivery          = $input['delivery']            ?? 'dine in';

            // ── VALIDASI BACKEND ──
            if (empty($cartItems) || !is_array($cartItems)) {
                DB::rollBack();
                Log::error('TRX STORE: cart kosong/bukan array', ['invoice' => $invoiceNumber]);
                return response()->json(['status' => false, 'message' => 'Cart tidak boleh kosong.'], 422);
            }

            foreach ($cartItems as $idx => $item) {
                if (empty($item['menuId']) || empty($item['qty'])) {
                    DB::rollBack();
                    Log::error('TRX STORE: item tidak valid', ['idx' => $idx, 'item' => $item]);
                    return response()->json(['status' => false, 'message' => 'Item ke-' . ($idx + 1) . ' tidak valid.'], 422);
                }
            }

            $orderNumber   = Transaction::where('outlet_id', Auth::user()->outlet_id)
                ->whereDate('transaction_date', date('Y-m-d'))
                ->count() + 1;

            $paymentMethod = PaymentMethod::where('name', $paymentMethodName)->first();
            $totalQty      = array_sum(array_column($cartItems, 'qty'));

            $transaction = Transaction::create([
                'outlet_id'            => Auth::user()->outlet_id,
                'invoice_number'       => $invoiceNumber,
                'order_number'         => str_pad($orderNumber, 2, '0', STR_PAD_LEFT),
                'qty'                  => $totalQty,
                'hpp'                  => 0,
                'subtotal'             => $subTotal,
                'discount'             => $discountAmt,
                'tax'                  => $totalTax,
                'total'                => $grandTotal,
                'payment_method_id'    => $paymentMethod->id ?? 0,
                'payment_status'       => ($paymentMethod->id ?? 0) == 1 ? 'paid' : 'pending',
                'transaction_type'     => 'sales',
                'transaction_delivery' => $delivery,
                'note'                 => $noteInput,
                'transaction_date'     => date('Y-m-d H:i:s'),
                'created_by'           => Auth::id(),
            ]);

            $hppTransaction = 0;
            $detailCount    = 0;

            foreach ($cartItems as $item) {
                $menu = Menu::find($item['menuId']);
                $hppTransactionDetail = $menu ? $menu->hpp : 0;

                $detail = TransactionDetail::create([
                    'transaction_id'   => $transaction->id,
                    'menu_id'          => $item['menuId'],
                    'qty'              => $item['qty'],
                    'base_price'       => $item['basePrice']     ?? 0,
                    'price'            => $item['totalPrice']    ?? 0,
                    'discount'         => $item['priceDiscount'] ?? 0,
                    'total'            => $item['grandTotal'],
                    'note'             => $item['note'],
                ]);

                foreach ($item['data']['variant'] ?? [] as $variant) {
                    foreach ($variant['option'] as $option) {
                        if ($option['select'] == 1) {
                            $menuVariantOption = MenuVariantOption::find($option['id']);
                            if ($menuVariantOption) {
                                $hppTransactionDetail += $menuVariantOption->hpp;

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
                }

                foreach ($item['data']['addon'] ?? [] as $addon) {
                    $addonVariant = AddonVariant::find($addon['id']);
                    if ($addonVariant) {
                        $hppTransactionDetail += $addonVariant->hpp;

                        TransactionDetailVariantAddon::create([
                            'transaction_detail_id' => $detail->id,
                            'addon_variant_id'      => $addon['id'],
                            'addon_name'            => $addon['name'],
                            'addon_price'           => $addon['price'],
                            'qty'                   => $addon['qty'],
                            'total_price'           => $addon['total'],
                        ]);
                    }
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

                TransactionDetail::where('id', $detail->id)->update(['hpp' => $hppTransactionDetail]);
                $hppTransaction += $hppTransactionDetail;
                $detailCount++;
            }

            // ── VERIFIKASI POST-SAVE: pastikan semua item tersimpan ──
            if ($detailCount !== count($cartItems)) {
                DB::rollBack();
                Log::error('TRX STORE: jumlah detail tidak sesuai cart!', [
                    'invoice'       => $invoiceNumber,
                    'cart_count'    => count($cartItems),
                    'detail_count'  => $detailCount,
                ]);
                return response()->json([
                    'status'  => false,
                    'message' => 'Transaksi tidak lengkap: ' . $detailCount . ' dari ' . count($cartItems) . ' item tersimpan. Silakan coba lagi.',
                ], 500);
            }

            Transaction::where('id', $transaction->id)->update(['hpp' => $hppTransaction]);

            // Filter discount yang benar-benar dipilih (select == 1)
            foreach ($discountTrxIn as $discountItem) {
                if (isset($discountItem['select']) && (int) $discountItem['select'] === 1) {
                    if (($discountItem['type'] ?? '') === 'nominal') {
                        $actualDiscountPrice = (float) $discountItem['value'];
                    } else {
                        $subTotalAfterProductDiscount = (float) $subTotal - array_sum(
                            array_column($cartItems, 'priceDiscount')
                        );
                        $actualDiscountPrice = $subTotalAfterProductDiscount * ((float) $discountItem['value'] / 100);
                    }
                    TransactionDiscount::create([
                        'transaction_id' => $transaction->id,
                        'discount_id'    => $discountItem['id'],
                        'price'          => $actualDiscountPrice,
                    ]);
                }
            }

            if (!empty($splitPayIn)) {
                foreach ($splitPayIn as $value) {
                    $pmSplit = PaymentMethod::where('name', $value['paymentMethod'])->first();
                    TransactionSplitPayment::create([
                        'transaction_id'    => $transaction->id,
                        'payment_method_id' => $pmSplit->id ?? 0,
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
                    'invoice'   => $invoiceNumber,
                    'data'      => $midtrans
                ]);
            }

            $this->calculateMaterialUsage($transaction->id);

            DB::commit();
            return response()->json([
                'status' => true,
                'data'   => $midtrans ?? [],
            ]);
        } catch (\Exception $err) {
            DB::rollBack();
            Log::error('TRX STORE EXCEPTION: ' . $err->getMessage(), [
                'line'    => $err->getLine(),
                'file'    => $err->getFile(),
                'invoice' => $invoiceNumber ?? '-',
                'cart_count' => isset($cartItems) ? count($cartItems) : 'n/a',
            ]);
            return response()->json([
                'status'  => false,
                'message' => 'Terjadi kesalahan server: ' . $err->getMessage(),
            ]);
        }
    }

    private function calculateMaterialUsage($transactionId): void
    {
        // Base Menu
        $transactionDetail = TransactionDetail::where('transaction_id', $transactionId)->get();
        foreach ($transactionDetail as $detail) {
            $recipe = MenuRecipeMaterial::where('menu_id', $detail->menu_id)->whereNull('variant_id')->get();
            foreach ($recipe as $item) {
                MaterialUsage::create([
                    'outlet_id'             => Auth::user()->outlet_id,
                    'menu_id'               => $detail->menu_id,
                    'material_id'           => $item->material_id,
                    'transaction_id'        => $transactionId,
                    'transaction_detail_id' => $detail->id,
                    'qty'                   => $detail->qty * $item->qty,
                    'type'                  => 'transaction',
                    'note'                  => 'Material Usage Transaction base menu',
                ]);

                Inventory::where('outlet_id', Auth::user()->outlet_id)
                    ->where('material_id', $item->material_id)
                    ->decrement('stock', $detail->qty * $item->qty);
            }

            // Variant
            $transactionDetailVariant = TransactionDetailVariant::where('transaction_detail_id', $detail->id)->get();
            foreach ($transactionDetailVariant ?? [] as $variant) {
                $recipe = MenuRecipeMaterial::where('variant_id', $variant->menu_variant_option_id)->get();
                foreach ($recipe as $item) {
                    MaterialUsage::create([
                        'outlet_id'             => Auth::user()->outlet_id,
                        'menu_id'               => $detail->menu_id,
                        'material_id'           => $item->material_id,
                        'transaction_id'        => $transactionId,
                        'transaction_detail_id' => $detail->id,
                        'variant_detail_id'     => $variant->menu_variant_option_id,
                        'qty'                   => $detail->qty * $item->qty,
                        'type'                  => 'transaction',
                        'note'                  => 'Material Usage Transaction variant menu',
                    ]);

                    Inventory::where('outlet_id', Auth::user()->outlet_id)
                        ->where('material_id', $item->material_id)
                        ->decrement('stock', $detail->qty * $item->qty);
                }
            }

            // Addon
            $transactionDetailAddon = TransactionDetailVariantAddon::where('transaction_detail_id', $detail->id)->get();
            foreach ($transactionDetailAddon ?? [] as $addon) {
                $recipe = MenuRecipeMaterial::where('addon_id', $addon->addon_variant_id)->get();
                foreach ($recipe as $item) {
                    MaterialUsage::create([
                        'outlet_id'             => Auth::user()->outlet_id,
                        'menu_id'               => $detail->menu_id,
                        'material_id'           => $item->material_id,
                        'transaction_id'        => $transactionId,
                        'transaction_detail_id' => $detail->id,
                        'addon_detail_id'       => $addon->addon_variant_id,
                        'qty'                   => $detail->qty * $item->qty,
                        'type'                  => 'transaction',
                        'note'                  => 'Material Usage Transaction Addon',
                    ]);

                    Inventory::where('outlet_id', Auth::user()->outlet_id)
                        ->where('material_id', $item->material_id)
                        ->decrement('stock', $detail->qty * $item->qty);
                }
            }
        }
    }

    public function dataStore(Request $request): JsonResponse
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

    public function createTransactionPayment(Request $request): JsonResponse
    {
        TransactionPayment::create([
            'invoice_number'        => $request->post('invoiceNumber'),
            'reff_id'               => $request->post('reffId'),
            'payment_method_id'     => $request->post('paymentMethodId'),
            'data'                  => json_encode($request->post('data')),
        ]);

        Transaction::where('invoice_number', $request->post('invoiceNumber'))->update([
            'payment_status' => 'paid'
        ]);

        return response()->json([
            'status' => true,
        ]);
    }

    public function findDataCart(Request $request): JsonResponse
    {
        $result = TransactionData::where('invoice_number', $request->get('invoiceNumber'))->first();

        return response()->json([
            'status' => true,
            'data'   => $result
        ]);
    }

    public function detail(Request $request): View
    {
        $transaction = Transaction::with('paymentMethod', 'users')->where('invoice_number', $request->query('invoice'))->first();
        $transactionData = TransactionData::where('invoice_number', $request->query('invoice'))->first();

        // Load detail dari DB yang real (bukan hanya dari JSON localStorage snapshot)
        $transactionDetails = TransactionDetail::with('variants', 'addons', 'menu')
            ->where('transaction_id', $transaction->id)
            ->get();

        $title = 'Transaction';
        return view('transaction.detail', compact('title', 'transaction', 'transactionData', 'transactionDetails'));
    }

    public function cancelTransaction(Request $request): JsonResponse
    {
        try {
            DB::beginTransaction();

            Transaction::where('invoice_number', $request->post('invoiceNumber'))->update([
                'transaction_status' => 'canceled'
            ]);

            DB::commit();
            return response()->json([
                'status' => true,
            ]);
        } catch (\Exception $err) {
            DB::rollBack();
            Log::error($err->getMessage());
            return response()->json([
                'status' => false,
            ]);
        }
    }

    public function changeStatusPayment(Request $request): JsonResponse
    {
        try {
            DB::beginTransaction();

            Transaction::where('invoice_number', $request->post('invoiceNumber'))->update([
                'payment_status' => 'paid'
            ]);

            DB::commit();
            return response()->json([
                'status' => true,
            ]);
        } catch (\Exception $err) {
            DB::rollBack();
            Log::error($err->getMessage());
            return response()->json([
                'status' => false,
            ]);
        }
    }

    public function callbackMidtransPayment(Request $request): JsonResponse
    {
        $payload = $request->all();

        $orderId = $payload['order_id'] ?? null;
        $status  = $payload['transaction_status'] ?? null;

        $localSignature = hash(
            'sha512',
            $payload['order_id'] .
                $payload['status_code'] .
                $payload['gross_amount'] .
                env('MIDTRANS_SERVER_KEY')
        );

        if ($localSignature !== $payload['signature_key']) {
            return response()->json(['message' => 'Invalid signature'], 403);
        }

        if ($status === 'settlement') {
            Transaction::where('invoice_number', $orderId)->update(['payment_status' => 'paid']);
        }

        TransactionEvent::dispatch([
            'username'  => null,
            'type'      => 'paymentQrisSuccess',
            'invoice'   => $orderId,
            'data'      => []
        ]);

        return response()->json([
            'status' => true,
        ]);
    }
}
