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

        // $date = Tanggalan::whereDate('tanggal', $currentNow)->first();
        $date = $user->tanggalan()->whereDate('tanggal', $currentNow)->first();
        if ($date) {
            $makanan = new Makanan;
            $makanan->name = $request->name;
            $makanan->takaran = $request->takaran;
            $makanan->kalori = $request->kalori;
            $makanan->save();

            $date->makanan()->attach($makanan, ['user_id' => $user->id]);
            // $date->user()->attach($user);
            // $user->tanggalan()->sync($date);
            // if (!$user->tanggalan()->exists()) {
            //     $user->tanggalan()->attach($date);
            // }
            if (!$date) {
                $user->tanggalan()->attach($date);
            }
            return response()->json([
                'status' => true,
                'message' => 'Berhasil Ditambah'
            ]);
        } else {
            // $newDate = Tanggalan::create([
            //     'tanggal' => $currentNow
            // ]);

            $cek = Tanggalan::whereDate('tanggal', $currentNow)->first();
            if (!$cek) {
                $newDate = Tanggalan::create([
                    'tanggal' => $currentNow
                ]);
            } else {
                $newDate = $cek;
            }

            $makanan = new Makanan;
            $makanan->name = $request->name;
            $makanan->takaran = $request->takaran;
            $makanan->kalori = $request->kalori;
            $makanan->save();

            $newDate->makanan()->attach($makanan, ['user_id' => $user->id]);
            // $newDate->user()->attach($user);
            $user->tanggalan()->attach($newDate);
            return response()->json([
                'status' => true,
                'message' => 'Berhasil Ditambah'
            ]);
        }
    }
}
