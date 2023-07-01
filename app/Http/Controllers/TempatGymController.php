<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TempatGymController extends Controller
{
    public function store(Request $request)
    {
        $l = new Location;
        $l->name = $request->name;

        if ($request->file('foto')) {
            $l->foto = $request->file('foto')->store('location-gym');
        }

        $l->longitude = $request->longitude;
        $l->latitude = $request->latitude;

        $l->save();

        return response()->json([
            'status' => true,
            'message' => 'Berhasil disimpan'
        ]);
    }

    public function index()
    {
        return response()->json([
            'status' => true,
            'data' => Location::all()
        ]);
    }

    public function update(Location $location, Request $request)
    {
        $location->name = $request->name;
        if ($request->file('foto')) {
            if ($location->foto != null) {
                Storage::delete($location->foto);
            }
            // $image = $user_data->image = $request->file('image')->store('image-user');
            // $user_data->image = $image;
            $location->foto = $request->file('foto')->store('location-gym');
        }

        $location->longitude = $request->longitude;
        $location->latitude = $request->latitude;
        $location->save();

        return response()->json([
            'status' => true,
            'message' => 'update berhasil'
        ]);
    }

    public function destroy(Location $location)
    {
        if ($location->foto != null) {
            Storage::delete($location->foto);
        }
        $location->delete();
        return response()->json([
            'status' => true,
            'message' => 'Delete berhasil'
        ]);
    }
}
