<?php

namespace App\Http\Controllers;

use App\Models\Aktivitas;
use App\Models\Tanggalan;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AktivitasTanggalanController extends Controller
{

    public function store(User $user, Request $request)
    {
        $currentNow = Carbon::now();

        $date = $user->tanggalan()->whereDate('tanggal', $currentNow)->first();
        // $user->tanggalan()->exists()
        if ($date) {
            $aktivitas = new Aktivitas;
            $aktivitas->name = $request->name;
            $aktivitas->durasi = $request->durasi;
            $aktivitas->kalori = $request->kalori;
            $aktivitas->save();

            $date->aktivitas()->attach($aktivitas, ['user_id' => $user->id]);
            // $date->user()->attach($user);
            if (!$date) {
                $user->tanggalan()->attach($date);
            }
            return response()->json([
                'status' => true,
                'message' => 'Berhasil Ditambah'
            ]);
        } else {
            $cek = Tanggalan::whereDate('tanggal', $currentNow)->first();
            if (!$cek) {
                $newDate = Tanggalan::create([
                    'tanggal' => $currentNow
                ]);
            } else {
                $newDate = $cek;
            }

            $aktivitas = new Aktivitas;
            $aktivitas->name = $request->name;
            $aktivitas->durasi = $request->durasi;
            $aktivitas->kalori = $request->kalori;
            $aktivitas->save();

            $newDate->aktivitas()->attach($aktivitas, ['user_id' => $user->id]);
            // $newDate->user()->attach($user);
            $user->tanggalan()->attach($newDate);
            return response()->json([
                'status' => true,
                'message' => 'Berhasil Ditambah'
            ]);
        }
    }
}
