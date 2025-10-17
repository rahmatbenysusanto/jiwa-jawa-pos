<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\MaterialCategory;
use App\Models\MaterialUnit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class InventoryController extends Controller
{
    public function indexCategory(Request $request): View
    {
        $category = MaterialCategory::where('outlet_id', Auth::user()->outlet_id)->whereNull('deleted_at')->paginate(10);

        $title = 'Material Category';
        return view('inventory.category.index', compact('title', 'category'));
    }

    public function storeCategory(Request $request): \Illuminate\Http\RedirectResponse
    {
        MaterialCategory::create([
            'outlet_id' => Auth::user()->outlet_id,
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
        $material = Material::with('category', 'unit')->where('outlet_id', Auth::user()->outlet_id)->whereNull('deleted_at')->paginate(10);

        $title = 'Material';
        return view('inventory.material.index', compact('title', 'material'));
    }

    public function createMaterial(Request $request): View
    {
        $category = MaterialCategory::where('outlet_id', Auth::user()->outlet_id)->whereNull('deleted_at')->get();
        $unit = MaterialUnit::all();

        $title = 'Material';
        return view('inventory.material.create', compact('title', 'category', 'unit'));
    }

    public function storeMaterial(Request $request): \Illuminate\Http\RedirectResponse
    {
        try {
            DB::beginTransaction();

            $request->validate([
                'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $fileName = time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/material'), $fileName);
            }

            Material::create([
                'outlet_id'     => Auth::user()->outlet_id,
                'category_id'   => $request->post('category'),
                'sku'           => $request->post('sku'),
                'name'          => $request->post('name'),
                'min_stock'     => $request->post('min_stock'),
                'price'         => $request->post('price') ?? 0,
                'image'         => $fileName ?? null,
                'description'   => $request->post('desc'),
                'unit_id'       => $request->post('unit'),
                'base_unit_id'  => $request->post('base_unit'),
                'conversion_value'  => $request->post('conversion'),
            ]);

            DB::commit();

            return redirect()->route('inventory.material')->with('success', 'Material added successfully');
        } catch (\Exception $err) {
            DB::rollBack();
            Log::error($err->getMessage());
            Log::error($err->getLine());

            return back()->with('error', 'Something went wrong, please try again later');
        }
    }

    public function detailMaterial(Request $request): View
    {
        $material = Material::with('category', 'unit', 'baseUnit')->where('id', $request->query('id'))->first();

        $title = 'Material';
        return view('inventory.material.detail', compact('title', 'material'));
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



































