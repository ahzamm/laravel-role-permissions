<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\User;

class AdminController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::guard('web')->attempt($credentials)) {
            return redirect()->route('dashboard');
        }
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function manageUsers()
    {
        if (!Auth::user()->hasRole('admin')) {
            return redirect()
                ->route('login')
                ->withErrors(['message' => 'Unauthenticated']);
        }

        $users = User::with('roles:name')->get();
        $users->transform(function ($user) {
            return [
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->roles->pluck('name')->implode(', '),
            ];
        });
        return view('manage-users', ['users' => $users]);
    }
}
