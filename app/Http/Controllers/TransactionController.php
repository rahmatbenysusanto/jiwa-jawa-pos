<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class TransactionController extends Controller
{
    public function index(): View
    {
        $title = 'Transaction';
        return view('transaction.index', compact('title'));
    }
}
