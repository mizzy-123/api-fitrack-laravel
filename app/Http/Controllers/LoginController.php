<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function authenticate(Request $request)
    {
        // $credentials = $request->validate([
        //     'email' => ['required', 'email:dns'],
        //     'password' => ['required'],
        // ]);

        $credentials = [
            'email' => $request->email,
            'password' => $request->password
        ];

        if (Auth::attempt($credentials)) {
            // $request->session()->regenerate();
            return response()->json([
                'status' => true
            ]);
        } else {
            return response()->json([
                'status' => false
            ]);
        }
        // return response()->json([
        //     'status' => $credentials
        // ]);
    }

    public function logout()
    {
        Auth::logout();

        // request()->session()->invalidate();

        // request()->session()->regenerateToken();

        return response()->json([
            'message' => 'logout succesfull'
        ]);
    }
}
