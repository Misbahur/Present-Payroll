<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jabatan extends Model
{
    use HasFactory;
    protected $fillable = ['nama', 'deskripsi'];

    public function pegawai()
    {
        return $this->hasMany(Pegawai::class);
    }

    public function penggajian()
    {
        return $this->hasMany(Penggajia::class);
    }
}
