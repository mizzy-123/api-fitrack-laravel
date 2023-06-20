<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserData extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    // public function jenis_kelamin()
    // {
    //     return $this->belongsTo(JenisKelamin::class, 'jeniskelamin_id');
    // }
}
