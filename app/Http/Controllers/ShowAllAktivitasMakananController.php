<?php

namespace App\Http\Controllers;

use App\Http\Resources\AllMakananAktivitasKemarinResource;
use App\Http\Resources\AllMakananAktivitasResource;
use App\Http\Resources\AllMakananAktivitasSekarangResource;
use App\Http\Resources\AllTanggalMakananAktivitasResource;
use App\Http\Resources\Tanggal;
use App\Models\Tanggalan;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ShowAllAktivitasMakananController extends Controller
{
    public function show(User $user)
    {
        // $makanan = $user->tanggalan()->whereDate('tanggal', $request->tanggal)->first()->makanan()->get();
        // $aktivitas = $user->tanggalan()->whereDate('tanggal', $request->tanggal)->first()->aktivitas()->get();
        // $tanggal = $user->tanggalan()->orderBy('tanggal', 'desc')->with('makanan', 'aktivitas')->distinct()->get();
        // $tanggal = Tanggalan::all();
        // $tanggal = Tanggalan::with('makanan:name,takaran,kalori', 'aktivitas')->get();
        // $tanggal = $user->tanggalan()->with('makanan:name,takaran,kalori', 'aktivitas:name,durasi,kalori')->get();

        $tanggal = $user->tanggalan()
            ->with([
                'makanan' => function ($query) use ($user) {
                    $query->select('makanans.name', 'makanans.takaran', 'makanans.kalori')
                        ->wherePivot('user_id', $user->id);
                },
                'aktivitas' => function ($query) use ($user) {
                    $query->select('aktivitas.name', 'aktivitas.durasi', 'aktivitas.kalori')
                        ->wherePivot('user_id', $user->id);
                }
            ])->get();

        // $response = $tanggal->map(function ($t) use ($user) {
        //     return [
        //         'tanggal' => $t->tanggal,
        //         'makanan' => $t->user()->where('users.id', $user->id)->first()->makanan->map(function ($m) {
        //             return [
        //                 'id' => $m->id,
        //                 'name' => $m->name,
        //                 'kalori' => $m->kalori,
        //                 // tambahkan atribut lain yang diperlukan
        //             ];
        //         }),
        //         'aktivitas' => $t->user()->where('users.id', $user->id)->first()->aktivitas->map(function ($a) {
        //             return [
        //                 'id' => $a->id,
        //                 'name' => $a->name,
        //                 'repetisi' => $a->repetisi,
        //                 'set' => $a->set,
        //                 // tambahkan atribut lain yang diperlukan
        //             ];
        //         }),
        //     ];
        // });

        // return response()->json($response);
        // return response()->json([
        //     'status' => true,
        //     'data' => $tanggal

        // ]);
        // return AllMakananAktivitasResource::collection($tanggal);
        return response()->json([
            'status' => true,
            'data' => AllMakananAktivitasResource::collection($tanggal)
        ]);
    }

    public function sekarang(User $user)
    {
        $sekarang = Carbon::now();
        $cek = $user->tanggalan()->whereDate('tanggal', $sekarang)->first();
        if ($cek) {
            // $tanggal = $user->tanggalan()
            //     ->with('makanan:name,takaran,kalori', 'aktivitas:name,durasi,kalori')
            //     ->whereDate('tanggal', $sekarang)
            //     ->first();
            $tanggal = $user->tanggalan()
                ->whereDate('tanggal', $sekarang)
                ->with([
                    'makanan' => function ($query) use ($user, $cek) {
                        $query->select('makanans.name', 'makanans.takaran', 'makanans.kalori')
                            ->wherePivot('user_id', $user->id)
                            ->wherePivot('tanggalan_id', $cek->id);
                    },
                    'aktivitas' => function ($query) use ($user, $cek) {
                        $query->select('aktivitas.name', 'aktivitas.durasi', 'aktivitas.kalori')
                            ->wherePivot('user_id', $user->id)
                            ->wherePivot('tanggalan_id', $cek->id);
                    }
                ])->first();
            return response()->json([
                'status' => true,
                'data' => new AllMakananAktivitasSekarangResource($tanggal)
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan'
            ]);
        }
    }

    public function kemarin(User $user)
    {
        $kemarin = Carbon::yesterday();
        $cek = $user->tanggalan()->whereDate('tanggal', $kemarin)->first();
        if ($cek) {
            // $tanggal = $user->tanggalan()
            //     ->with('makanan:name,takaran,kalori', 'aktivitas:name,durasi,kalori')
            //     ->whereDate('tanggal', $kemarin)
            //     ->first();

            $tanggal = $user->tanggalan()
                ->whereDate('tanggal', $kemarin)
                ->with([
                    'makanan' => function ($query) use ($user, $cek) {
                        $query->select('makanans.name', 'makanans.takaran', 'makanans.kalori')
                            ->wherePivot('user_id', $user->id)
                            ->wherePivot('tanggalan_id', $cek->id);
                    },
                    'aktivitas' => function ($query) use ($user, $cek) {
                        $query->select('aktivitas.name', 'aktivitas.durasi', 'aktivitas.kalori')
                            ->wherePivot('user_id', $user->id)
                            ->wherePivot('tanggalan_id', $cek->id);
                    }
                ])->first();
            return response()->json([
                'status' => true,
                'data' => new AllMakananAktivitasKemarinResource($tanggal)
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan'
            ]);
        }
    }

    public function tanggal(User $user)
    {
        $data = $user->tanggalan()->get();
        return response()->json([
            'status' => true,
            'data' => Tanggal::collection($data)
        ]);
    }

    public function history(Tanggalan $tanggalan, Request $request)
    {
        if ($request->filled('email')) {

            $data = $tanggalan->user()->with('makanan', 'aktivitas')->where('email', $request->email)->first();
            return response()->json([
                'status' => true,
                'data' => new AllTanggalMakananAktivitasResource($data)
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Request get email harus diisi'
            ]);
        }
    }
}
