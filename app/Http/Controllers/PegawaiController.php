<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use Illuminate\Http\Request;

class PegawaiController extends Controller
{
    public function index()
    {
        $data = Pegawai::all();
        $jumlahJabatan = Pegawai::all()->groupBy('id_jabatan');
        $jumlahKasir = Pegawai::all()->where('id_jabatan', '1');
        $jumlahGudang = Pegawai::all()->where('id_jabatan', '2');
        $jumlahKantor = Pegawai::all()->where('id_jabatan', '3');
        return view('gocay/karyawan', 
        compact(
            'data', 
            'jumlahJabatan',
            'jumlahKasir', 
            'jumlahGudang',
            'jumlahKantor'
        ));
    }
}
