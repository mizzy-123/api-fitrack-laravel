<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email:dns|unique:users',
            'password' => 'required|min:6'
        ]);

        if ($request->c_pass == $validated['password']) {

            $validated['password'] = Hash::make($validated['password']);

            $user = User::create($validated);
            if ($user) {
                return response()->json([
                    'status' => true,
                    'message' => 'Register Berhasil'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Register Gagal'
                ]);
            }
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Konfirmasi password salah'
            ]);
        }
    }
}
