<?php

namespace App\Http\Controllers;

use App\Http\Resources\AllMakananAktivitasResource;
use App\Models\Tanggalan;
use App\Models\User;
use Illuminate\Http\Request;

class ShowAllAktivitasMakananController extends Controller
{
    public function show(User $user)
    {
        // $makanan = $user->tanggalan()->whereDate('tanggal', $request->tanggal)->first()->makanan()->get();
        // $aktivitas = $user->tanggalan()->whereDate('tanggal', $request->tanggal)->first()->aktivitas()->get();
        // $tanggal = $user->tanggalan()->orderBy('tanggal', 'desc')->with('makanan', 'aktivitas')->distinct()->get();
        $tanggal = Tanggalan::all();

        $response = $tanggal->map(function ($t) use ($user) {
            return [
                'tanggal' => $t->tanggal,
                'makanan' => $t->user()->where('users.id', $user->id)->first()->makanan->map(function ($m) {
                    return [
                        'id' => $m->id,
                        'name' => $m->name,
                        'kalori' => $m->kalori,
                        // tambahkan atribut lain yang diperlukan
                    ];
                }),
                'aktivitas' => $t->user()->where('users.id', $user->id)->first()->aktivitas->map(function ($a) {
                    return [
                        'id' => $a->id,
                        'name' => $a->name,
                        'repetisi' => $a->repetisi,
                        'set' => $a->set,
                        // tambahkan atribut lain yang diperlukan
                    ];
                }),
            ];
        });

        return response()->json($response);
        // return response()->json([
        //     'status' => true,
        //     'data' => $tanggal

        // ]);
        // return AllMakananAktivitasResource::collection($tanggal);
    }
}
