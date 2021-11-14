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
        return view('gocay/karyawan', compact('data', 'jumlahJabatan'));
    }
}
