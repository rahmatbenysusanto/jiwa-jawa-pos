<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

        $transactionDelivery = Transaction::where('outlet_id', Auth::user()->outlet_id)
            ->where('transaction_delivery', 'delivery')
            ->where('transaction_status', '!=', 'cancelled')
            ->whereDate('transaction_date', date('Y-m-d'))
            ->sum('total');

        $title = 'Dashboard';
        return view('dashboard.index', compact('title', 'transactionCount', 'totalCost', 'transactionDineIn', 'transactionTakeAway', 'transactionDelivery'));
    }
}
