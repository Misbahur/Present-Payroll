<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
// use Illuminate\Database\Eloquent\SoftDeletes;

class Jabatan extends Model
{
    // use HasFactory, Notifiable, SoftDeletes;
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
