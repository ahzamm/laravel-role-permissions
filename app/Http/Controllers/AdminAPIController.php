<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class AdminAPIController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $url = 'http://localhost:8001/api/user/login';
        $data = ['email' => $request->email, 'password' => $request->password];
        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
        curl_close($ch);

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

        $url = 'http://localhost:8001/api/user/list-users';
        $ch = curl_init($url);


        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $token,
        ]);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
        $responseArray = json_decode($response, true);
        curl_close($ch);

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
}
