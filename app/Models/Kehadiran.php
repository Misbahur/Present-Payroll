<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kehadiran extends Model
{
    use HasFactory;

    protected $fillable = [
        'tanggal', 'jam_masuk', 'jam_istirahat', 'jam_masuk_istirahat', 'jam_pulang', 'jabatan_id', 'pegawai_id'
    ];

    public function pegawai()
    {
        return $this->belongsTo('App\Models\Pegawai', 'pegawai_id');
    }

    public function jabatan()
    {
        return $this->belongsTo('App\Models\Jabatan', 'jabatan_id');
    }
}
