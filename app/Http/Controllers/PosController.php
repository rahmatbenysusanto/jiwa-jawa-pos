<?php

namespace App\Http\Controllers;

use App\Events\TransactionEvent;
use App\Models\Addon;
use App\Models\AddonVariant;
use App\Models\Menu;
use App\Models\MenuCategory;
use App\Models\PaymentMethod;
use App\Models\Transaction;
use App\Models\TransactionPayment;
use App\Services\MidtransService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PosController extends Controller
{
    public function __construct(
        protected MidtransService $midtransService
    ) {}

    public function index(): View
    {
        $categories = MenuCategory::where('outlet_id', Auth::user()->outlet_id)->whereNull('deleted_at')->get();
        $invoiceNumber = 'INV-' . date('Ymd') . '-' . strtoupper(Str::random(6));

        // Reset Customer Display
        TransactionEvent::dispatch([
            'username'  => Auth::user()->username,
            'type'      => 'reset',
            'invoice'   => $invoiceNumber,
            'data'      => [],
        ]);

        $title = 'POS';
        return view('pos.index', compact('title', 'categories', 'invoiceNumber'));
    }

    public function menu(Request $request): \Illuminate\Http\JsonResponse
    {
        $categories = MenuCategory::where('outlet_id', Auth::user()->outlet_id)->whereNull('deleted_at')->get();

        foreach ($categories as $category) {
            $category->idName = 'category_' . $category->id;
            $category->menu = Menu::with('category:id,name')->where('outlet_id', Auth::user()->outlet_id)->whereNull('deleted_at')->where('category_id', $category->id)->get();
        }

        $allMenu = Menu::with('category:id,name')->where('outlet_id', Auth::user()->outlet_id)->whereNull('deleted_at')->get();

        return response()->json([
            'all'       => $allMenu,
            'category'  =>  $categories
        ]);
    }

    public function findProduct(Request $request): \Illuminate\Http\JsonResponse
    {
        $product = Menu::with('menuVariant', 'menuVariant.menuVariantOptions', 'category')->where('id', $request->get('id'))->first();

        $discount = DB::table('discount')
            ->leftJoin('discount_menu', 'discount.id', '=', 'discount_menu.discount_id')
            ->where('discount_menu.menu_id', $request->get('id'))
            ->where('discount.status', 'active')
            ->get();

        return response()->json([
            'data'      => $product,
            'discount'  => $discount
        ]);
    }

    public function addon(): \Illuminate\Http\JsonResponse
    {
        $addon = Addon::where('outlet_id', Auth::user()->outlet_id)->whereNull('deleted_at')->get();
        return response()->json([
            'data'  => $addon
        ]);
    }

    public function findAddon(Request $request): \Illuminate\Http\JsonResponse
    {
        $addon = AddonVariant::where('addon_id', $request->get('id'))->get();

        return response()->json([
            'data'  => $addon
        ]);
    }

    public function listAddon(Request $request): \Illuminate\Http\JsonResponse
    {
        $addon = Addon::with('addonVariant')
            ->where('outlet_id', Auth::user()->outlet_id)
            ->whereNull('deleted_at')
            ->get();

        return response()->json([
            'data'  => $addon
        ]);
    }

    public function findAddonVariant(Request $request): \Illuminate\Http\JsonResponse
    {
        $addon = AddonVariant::find($request->get('id'));

        return response()->json([
            'data'  => $addon
        ]);
    }

    public function paymentMethod(): \Illuminate\Http\JsonResponse
    {
        $payment = PaymentMethod::all();

        return response()->json([
            'data'  => $payment
        ]);
    }

    public function changePaymentMethod(Request $request): \Illuminate\Http\JsonResponse
    {
        switch ($request->post('paymentMethod')) {
            case 'Cash':
                Transaction::where('invoice_number', $request->post('invoice'))->update([
                    'payment_method_id' => 1,
                    'payment_status'    => 'paid',
                ]);

                TransactionPayment::where('invoice_number', $request->post('invoice'))->delete();
                TransactionPayment::create([
                    'invoice_number'    => $request->post('invoice'),
                    'payment_method_id' => 1,
                ]);
                break;
            case 'QRIS':
                $order = Transaction::where('invoice_number', $request->post('invoice'))->first();
                $qris = $this->midtransService->createQRIS($order->id);

                return response()->json([
                    'status'    => true,
                    'data'      => $qris,
                ]);
            case 'Debit':
                Transaction::where('invoice_number', $request->post('invoice'))->update([
                    'payment_method_id' => 3,
                    'payment_status'    => 'paid',
                ]);

                TransactionPayment::where('invoice_number', $request->post('invoice'))->delete();
                TransactionPayment::create([
                    'invoice_number'    => $request->post('invoice'),
                    'payment_method_id' => 3,
                    'reff_id'           => $request->post('approvalCodeChangePayment'),
                ]);
                break;
            case 'Transfer':
                Transaction::where('invoice_number', $request->post('invoice'))->update([
                    'payment_method_id' => 4,
                    'payment_status'    => 'paid',
                ]);

                TransactionPayment::where('invoice_number', $request->post('invoice'))->delete();
                TransactionPayment::create([
                    'invoice_number'    => $request->post('invoice'),
                    'payment_method_id' => 4,
                ]);
                break;
        }

        return response()->json([
            'status' => true
        ]);
    }
}
