<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AllMakananAktivitasSekarangResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'tanggal' => $this->tanggal,
            'makanan' => $this->makanan->map(function ($makanan) {
                return [
                    'name' => $makanan->name,
                    'takaran' => $makanan->takaran,
                    'kalori' => $makanan->kalori,
                ];
            }),
            'aktivitas' => $this->aktivitas->map(function ($aktivitas) {
                return [
                    'name' => $aktivitas->name,
                    'durasi' => $aktivitas->durasi,
                    'kalori' => $aktivitas->kalori
                ];
            }),
        ];
    }
}
