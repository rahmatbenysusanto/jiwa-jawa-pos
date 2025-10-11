<?php

namespace App\Http\Controllers;

use App\Models\Addon;
use App\Models\AddonVariant;
use App\Models\Menu;
use App\Models\MenuCategory;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PosController extends Controller
{
    public function index(): View
    {
        $categories = MenuCategory::where('outlet_id', 1)->whereNull('deleted_at')->get();
        $invoiceNumber = 'INV-' . date('Ymd') . '-' . strtoupper(Str::random(6));

        $title = 'POS';
        return view('pos.index', compact('title', 'categories', 'invoiceNumber'));
    }

    public function menu(Request $request): \Illuminate\Http\JsonResponse
    {
        $categories = MenuCategory::where('outlet_id', 1)->whereNull('deleted_at')->get();

        foreach ($categories as $category) {
            $category->idName = 'category_' . $category->id;
            $category->menu = Menu::where('outlet_id', 1)->whereNull('deleted_at')->where('category_id', $category->id)->get();
        }

        $allMenu = Menu::where('outlet_id', 1)->whereNull('deleted_at')->get();

        return response()->json([
            'all'       => $allMenu,
            'category'  =>  $categories
        ]);
    }

    public function findProduct(Request $request): \Illuminate\Http\JsonResponse
    {
        $product = Menu::with('menuVariant', 'menuVariant.menuVariantOptions', 'category')->where('id', $request->get('id'))->first();

        return response()->json([
            'data'  => $product
        ]);
    }

    public function addon(): \Illuminate\Http\JsonResponse
    {
        $addon = Addon::where('outlet_id', 1)->whereNull('deleted_at')->get();
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
}
