<?php

namespace App\Http\Controllers;

use App\Models\Discount;
use App\Models\DiscountMenu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\View\View;

class DiscountController extends Controller
{
    public function index(): View
    {
        $discount = Discount::where('outlet_id', 1)->paginate(10);

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
                'outlet_id'     => 1,
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
        $discount = Discount::where('outlet_id', 1)->where('scope', 'transaction')->get();

        return response()->json([
            'data' => $discount
        ]);
    }
}
