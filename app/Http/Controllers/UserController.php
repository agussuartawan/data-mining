<?php

namespace App\Http\Controllers;

use App\User;
use \App\Http\Requests\StoreUserRequest;

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

    public function store(StoreUserRequest $request)
    {
        User::create($request->validated());

        return redirect()->route('user.index')->with('success', 'Data berhasil disimpan');
    }

    public function edit(User $user)
    {
        $title = 'User';
        return view('user.edit', compact('user', 'title'));
    }

    public function update(User $user, StoreUserRequest $request)
    {
        $user->update($request->validated());

        return redirect()->route('user.index')->with('success', 'Data berhasil diubah');
    }
}
