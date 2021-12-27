<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
// use Illuminate\Database\Eloquent\SoftDeletes;


class Pegawai extends Model
{
    // use HasFactory, Notifiable, SoftDeletes;
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nama', 'jabatan_id', 'nik', 'alamat', 'tanggal_masuk', 'tanggal_lahir',
    ];

    public function jabatan()
    {
        return $this->belongsTo('App\Models\Jabatan', 'jabatan_id');
    }

    public function penggajian()
    {
        return $this->hasMany(Penggajia::class);
    }

    // public function kelompok_kerja()
    // {
    //     return $this->hasMany('App\Models\Kelompok_kerja', 'id');
    // }
    
}
