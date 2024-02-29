<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Http;

class AdminAPIController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $response = Http::post('http://localhost:8001/api/user/login', [
            'email' => $request->email, 'password' => $request->password
        ]);

        if ($response === false) {
            return back()->withErrors([
                'error' => 'An Error occur',
            ]);
        } else {
            $responseArray = json_decode($response, true);
            $success = $responseArray['success'];
            if ($success) {
                $token = $responseArray['token'];
                Cookie::queue('token', $token, 60);
                return redirect()->route('dashboard');
            } else {
                return back()->withErrors([
                    'error' => $responseArray['message'],
                ]);
            }
        }
    }

    public function manageUsers(Request $request)
    {
        $token = $request->cookie('token');

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
            'Content-Type' => 'application/json',
        ])->get('http://localhost:8001/api/user/list-users');

        $responseArray = json_decode($response, true);

        if ($response === false) {
            return back()->withErrors([
                'error' => 'An Error occur',
            ]);
        } else {
            try {

                $success = $responseArray['success'];
                if ($success) {
                    return view('manage-users', ['users' => $responseArray["users"]]);
                } else {
                    return back()->withErrors([
                        'error' => $responseArray['message'],
                    ]);
                }
            } catch (\Exception $e) {
                return redirect()->route('login')->withErrors([
                    'error' => 'An Error occur',
                ]);
            }
        }
    }

    public function createUser(Request $request)
    {
        $token = $request->cookie('token');

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
            'Content-Type' => 'application/json',
        ])->get('http://localhost:8001/api/list-roles');


        $responseArray = json_decode($response, true);


        try {

            $success = $responseArray['success'];
            if ($success) {
                return view('create-user', ['roles' => $responseArray["roles"]]);
            } else {
                return back()->withErrors([
                    'error' => $responseArray['message'],
                ]);
            }
        } catch (\Exception $e) {
            return redirect()->route('login')->withErrors([
                'error' => 'An Error occur',
            ]);
        }
    }
}
