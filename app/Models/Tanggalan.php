<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tanggalan extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function makanan()
    {
        return $this->belongsToMany(Makanan::class, 'makanan_tanggalans');
    }

    public function aktivitas()
    {
        return $this->belongsToMany(Aktivitas::class, 'aktivitas_tanggalans');
    }

    public function user()
    {
        return $this->belongsToMany(User::class, 'user_tanggalans');
    }
}
