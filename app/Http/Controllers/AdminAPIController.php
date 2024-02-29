<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Http;

class AdminAPIController extends Controller
{
    public function login(Request $request)
    {

        Cookie::queue(Cookie::forget('token'));
        Cookie::queue(Cookie::forget('laravel_session'));
        Cookie::queue(Cookie::forget('XSRF-TOKEN'));
        Cookie::queue(Cookie::forget('XSRF-st-last-access-token-update'));


        $response = Http::post('http://localhost:8001/api/user/login', [
            'email' => $request->email, 'password' => $request->password
        ]);


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

    public function registerUser(Request $request)
    {
        $token = $request->cookie('token');
        try {

            $oldKey = 'confirm_password';
            $newKey = 'password_confirmation';

            if (array_key_exists($oldKey, $request->all())) {
                $newValue = $request[$oldKey];
                unset($request[$oldKey]);
                $request[$newKey] = $newValue;
            }
        } catch (\Exception $e) {
            redirect()->back();
        }

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
            'Content-Type' => 'application/json',
        ])->post('http://localhost:8001/api/user/register', [
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'password_confirmation' => $request->password_confirmation,
            'role' => $request->role
        ]);

        $responseArray = json_decode($response, true);
        $success = $responseArray['success'];

        if ($success) {
            return redirect()->route('manage-users');
        } else {
            return back()->withErrors([
                'error' => $responseArray['message'],
            ]);
        }
    }

    public function logout(Request $request){

        $token = $request->cookie('token');

        Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
            'Content-Type' => 'application/json',
        ])->post('http://localhost:8001/api/user/logout');

        Cookie::queue(Cookie::forget('token'));
        Cookie::queue(Cookie::forget('laravel_session'));
        Cookie::queue(Cookie::forget('XSRF-TOKEN'));
        Cookie::queue(Cookie::forget('XSRF-st-last-access-token-update'));

        return redirect()->route('login');

    }
}
