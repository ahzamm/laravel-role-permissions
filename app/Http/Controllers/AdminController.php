<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return redirect()
                ->back()
                ->withErrors(['email' => 'User not found']);
        }
        if (!Hash::check($request->password, $user->password)) {
            return redirect()
                ->back()
                ->withErrors(['password' => 'Invalid credentials']);
        }

        $token = $user->createToken('mytoken')->plainTextToken;
        return redirect()->route('dashboard')->withCookie(cookie('token', $token));
    }
}
