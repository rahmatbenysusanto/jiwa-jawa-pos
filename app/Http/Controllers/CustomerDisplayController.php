<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class CustomerDisplayController extends Controller
{
    public function index(): View
    {
        $title = 'Customer Display';
        return view('customer-display.index', compact('title'));
    }
}
