<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ShowAllAktivitasMakananController extends Controller
{
    public function show(User $user)
    {
        // $makanan = $user->tanggalan()->whereDate('tanggal', $request->tanggal)->first()->makanan()->get();
        // $aktivitas = $user->tanggalan()->whereDate('tanggal', $request->tanggal)->first()->aktivitas()->get();
        $tanggal = $user->tanggalan()->orderBy('tanggal', 'desc')->with('makanan', 'aktivitas')->distinct()->get();
        return response()->json([
            'status' => true,
            'data' => $tanggal

        ]);
    }
}
