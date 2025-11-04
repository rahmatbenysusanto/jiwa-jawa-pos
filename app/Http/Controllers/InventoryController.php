<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\InventoryDetail;
use App\Models\Material;
use App\Models\MaterialCategory;
use App\Models\MaterialUnit;
use App\Models\MaterialUsage;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderDetail;
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

            $material = Material::create([
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

            Inventory::create([
                'material_id'   => $material->id,
                'outlet_id'     => Auth::user()->outlet_id,
                'stock'         => 0,
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

    public function editMaterial(Request $request): View
    {
        $material = Material::with('category', 'unit', 'baseUnit')->where('id', $request->query('id'))->first();
        $category = MaterialCategory::where('outlet_id', Auth::user()->outlet_id)->whereNull('deleted_at')->get();
        $unit = MaterialUnit::all();

        $title = 'Material';
        return view('inventory.material.edit', compact('title', 'category', 'unit', 'material'));
    }

    public function indexPurchaseOrder(Request $request): View
    {
        $purchaseOrder = PurchaseOrder::where('outlet_id', Auth::user()->outlet_id)->paginate(10);

        $title = 'Purchase Order';
        return view('inventory.purchaseOrder.index', compact('title', 'purchaseOrder'));
    }

    public function detailPurchaseOrder(Request $request): View
    {
        $purchaseOrder = PurchaseOrder::where('id', $request->query('id'))->first();
        $purchaseOrderDetail = PurchaseOrderDetail::with('material', 'material.unit')->where('purchase_order_id', $purchaseOrder->id)->get();

        $title = 'Purchase Order';
        return view('inventory.purchaseOrder.detail', compact('title', 'purchaseOrder', 'purchaseOrderDetail'));
    }

    public function cancelPurchaseOrder(Request $request): \Illuminate\Http\JsonResponse
    {
        PurchaseOrder::where('id', $request->post('id'))->update([
            'status' => 'cancel'
        ]);

        return response()->json([
            'status' => true
        ]);
    }

    public function createPurchaseOrder(): View
    {
        $material = Material::where('outlet_id', Auth::user()->outlet_id)->whereNull('deleted_at')->get();

        $title = 'Purchase Order';
        return view('inventory.purchaseOrder.create', compact('title', 'material'));
    }

    public function findMaterial(Request $request): \Illuminate\Http\JsonResponse
    {
        $material = Material::with('unit')->where('id', $request->get('id'))->first();

        return response()->json([
            'status' => true,
            'data' => $material
        ]);
    }

    public function storePurchaseOrder(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            DB::beginTransaction();

            $purchaseOrder = PurchaseOrder::create([
                'outlet_id'     => Auth::user()->outlet_id,
                'number'        => 'PO-'.date('Ymd').random_int(100, 999),
                'qty'           => count($request->post('material')),
                'status'        => 'new',
                'warehouse_id'  => 1,
                'warehouse_name'=> 'Gudang 1',
                'order_date'    => date('Y-m-d H:i:s'),
            ]);

            foreach ($request->post('material') as $material) {
                PurchaseOrderDetail::create([
                    'purchase_order_id' => $purchaseOrder->id,
                    'material_id'       => $material['id'],
                    'qty'               => $material['qty'],
                    'status'            => 'new'
                ]);
            }

            DB::commit();
            return response()->json([
                'status' => true,
            ]);
        } catch (\Exception $err) {
            DB::rollBack();
            Log::error($err->getMessage());
            Log::error($err->getLine());
            return response()->json([
                'status' => false,
                'message' => $err->getMessage()
            ]);
        }
    }

    public function processPurchaseOrder(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            DB::beginTransaction();

            PurchaseOrder::where('id', $request->post('id'))->update([
                'status'        => 'completed',
                'updated_at'    => date('Y-m-d H:i:s')
            ]);

            $purchaseOrderDetail = PurchaseOrderDetail::where('purchase_order_id', $request->post('id'))->get();
            foreach ($purchaseOrderDetail as $detail) {
                PurchaseOrderDetail::where('id', $detail->id)->update([
                    'status'        => 'completed',
                    'updated_at'    => date('Y-m-d H:i:s')
                ]);

                $inventory = Inventory::where('outlet_id', Auth::user()->outlet_id)->where('material_id', $detail->material_id)->first();

                $material = Material::find($detail->material_id);

                InventoryDetail::create([
                    'inventory_id'      => $inventory->id,
                    'purchase_order_id' => $detail->id,
                    'material_id'       => $detail->material_id,
                    'qty'               => $detail->qty * $material->conversion_value,
                    'price'             => 0
                ]);

                Inventory::where('id', $inventory->id)->increment('stock', $detail->qty * $material->conversion_value);
            }

            DB::commit();
            return response()->json([
                'status' => true,
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

    public function indexManageStock(Request $request): View
    {
        $inventory = Inventory::with('material', 'material.unit', 'material.category')->where('outlet_id', Auth::user()->outlet_id)->paginate(10);

        $title = 'Manage Stock';
        return view('inventory.manageStock.index', compact('title', 'inventory'));
    }

    public function detailManageStock(Request $request): View
    {
        $title = 'Manage Stock';
        return view('inventory.manageStock.detail', compact('title'));
    }

    public function indexStockConsumption(Request $request): View
    {
        $materialUsage = MaterialUsage::with('material', 'material.baseUnit', 'transaction', 'menu', 'variantDetail', 'variantDetail.variant', 'addOnDetail', 'addOnDetail.addon')
            ->where('outlet_id', Auth::user()->outlet_id)
            ->latest()
            ->paginate(10);

        $title = 'Stock Consumption';
        return view('inventory.stockConsumption.index', compact('title', 'materialUsage'));
    }

    public function createStockConsumption(): View
    {
        $title = 'Stock Consumption';
        return view('inventory.stockConsumption.create', compact('title'));
    }

    public function indexTransferStock(Request $request): View
    {
        $title = 'Transfer Stock';
        return view('inventory.transferStock.index', compact('title'));
    }
}



































