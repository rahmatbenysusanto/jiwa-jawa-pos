<?php

namespace App\Http\Controllers;

use App\Models\AccessMenu;
use App\Models\Outlet;
use App\Models\User;
use Illuminate\Http\Request;
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
}
