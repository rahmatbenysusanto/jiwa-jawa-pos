<?php

namespace App\Http\Controllers;

use App\Models\Discount;
use App\Models\DiscountMenu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\View\View;

class DiscountController extends Controller
{
    public function index(Request $request): View
    {
        $discount = Discount::where('outlet_id', Auth::user()->outlet_id)
            ->when($request->query('code'), function ($query) use ($request) {
                return $query->where('code', 'LIKE', '%' . $request->query('code') . '%');
            })
            ->when($request->query('name'), function ($query) use ($request) {
                return $query->where('name', 'LIKE', '%' . $request->query('name') . '%');
            })
            ->when($request->query('scope'), function ($query) use ($request) {
                return $query->where('scope', $request->query('scope'));
            })
            ->when($request->query('type'), function ($query) use ($request) {
                return $query->where('type', $request->query('type'));
            })
            ->when($request->query('status'), function ($query) use ($request) {
                return $query->where('status', $request->query('status'));
            })
            ->whereNull('deleted_at')
            ->orderBy('id', 'desc')
            ->paginate(10)
            ->appends([
                'code'  => $request->query('code'),
                'name'  => $request->query('name'),
                'scope' => $request->query('scope'),
                'type'  => $request->query('type'),
                'status' => $request->query('status'),
            ]);

        $title = 'Discount';
        return view('discount.index', compact('title', 'discount'));
    }

    public function create(): View
    {
        $title = 'Discount';
        return view('discount.create', compact('title'));
    }

    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        try {
            DB::beginTransaction();

            $discount = Discount::create([
                'outlet_id'     => Auth::user()->outlet_id,
                'name'          => $request->post('name'),
                'code'          => empty($request->post('code')) ? 'DISC-' . strtoupper(Str::random(5)) : $request->post('code'),
                'scope'         => $request->post('scope'),
                'type'          => $request->post('type'),
                'value'         => $request->post('value') ?: 0,
                'max_value'     => $request->post('max_value') ?: 0,
                'min_transaction_amount' => $request->post('min_transaction_amount') ?: 0,
                'start_date'    => $request->post('start_date'),
                'end_date'      => $request->post('end_date'),
            ]);

            if (strtolower($request->post('scope')) == 'product' && $request->post('menu')) {
                foreach ($request->post('menu') as $menu) {
                    DiscountMenu::create([
                        'discount_id' => $discount->id,
                        'menu_id'     => $menu,
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('discount')->with('success', 'Discount created successfully.');
        } catch (\Exception $err) {
            DB::rollBack();
            Log::error($err->getMessage());
            return back()->with('error', 'Discount create failed');
        }
    }

    public function findDiscountTransaction(): \Illuminate\Http\JsonResponse
    {
        $discount = Discount::where('outlet_id', Auth::user()->outlet_id)
            ->where('scope', 'transaction')
            ->where('status', 'active')
            ->whereNull('deleted_at')
            ->get();

        return response()->json([
            'data' => $discount
        ]);
    }

    public function detail(Request $request): View
    {
        $discount = Discount::where('id', $request->query('id'))
            ->where('outlet_id', Auth::user()->outlet_id)
            ->firstOrFail();

        $discountMenu = DiscountMenu::with('menu')->where('discount_id', $discount->id)->get();

        $title = 'Discount';
        return view('discount.detail', compact('title', 'discount', 'discountMenu'));
    }

    public function edit(Request $request): View
    {
        $discount = Discount::where('id', $request->query('id'))
            ->where('outlet_id', Auth::user()->outlet_id)
            ->firstOrFail();

        $discountMenu = DiscountMenu::with('menu')->where('discount_id', $discount->id)->get();

        $title = 'Discount';
        return view('discount.edit', compact('title', 'discount', 'discountMenu'));
    }

    public function update(Request $request): \Illuminate\Http\RedirectResponse
    {
        try {
            DB::beginTransaction();

            Discount::where('id', $request->post('id'))
                ->where('outlet_id', Auth::user()->outlet_id)
                ->update([
                    'name'          => $request->post('name'),
                    'code'          => empty($request->post('code')) ? 'DISC-' . strtoupper(Str::random(5)) : $request->post('code'),
                    'scope'         => $request->post('scope'),
                    'type'          => $request->post('type'),
                    'value'         => $request->post('value') ?: 0,
                    'max_value'     => $request->post('max_value') ?: 0,
                    'min_transaction_amount' => $request->post('min_transaction_amount') ?: 0,
                    'start_date'    => $request->post('start_date'),
                    'end_date'      => $request->post('end_date'),
                    'updated_at'    => date('Y-m-d H:i:s')
                ]);

            if (strtolower($request->post('scope')) == 'product' && $request->post('menu')) {
                DiscountMenu::where('discount_id', $request->post('id'))->delete();
                foreach ($request->post('menu') as $menu) {
                    DiscountMenu::create([
                        'discount_id' => $request->post('id'),
                        'menu_id'     => $menu,
                    ]);
                }
            } else if (strtolower($request->post('scope')) != 'product') {
                DiscountMenu::where('discount_id', $request->post('id'))->delete();
            }

            DB::commit();
            return redirect()->route('discount')->with('success', 'Discount updated successfully.');
        } catch (\Exception $err) {
            DB::rollBack();
            Log::error($err->getMessage());
            return back()->with('error', 'Discount update failed');
        }
    }

    public function delete(Request $request): \Illuminate\Http\JsonResponse
    {
        Discount::where('id', $request->get('id'))
            ->where('outlet_id', Auth::user()->outlet_id)
            ->update([
                'deleted_at' => now(),
            ]);

        return response()->json([
            'status' => true
        ]);
    }
}
