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
        $transactionCount = Transaction::where('outlet_id', Auth::user()->outlet_id)->whereDate('transaction_date', date('Y-m-d'))->count();
        $totalCost = Transaction::where('outlet_id', Auth::user()->outlet_id)->whereDate('transaction_date', date('Y-m-d'))->sum('total');

        $title = 'Dashboard';
        return view('dashboard.index', compact('title', 'transactionCount', 'totalCost'));
    }
}
