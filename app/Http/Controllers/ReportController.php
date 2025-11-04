<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Outlet;
use App\Models\TransactionDetail;
use App\Models\TransactionDiscount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ReportController extends Controller
{
    public function sales(): View
    {
        $title = 'Sales Report';
        return view('report.sales', compact('title'));
    }

    public function topSelling(Request $request): View
    {
        $topSelling = TransactionDetail::query()
            ->join('transaction as t', 't.id', '=', 'transaction_detail.transaction_id')
            ->whereBetween('t.transaction_date', [$request->query('start', date('Y-m-01')), $request->query('end', date('Y-m-d'))])
//            ->where('t.payment_status', '=', 'paid')
            ->groupBy('transaction_detail.menu_id')
            ->select([
                'transaction_detail.menu_id',
                DB::raw('SUM(transaction_detail.qty) as sold_quantity'),
                DB::raw('SUM(transaction_detail.qty * transaction_detail.price) as total_sales'),
                DB::raw('COUNT(DISTINCT transaction_detail.transaction_id) as sales_count'),
            ])
            ->orderByDesc('sold_quantity')
            ->orderByDesc('total_sales')
            ->with(['menu', 'menu.category'])
//            ->limit(10)
            ->get();

        $title = 'Top Selling Report';
        return view('report.top-selling', compact('title', 'topSelling'));
    }

    public function lowMoving(Request $request): View
    {
        $agg = TransactionDetail::query()
            ->from('transaction_detail as td')
            ->join('transaction as t', 't.id', '=', 'td.transaction_id')
            ->whereBetween('t.transaction_date', [$request->query('start', date('Y-m-01')), $request->query('end', date('Y-m-d'))])
//            ->where('t.payment_status', '=', 'paid')
            ->groupBy('td.menu_id')
            ->selectRaw('td.menu_id,
                 SUM(td.qty) as sold_quantity,
                 SUM(td.qty * td.price) as total_sales,
                 COUNT(DISTINCT td.transaction_id) as sales_count');

        $lowMoving = Menu::query()
            ->from('menu as m')
            ->leftJoinSub($agg, 'x', fn($j) => $j->on('x.menu_id', '=', 'm.id'))
            ->select([
                'm.*',
                DB::raw('COALESCE(x.sold_quantity, 0) as sold_quantity'),
                DB::raw('COALESCE(x.total_sales, 0) as total_sales'),
                DB::raw('COALESCE(x.sales_count, 0) as sales_count'),
            ])
            ->orderBy('sold_quantity', 'asc')
            ->orderBy('total_sales', 'asc')
            ->limit(20)
            ->get();

        $title = 'Low Moving Report';
        return view('report.low-moving', compact('title', 'lowMoving'));
    }

    public function stock(): View
    {
        $title = 'Stock Report';
        return view('report.stock', compact('title'));
    }

    public function discount(): View
    {
        $discount = TransactionDiscount::with('transaction', 'transactionDetail', 'transactionDetail.menu', 'discount')
            ->whereHas('transaction', function ($query) {
                return $query->where('outlet_id', Auth::user()->outlet_id);
            })
            ->latest()
            ->paginate(10);

        $title = 'Discount Report';
        return view('report.discount', compact('title', 'discount'));
    }

    public function storePerformance(): View
    {
        $outlet = Outlet::all();

        $title = 'Store Performance Report';
        return view('report.store-performance', compact('title', 'outlet'));
    }
}
