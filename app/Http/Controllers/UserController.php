<?php

namespace App\Http\Controllers;

use App\User;
use \App\Http\Requests\StoreUserRequest;
use Illuminate\Http\Request;
use \App\Http\Requests\UpdateUserRequest;
use Auth;
use File;

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

    public function update(User $user, UpdateUserRequest $request)
    {
        $user->update($request->validated());

        return redirect()->route('user.index')->with('success', 'Data berhasil diubah');
    }

    public function profile()
    {
        return view('user.profile', ['title' => 'User']);
    }

    public function profile_update(Request $request)
    {
        $user = Auth::user();
        $messages = [
            'name.required' => 'Nama tidak boleh kosong.',
            'name.min' => 'Nama harus terdiri dari minimal 3 huruf.',
            'name.max' => 'Nama harus terdiri dari maximal 50 huruf.',
            'email.required' => 'Email tidak boleh kosong.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan.',
            'avatar.image' => 'File harus berupa gambar.',
            'avatar.file' => 'File harus berupa gambar.',
        ];

        $validatedData = $request->validate([
            'name' => 'required|min:3|max:50',
            'email' => 'required|email:rfc,dns|unique:users,email,' . auth()->user()->id,
            'avatar' => 'image|file'
        ], $messages);

        if ($request->file('avatar')) {
            $file = $request->file('avatar');
            $file_name = 'avatar_' . md5($user->id) . '.' . $file->getClientOriginalExtension();
            $file->move('avatar',$file_name);
            $validatedData['avatar'] = $file_name;
            if ($user->avatar) {
                File::delete('avatar/' . $user->avatar);
            }
        }


        $user->update($validatedData);

        return redirect()->route('user.profile')->with('success', 'Profil berhasil diperbarui');
    }

    public function avatar_delete()
    {
        $user = Auth::user();
        File::delete('avatar/' . $user->avatar);
        $user->update(['avatar' => NULL]);
        return redirect()->route('user.profile')->with('success', 'Foto berhasil dihapus');
    }
}
