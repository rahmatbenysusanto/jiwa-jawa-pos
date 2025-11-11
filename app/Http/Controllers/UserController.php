<?php

namespace App\Http\Controllers;

use App\Models\AccessMenu;
use App\Models\Outlet;
use App\Models\User;
use App\Models\UserHasMenu;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(): View
    {
        $users = User::with('outlet')->paginate(10);

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
        try {
            DB::beginTransaction();

            User::create([
                'name'      => $request->post('name'),
                'username'  => $request->post('username'),
                'email'     => $request->post('email'),
                'outlet_id' => $request->post('outlet'),
                'no_hp'     => $request->post('noHp'),
                'password'  => Hash::make($request->post('password')),
            ]);

            DB::commit();

            return response()->json([
                'status' => true,
            ]);
        } catch (\Exception $err) {
            DB::rollBack();
            Log::error($err->getMessage());
            Log::error($err->getLine());
            return response()->json([
                'status' => false,
            ]);
        }
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

    public function menu(Request $request): View
    {
        $userMenu = AccessMenu::with([
            'userHasMenu' => function ($query) use ($request) {
                $query->where('user_id', $request->query('id'));
            }
        ])->get();

        $title = 'User';
        return view('user.menu', compact('title', 'userMenu'));
    }

    public function changeMenu(Request $request): JsonResponse
    {
        $menuId = $request->post('id');
        $userId = $request->post('userId');

        $checkUserHasMenu = UserHasMenu::where('user_id', $userId)->where('access_menu_id', $menuId)->first();
        if ($checkUserHasMenu == null) {
            UserHasMenu::create([
                'user_id'           => $userId,
                'access_menu_id'    => $menuId,
            ]);
        } else {
            UserHasMenu::where('user_id', $userId)->where('access_menu_id', $menuId)->delete();
        }

        return response()->json([
            'status' => true,
        ]);
    }
}







































