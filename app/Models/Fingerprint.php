<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fingerprint extends Model
{
    use HasFactory;

    protected $fillable = [
        'tanggal', 'jam_masuk', 'jam_istirahat', 'jam_masuk_istirahat', 'jam_pulang', 'jabatan_id', 'pegawai_id'
    ];
}
