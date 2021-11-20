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
        return $this->belongsTo(Pegawai::class, 'pegawai_id');
    }

    public function pola()
    {
        return $this->belongsTo(Pola::class, 'pola_kerja_id');
    }
}
