<?php

namespace App\Http\Controllers;

use App\Models\KasRekonsiliasi;
use App\Models\Menu;
use App\Models\Outlet;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\TransactionDiscount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ReportController extends Controller
{
    public function sales(Request $request): View
    {
        $transaction = Transaction::selectRaw('
                DATE(transaction_date) AS date,
                COUNT(id) AS total_order,
                SUM(qty) AS total_item,
                SUM(total) AS grand_total,
                SUM(hpp) AS total_hpp
            ')
            ->groupBy(DB::raw('DATE(transaction_date)'))
            ->orderBy('date', 'desc')
            ->paginate(10);

        $title = 'Sales Report Daily';
        return view('report.sales', compact('title', 'transaction'));
    }

    public function salesMonthly()
    {
        $transaction = $transaction = Transaction::selectRaw('
                YEAR(transaction_date) as year,
                MONTH(transaction_date) as month,
                COUNT(id) as total_order,
                SUM(qty) as total_item,
                SUM(total) as grand_total,
                SUM(hpp) as total_hpp
            ')
            ->where('transaction_status', 'normal')
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->paginate(10);

        $title = 'Sales Report Monthly';
        return view('report.sales-monthly', compact('title', 'transaction'));
    }

    public function salesDetail(Request $request): View
    {
        $title = 'Sales Report';
        return view('report.sales-detail', compact('title'));
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
        $material = DB::table('material')
            ->leftJoin('material_category', 'material.category_id', '=', 'material_category.id')
            ->leftJoin('material_unit', 'material.base_unit_id', '=', 'material_unit.id')
            ->leftJoin('inventory', 'inventory.material_id', '=', 'material.id')
            ->select([
                'material.id',
                'material.name',
                'material.sku',
                'material_category.name as category',
                'material_unit.symbol',
                DB::raw('COALESCE(SUM(inventory.stock), 0) as stock'),
            ])
            ->groupBy(['material.id', 'material.name', 'material.sku', 'material_category.name', 'material_unit.symbol'])
            ->orderBy('stock', 'ASC')
            ->paginate(10);

        $title = 'Stock Report';
        return view('report.stock', compact('title', 'material'));
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

    public function kasKonsolidasi(Request $request): View
    {
        $kasKonsolidasi = KasRekonsiliasi::latest()->paginate(10);

        $title = 'Kas';
        return view('report.kas-konsolidasi', compact('title', 'kasKonsolidasi'));
    }

    public function kasKonsolidasiCreate(): View
    {
        $title = 'Kas';
        return view('report.kas-konsolidasi-create', compact('title'));
    }

    public function kasKonsolidasiDataTransaction(Request $request)
    {
        $transaction = Transaction::whereBetween('transaction_date', [
                $request->tanggal.' 00:00:00',
                $request->tanggal.' 23:59:59'
            ])
            ->select([
                // grand total
                DB::raw('COALESCE(SUM(total), 0) AS total'),
                DB::raw('COALESCE(SUM(hpp), 0) AS hpp'),

                // breakdown total per payment method
                DB::raw('COALESCE(SUM(CASE WHEN payment_method_id = 1 THEN total END), 0) AS total_cash'),
                DB::raw('COALESCE(SUM(CASE WHEN payment_method_id = 2 THEN total END), 0) AS total_qris'),
                DB::raw('COALESCE(SUM(CASE WHEN payment_method_id = 3 THEN total END), 0) AS total_debit'),
            ])
            ->where('transaction_status', 'normal')
            ->where('payment_status', 'paid')
            ->first();

        return response()->json([
            'status'   => true,
            'data'     => $transaction
        ]);
    }
}
