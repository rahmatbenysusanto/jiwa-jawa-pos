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
                return $query->where('code', 'LIKE', '%'.$request->query('code').'%');
            })
            ->when($request->query('name'), function ($query) use ($request) {
                return $query->where('name', 'LIKE', '%'.$request->query('name').'%');
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
            ->paginate(10)
            ->appends([
                'code'  => $request->query('code'),
                'name'  => $request->query('name'),
                'scope' => $request->query('scope'),
                'type'  => $request->query('type'),
                'status'=> $request->query('status'),
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
                'code'          => $request->post('code') == null ? 'DISC-'.strtoupper(Str::random(5)) : $request->post('code'),
                'scope'         => $request->post('scope'),
                'type'          => $request->post('type'),
                'value'         => $request->post('value'),
                'max_value'     => $request->post('max_value') ?? 0,
                'min_transaction_amount' => $request->post('min_transaction_amount') ?? 0,
                'start_date'    => $request->post('start_date'),
                'end_date'      => $request->post('end_date'),
            ]);

            if ($request->post('scope') == 'Product') {
                foreach ($request->post('menu') as $menu) {
                    Log::info($menu);
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
        $discount = Discount::where('outlet_id', Auth::user()->outlet_id)->where('scope', 'transaction')->get();

        return response()->json([
            'data' => $discount
        ]);
    }

    public function detail(Request $request): View
    {
        $discount = Discount::find($request->query('id'));
        $discountMenu = DiscountMenu::with('menu')->where('discount_id', $discount->id)->get();

        $title = 'Discount';
        return view('discount.detail', compact('title', 'discount', 'discountMenu'));
    }

    public function edit(Request $request): View
    {
        $title = 'Discount';
        return view('discount.edit', compact('title'));
    }

    public function update(Request $request): \Illuminate\Http\RedirectResponse
    {
        return redirect()->route('discount')->with('success', 'Discount updated successfully.');
    }

    public function delete(Request $request): \Illuminate\Http\JsonResponse
    {
        Discount::where('id', $request->get('id'))->update([
            'deleted_at' => now(),
        ]);

        return response()->json([
            'status' => true
        ]);
    }
}
