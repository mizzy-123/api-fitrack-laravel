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

        $date = Tanggalan::whereDate('tanggal', $currentNow)->first();
        if ($date) {
            $aktivitas = new Aktivitas;
            $aktivitas->name = $request->name;
            $aktivitas->repetisi = $request->repetisi;
            $aktivitas->set = $request->set;
            $aktivitas->save();

            $date->aktivitas()->attach($aktivitas, ['user_id' => $user->id]);
            return response()->json([
                'status' => true,
                'message' => 'Berhasil Ditambah'
            ]);
        } else {
            $newDate = Tanggalan::create([
                'tanggal' => $currentNow
            ]);

            $aktivitas = new Aktivitas;
            $aktivitas->name = $request->name;
            $aktivitas->repetisi = $request->repetisi;
            $aktivitas->set = $request->set;
            $aktivitas->save();

            $newDate->aktivitas()->attach($aktivitas, ['user_id' => $user->id]);
            return response()->json([
                'status' => true,
                'message' => 'Berhasil Ditambah'
            ]);
        }
    }
}
