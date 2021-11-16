<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelompok_kerja extends Model
{
    use HasFactory;

    protected $fillable = ['nama', 'pola_kerja_id', 'pegawai_id'];

    public function pegawai()
    {
        // return $this->hasMany(Pegawai::class);
        // return $this->hasMany(User::class);
        return $this->belongsTo(User::class);
    }

    public function pola()
    {
        return $this->belongsTo(Pola::class, 'pola_kerja_id');
    }
}
