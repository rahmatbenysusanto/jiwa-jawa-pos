<?php

namespace App\Http\Controllers;

use App\Models\AccessMenu;
use App\Models\Outlet;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(): View
    {
        $users = User::paginate(10);

        $title = 'User';
        return view('user.index', compact('title', 'users'));
    }

    public function create(): View
    {
        $outlets = Outlet::all();
        $access_menu = AccessMenu::all();

        $title = 'User';
        return view('user.create', compact('title', 'outlets', 'access_menu'));
    }

    public function edit(Request $request): View
    {
        $outlets = Outlet::all();
        $user = User::find($request->query('id'));

        $title = 'User';
        return view('user.edit', compact('title', 'outlets', 'user'));
    }

    public function store(Request $request): JsonResponse
    {
        User::create([
            'name'      => $request->post('name'),
            'username'  => $request->post('username'),
            'email'     => $request->post('email'),
            'outlet_id' => $request->post('outlet'),
            'no_hp'     => $request->post('noHp'),
            'password'  => Hash::make($request->post('password')),
        ]);

        return response()->json([
            'success' => true,
        ]);
    }

    public function update(Request $request): JsonResponse
    {
        User::where('id', $request->post('id'))->update([
            'name'      => $request->post('name'),
            'username'  => $request->post('username'),
            'email'     => $request->post('email'),
            'outlet_id' => $request->post('outlet'),
            'no_hp'     => $request->post('noHp'),
        ]);

        if ($request->post('password') != '********') {
            User::where('id', $request->post('id'))->update([
                'password' => Hash::make($request->post('password')),
            ]);
        }

        return response()->json([
            'success' => true,
        ]);
    }
}
