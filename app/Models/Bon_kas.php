<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bon_kas extends Model
{
    use HasFactory;
    protected $fillable = ['nama', 'pegawai_id', 'jabatan_id','tanggal', 'nominal', 'keterangan'];

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'pegawai_id');
    }

}
