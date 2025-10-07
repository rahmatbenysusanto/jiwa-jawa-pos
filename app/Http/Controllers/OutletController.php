<?php

namespace App\Http\Controllers;

use App\Models\Outlet;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OutletController extends Controller
{
    public function index(): View
    {
        $outlets = Outlet::paginate(10);

        $title = 'Outlet';
        return view('outlet.index', compact('title', 'outlets'));
    }

    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        Outlet::create([
            'name'      => $request->post('name'),
            'no_hp'     => $request->post('no_hp'),
            'address'   => $request->post('address'),
        ]);

        return back()->with('success', 'Outlet created successfully');
    }
}
