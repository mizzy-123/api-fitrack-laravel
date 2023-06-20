<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserDataController extends Controller
{

    public function show(User $user)
    {
        $userData = $user->user_data()->first();

        return response()->json([
            'status' => true,
            'name' => $user->name,
            'data' => $userData
        ]);
    }

    public function getImage(User $user)
    {
        $image = $user->user_data()->first()->image;
        return response()->json([
            'status' => true,
            'image' => $image
        ]);
    }

    public function update(User $user, Request $request)
    {
        $user_data = $user->user_data()->first();

        if ($request->file('image')) {
            if ($user_data->image != null) {
                Storage::delete($user_data->image);
            }
            $image = $user_data->image = $request->file('image')->store('image-user');
            $user_data->image = $image;
        }

        $user->name = $request->name;
        $user->save();

        $user_data->usia = $request->usia;
        $user_data->b_badan = $request->b_badan;
        $user_data->t_badan = $request->t_badan;
        $user_data->kelamin = $request->kelamin;
        $user_data->save();

        return response()->json([
            'status' => true,
            'message' => 'Berhasil disimpan'
        ]);
    }
}
