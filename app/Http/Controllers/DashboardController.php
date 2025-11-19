<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $transactionCount = Transaction::where('outlet_id', Auth::user()->outlet_id)
            ->whereDate('transaction_date', date('Y-m-d'))
            ->where('transaction_status', '!=', 'cancelled')
            ->count();

        $totalCost = Transaction::where('outlet_id', Auth::user()->outlet_id)
            ->whereDate('transaction_date', date('Y-m-d'))
            ->where('transaction_status', '!=', 'cancelled')
            ->sum('total');

        $transactionDineIn = Transaction::where('outlet_id', Auth::user()->outlet_id)
            ->where('transaction_delivery', 'dine in')
            ->where('transaction_status', '!=', 'cancelled')
            ->whereDate('transaction_date', date('Y-m-d'))
            ->sum('total');

        $transactionTakeAway = Transaction::where('outlet_id', Auth::user()->outlet_id)
            ->where('transaction_delivery', 'takeaway')
            ->where('transaction_status', '!=', 'cancelled')
            ->whereDate('transaction_date', date('Y-m-d'))
            ->sum('total');

        $transactionHpp = Transaction::where('outlet_id', Auth::user()->outlet_id)
            ->where('transaction_status', '!=', 'cancelled')
            ->whereDate('transaction_date', date('Y-m-d'))
            ->sum('hpp');

        $topSelling = TransactionDetail::query()
            ->join('transaction as t', 't.id', '=', 'transaction_detail.transaction_id')
//            ->whereBetween('t.transaction_date', [$request->query('start', date('Y-m-01')), $request->query('end', date('Y-m-d'))])
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
            ->limit(5)
            ->get();

        $agg = TransactionDetail::query()
            ->from('transaction_detail as td')
            ->join('transaction as t', 't.id', '=', 'td.transaction_id')
//            ->whereBetween('t.transaction_date', [$request->query('start', date('Y-m-01')), $request->query('end', date('Y-m-d'))])
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
            ->limit(5)
            ->get();

        $materialMinStock = DB::table('material as m')
            ->leftJoin('inventory as i', 'i.material_id', '=', 'm.id')
            ->select(
                'm.id',
                'm.name',
                'm.sku',
                'm.image',
                DB::raw('COALESCE(SUM(i.stock), 0) as total_stock')
            )
            ->groupBy('m.id', 'm.name', 'm.sku', 'm.image')
            ->orderBy('total_stock', 'asc')
            ->limit(5)
            ->get();

        $title = 'Dashboard';
        return view('dashboard.index', compact('title', 'transactionCount', 'totalCost', 'transactionDineIn', 'transactionTakeAway', 'transactionHpp', 'topSelling', 'lowMoving', 'materialMinStock'));
    }

    public function chartTransaction(): \Illuminate\Http\JsonResponse
    {
        $startDate = now()->subDays(12)->startOfDay();
        $endDate   = now()->endOfDay();

        $transactions = DB::table('transaction')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->selectRaw('DATE(created_at) as date, SUM(total) as total_trans, SUM(hpp) as total_hpp')
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->keyBy('date');

        $label = [];
        $totalRevenue = [];
        $totalHpp = [];

        for ($i = 12; $i >= 0; $i--) {
            $dateObj = now()->subDays($i);

            $label[] = $dateObj->format('d M y');

            $date = $dateObj->format('Y-m-d');

            $totalRevenue[] = isset($transactions[$date]) ? (float) $transactions[$date]->total_trans : 0;

            $totalHpp[] = isset($transactions[$date]) ? (float) $transactions[$date]->total_hpp : 0;
        }

        return response()->json([
            'labels'    => $label,
            'revenue'   => $totalRevenue,
            'hpp'       => $totalHpp,
        ]);
    }

    public function paymentMethodTransaction(): \Illuminate\Http\JsonResponse
    {
        $cash = Transaction::whereBetween('created_at', [date('Y-m-d 00:00:00'), date('Y-m-d 23:59:59')])
            ->whereNot('transaction_status', 'cancelled')
            ->where('payment_method_id', 1)
            ->count();

        $qris = Transaction::whereBetween('created_at', [date('Y-m-d 00:00:00'), date('Y-m-d 23:59:59')])
            ->whereNot('transaction_status', 'cancelled')
            ->where('payment_method_id', 2)
            ->count();

        $debit = Transaction::whereBetween('created_at', [date('Y-m-d 00:00:00'), date('Y-m-d 23:59:59')])
            ->whereNot('transaction_status', 'cancelled')
            ->where('payment_method_id', 3)
            ->count();

        return response()->json([
            'cash'    => $cash,
            'qris'    => $qris,
            'debit'   => $debit,
        ]);
    }

    public function chartTransactionByCategoryMenu(): \Illuminate\Http\JsonResponse
    {
        $coffee = TransactionDetail::with(['menu', 'menu.category'])
            ->whereBetween('created_at', [date('Y-m-d 00:00:00'), date('Y-m-d 23:59:59')])
            ->whereHas('menu.category', function ($query) {
                $query->whereIn('name', ['Coffee']);
            })
            ->sum('total');

        $nonCoffee = TransactionDetail::with(['menu', 'menu.category'])
            ->whereBetween('created_at', [date('Y-m-d 00:00:00'), date('Y-m-d 23:59:59')])
            ->whereHas('menu.category', function ($query) {
                $query->whereIn('name', ['Ice Milk', 'Non Coffee', 'Jus']);
            })
            ->sum('total');

        $food = TransactionDetail::with(['menu', 'menu.category'])
            ->whereBetween('created_at', [date('Y-m-d 00:00:00'), date('Y-m-d 23:59:59')])
            ->whereHas('menu.category', function ($query) {
                $query->whereIn('name', ['Food']);
            })
            ->sum('total');

        $snack = TransactionDetail::with(['menu', 'menu.category'])
            ->whereBetween('created_at', [date('Y-m-d 00:00:00'), date('Y-m-d 23:59:59')])
            ->whereHas('menu.category', function ($query) {
                $query->whereIn('name', ['Snack']);
            })
            ->sum('total');

        return response()->json([
            'data'  =>  [
                'coffee'        => $coffee,
                'non_coffee'    => $nonCoffee,
                'food'          => $food,
                'snack'         => $snack,
            ]
        ]);
    }
}
