<?php

namespace App\Http\Controllers;

use App\Models\MaterialCategory;
use Illuminate\Http\Request;
use Illuminate\View\View;

class InventoryController extends Controller
{
    public function indexCategory(Request $request): View
    {
        $category = MaterialCategory::where('outlet_id', 1)->whereNull('deleted_at')->paginate(10);

        $title = 'Material Category';
        return view('inventory.category.index', compact('title', 'category'));
    }

    public function storeCategory(Request $request): \Illuminate\Http\RedirectResponse
    {
        MaterialCategory::create([
            'outlet_id' => 1,
            'name'      => $request->post('category'),
        ]);

        return back()->with('success', 'Category added successfully');
    }

    public function deleteCategory(Request $request): \Illuminate\Http\JsonResponse
    {
        MaterialCategory::where('id', $request->get('id'))->update(['deleted_at' => now()]);

        return response()->json([
            'status' => true
        ]);
    }

    public function findCategory(Request $request): \Illuminate\Http\JsonResponse
    {
        $result = MaterialCategory::find($request->get('id'));

        return response()->json([
            'status' => true,
            'data' => $result
        ]);
    }

    public function editCategory(Request $request): \Illuminate\Http\RedirectResponse
    {
        MaterialCategory::where('id', $request->get('id'))->update([
            'name'      => $request->post('category'),
        ]);

        return back()->with('success', 'Category updated successfully');
    }

    public function indexMaterial(Request $request): View
    {
        $title = 'Material';
        return view('inventory.material.index', compact('title'));
    }

    public function indexPurchaseOrder(Request $request): View
    {
        $title = 'Purchase Order';
        return view('inventory.purchaseOrder.index', compact('title'));
    }

    public function indexManageStock(Request $request): View
    {
        $title = 'Manage Stock';
        return view('inventory.manageStock.index', compact('title'));
    }

    public function indexStockAdjusment(Request $request): View
    {
        $title = 'Stock Adjustment';
        return view('inventory.stockAdjusment.index', compact('title'));
    }

    public function indexTransferStock(Request $request): View
    {
        $title = 'Transfer Stock';
        return view('inventory.transferStock.index', compact('title'));
    }
}



































