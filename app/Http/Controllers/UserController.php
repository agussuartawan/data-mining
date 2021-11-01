<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        $title = 'User';

        return view('user.index', compact('users', 'title'));
    }

    public function create()
    {
        $title = 'User';

        return view('user.create', compact('title'));
    }
}
