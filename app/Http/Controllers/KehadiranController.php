<?php

namespace App\Http\Controllers;

use App\Models\Kehadiran;
use Illuminate\Http\Request;

class KehadiranController extends Controller
{
    public function index()
    {
        $data = Kehadiran::all();
        // $jumlahJabatan = Kehadiran::all()->groupBy('id_jabatan');
        // $jumlahKasir = Kehadiran::all()->where('id_jabatan', '1');
        // $jumlahGudang = Kehadiran::all()->where('id_jabatan', '2');
        // $jumlahKantor = Kehadiran::all()->where('id_jabatan', '3');
        return view('gocay/kehadiran', 
        compact(
            'data', 
            // 'jumlahJabatan',
            // 'jumlahKasir', 
            // 'jumlahGudang',
            // 'jumlahKantor'
        ));
    }
}
