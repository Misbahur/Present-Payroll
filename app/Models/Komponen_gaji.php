<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Komponen_gaji extends Model
{
    use HasFactory;

    protected $fillable = ['nama', 'jabatan_id', 'nominal'];

    public function jabatan()
    {
        return $this->belongsTo('App\Models\Jabatan', 'jabatan_id');
    }
}
