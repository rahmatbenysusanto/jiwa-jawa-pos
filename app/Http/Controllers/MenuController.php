<?php

namespace App\Http\Controllers;

use App\Models\Addon;
use App\Models\AddonVariant;
use App\Models\Menu;
use App\Models\MenuCategory;
use App\Models\MenuVariant;
use App\Models\MenuVariantOption;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class MenuController extends Controller
{
    public function category(): View
    {
        $category = MenuCategory::where('outlet_id', Auth::user()->outlet_id)->where('deleted_at', null)->paginate(10);

        $title = 'Menu Category';
        return view('menu.category', compact('title', 'category'));
    }

    public function categoryAdd(Request $request): \Illuminate\Http\RedirectResponse
    {
        MenuCategory::create([
            'outlet_id' => Auth::user()->outlet_id,
            'name'      => $request->post('category')
        ]);

        return back()->with('success', 'Category created successfully!');
    }

    public function findCategory(Request $request): \Illuminate\Http\JsonResponse
    {
        $category = MenuCategory::find($request->get('id'));

        return response()->json([
            'data' => $category
        ]);
    }

    public function categoryEdit(Request $request): \Illuminate\Http\RedirectResponse
    {
        MenuCategory::where('id', $request->post('id'))->update([
            'name' => $request->post('category')
        ]);

        return back()->with('success', 'Edit Category successfully!');
    }

    public function categoryDelete(Request $request): \Illuminate\Http\RedirectResponse
    {
        MenuCategory::where('id', $request->get('id'))->update([
            'deleted_at' => date('Y-m-d H:i:s')
        ]);

        return back()->with('success', 'Delete Category successfully!');
    }

    public function list(Request $request): View
    {
        $menu = Menu::with('category')->where('deleted_at', null)->paginate(10);
        $category = MenuCategory::where('outlet_id', Auth::user()->outlet_id)->where('deleted_at', null)->get();

        $title = 'Menu List';
        return view('menu.list', compact('title', 'menu', 'category'));
    }

    public function createMenu(): View
    {
        $category = MenuCategory::whereNull('deleted_at')->get();

        $title = 'Create Menu';
        return view('menu.create', compact('title', 'category'));
    }

    public function storeMenu(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            DB::beginTransaction();

            $menu = Menu::create([
                'outlet_id'     => Auth::user()->outlet_id,
                'category_id'   => $request->post('category'),
                'sku'           => $request->post('sku'),
                'name'          => $request->post('name'),
                'price'         => $request->post('price'),
                'description'   => $request->post('description'),
                'image'         => $request->post('image'),
            ]);

            foreach ($request->post('variants') as $variant) {
                $menuVariant = MenuVariant::create([
                    'menu_id'   => $menu->id,
                    'name'      => $variant['name'],
                    'required'  => $variant['required'] == 'true' ? Auth::user()->outlet_id : 0,
                ]);

                foreach ($variant['options'] as $option) {
                    MenuVariantOption::create([
                        'menu_variant_id'   => $menuVariant->id,
                        'name'              => $option['name'],
                        'is_default'        => $option['default'] == 'true' ? Auth::user()->outlet_id : 0,
                        'price_delta'       => $option['price'],
                    ]);
                }
            }

            DB::commit();
            return response()->json([
                'status' => true
            ]);
        } catch (\Exception $err) {
            DB::rollBack();
            Log::error($err->getMessage());
            return response()->json([
                'status' => false,
            ]);
        }
    }

    public function addon(Request $request): View
    {
        $addon = Addon::where('outlet_id', Auth::user()->outlet_id)->where('deleted_at', null)->paginate(10);

        $title = 'Menu Addon';
        return view('menu.addon.index', compact('title', 'addon'));
    }

    public function addonDetail(Request $request): View
    {
        $addon = Addon::find($request->query('id'));
        $addonVariant = AddonVariant::where('addon_id', $addon->id)->get();

        $title = 'Menu Addon';
        return view('menu.addon.detail', compact('title', 'addon', 'addonVariant'));
    }

    function addonDetailAddVariant(Request $request): \Illuminate\Http\RedirectResponse
    {
        AddonVariant::create([
            'addon_id'  => $request->post('addon_id'),
            'name'      => $request->post('name'),
            'price'     => $request->post('price'),
        ]);

        return back()->with('success', 'Create Addon variant successfully!');
    }

    public function addonDetailDelete(Request $request): \Illuminate\Http\JsonResponse
    {
        AddonVariant::where('id', $request->post('id'))->delete();

        return response()->json([
            'status' => true
        ]);
    }

    public function addonDetailEdit(Request $request): \Illuminate\Http\RedirectResponse
    {
        AddonVariant::where('id', $request->post('id'))->update([
            'name' => $request->post('name'),
            'price' => $request->post('price'),
        ]);

        return back()->with('success', 'Edit Addon variant successfully!');
    }

    public function addonDetailEditName(Request $request): void
    {
        Addon::where('id', $request->get('id'))->update([
            'name' => $request->get('name'),
        ]);
    }

    public function addonCreate(Request $request): View
    {
        $title = 'Menu Addon';
        return view('menu.addon.create', compact('title'));
    }

    public function addonStore(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            DB::beginTransaction();

            $addon = Addon::create([
                'outlet_id' => Auth::user()->outlet_id,
                'name'      => $request->post('name')
            ]);

            foreach ($request->post('variant') as $variant) {
                AddonVariant::create([
                    'addon_id'  => $addon->id,
                    'name'      => $variant['name'],
                    'price'     => $variant['price'],
                ]);
            }

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

    // JSON Response

    public function findAllMenu(Request $request): \Illuminate\Http\JsonResponse
    {
        $menu = Menu::with('category')->where('outlet_id', Auth::user()->outlet_id)->where('deleted_at', null)->get();

        return response()->json([
            'data' => $menu
        ]);
    }
}































