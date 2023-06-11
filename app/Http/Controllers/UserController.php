<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function ImageStore(User $user, Request $request)
    {
        $validated = $request->validate([
            'image' => 'image|file'
        ]);

        if ($request->file('image')) {

            if ($user->image != null) {
                Storage::delete($user->image);
            }

            $validated['image'] = $request->file('image')->store('image-user');

            $cek = $user->update($validated);
            if ($cek) {
                return response()->json([
                    'status' => true,
                    'message' => 'Gambar berhasil di upload'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'messsage' => 'Gambar gagal di upload'
                ]);
            }
        } else {
            return response()->json([
                'status' => false,
                'messsage' => 'Gambar gagal di upload'
            ]);
        }
    }

    public function ImageDelete(User $user)
    {
        if ($user->image != null) {
            Storage::delete($user->image);
            $user->image = null;
            $user->save();

            return response()->json([
                'status' => true,
                'messsage' => 'Gambar berhasil dihapus'
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Gambar gagal dihapus'
            ]);
        }
    }
}
