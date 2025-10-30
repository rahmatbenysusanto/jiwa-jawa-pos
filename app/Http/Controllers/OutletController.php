<?php

namespace App\Http\Controllers;

use App\Models\Outlet;
use App\Models\SliderCustomer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

    public function wifi(Request $request): \Illuminate\Http\RedirectResponse
    {
        Outlet::where('id', $request->post('id'))->update(['wifi' => $request->post('wifi')]);

        return back()->with('success', 'Outlet wifi updated successfully');
    }

    public function show(Request $request): \Illuminate\Http\JsonResponse
    {
        $outlet = Outlet::find($request->query('id'));

        return response()->json([
            'data' => $outlet,
        ]);
    }

    public function slider(Request $request): View
    {
        $sliders = SliderCustomer::where('outlet_id', $request->query('id'))->get();

        $title = 'Outlet';
        return view('outlet.slider', compact('title', 'sliders'));
    }

    public function storeSlider(Request $request): \Illuminate\Http\RedirectResponse
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $file = $request->file('image');
        $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('images/slider'), $fileName);

        SliderCustomer::create([
            'outlet_id' => Auth::user()->outlet_id,
            'image'     => $fileName,
        ]);

        return back()->with('success', 'Slider created successfully');
    }

    public function deleteSlider(Request $request): \Illuminate\Http\RedirectResponse
    {
        SliderCustomer::where('id', $request->query('id'))->delete();

        return back()->with('success', 'Slider deleted successfully');
    }
}
