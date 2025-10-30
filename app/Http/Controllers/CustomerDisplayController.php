<?php

namespace App\Http\Controllers;

use App\Models\SliderCustomer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class CustomerDisplayController extends Controller
{
    public function index(): View
    {
        $slider = SliderCustomer::where('outlet_id', Auth::user()->outlet_id)->get();

        $title = 'Customer Display';
        return view('customer-display.index', compact('title', 'slider'));
    }
}
