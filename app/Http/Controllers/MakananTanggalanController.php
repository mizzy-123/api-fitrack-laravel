<?php

namespace App\Http\Controllers;

use App\Models\Makanan;
use App\Models\Tanggalan;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MakananTanggalanController extends Controller
{
    public function store(User $user, Request $request)
    {
        $currentNow = Carbon::now();

        $date = Tanggalan::whereDate('tanggal', $currentNow)->first();
        if ($date) {
            $makanan = new Makanan;
            $makanan->name = $request->name;
            $makanan->kalori = $request->kalori;
            $makanan->save();

            $date->makanan()->attach($makanan, ['user_id' => $user->id]);
            // $date->user()->attach($user);
            $user->tanggalan()->sync($date);
            return response()->json([
                'status' => true,
                'message' => 'Berhasil Ditambah'
            ]);
        } else {
            $newDate = Tanggalan::create([
                'tanggal' => $currentNow
            ]);

            $makanan = new Makanan;
            $makanan->name = $request->name;
            $makanan->kalori = $request->kalori;
            $makanan->save();

            $newDate->makanan()->attach($makanan, ['user_id' => $user->id]);
            // $newDate->user()->attach($user);
            $user->tanggalan()->sync($newDate);
            return response()->json([
                'status' => true,
                'message' => 'Berhasil Ditambah'
            ]);
        }
    }
}
