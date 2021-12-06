<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penggajian extends Model
{
    use HasFactory;
    protected $guarded;

     public function pegawai()
     {
         return $this->belongsTo(Pegawai::class);

     }

     public function jabatan()
     {
         return $this->belongsTo(Jabatan::class);

     }

     public function periode()
     {
         return $this->belongsTo(Periode::class);

     }
}
