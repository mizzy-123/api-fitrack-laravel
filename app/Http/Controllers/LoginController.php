<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email:dns'],
            'password' => ['required'],
        ]);

        // $credentials = [
        //     'email' => $request->email,
        //     'password' => $request->password
        // ];

        if (Auth::attempt($credentials)) {
            // $request->session()->regenerate();
            $data = User::where('email', $credentials['email'])->get();
            return response()->json([
                'status' => true,
                'user' => $data
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
