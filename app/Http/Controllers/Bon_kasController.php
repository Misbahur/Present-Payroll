<?php

namespace App\Http\Controllers;

use App\Models\Bon_kas;
use App\Models\Jabatan;
use App\Models\Pegawai;
use Illuminate\Http\Request;

class Bon_kasController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $bon_kas = Bon_kas::all();
        $pegawais = Pegawai::all();
        $jabatans = Jabatan::all();
        return view('gocay.bon-kas', [
            'bon_kas' => $bon_kas,
            'pegawais' => $pegawais,
            'jabatans' => $jabatans
        ]);
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'jabatan_id' => 'required',
         
        ]);

        $Bon_kas = new Bon_kas;
        $Bon_kas->nama = $request->nama;
        $Bon_kas->pegawai_id = $request->pegawai_id;
        $Bon_kas->jabatan_id = $request->jabatan_id;
        $Bon_kas->tanggal = $request->tanggal;
        $Bon_kas->nominal = $request->nominal;
        $Bon_kas->keterangan = $request->keterangan;
        $Bon_kas->save();

         if($Bon_kas){
            return redirect()->route('bon-kas')->with(['success' => 'Data Bon_kas'.$request->input('nama').'berhasil disimpan']);
        }else{
            return redirect()->route('bon-kas')->with(['danger' => 'Data Tidak Terekam!']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Bon_kas  $Bon_kas
     * @return \Illuminate\Http\Response
     */
    public function show(Bon_kas $Bon_kas)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Bon_kas  $Bon_kas
     * @return \Illuminate\Http\Response
     */
    public function edit(Bon_kas $Bon_kas)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Bon_kas  $Bon_kas
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Bon_kas $Bon_kas)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Bon_kas  $Bon_kas
     * @return \Illuminate\Http\Response
     */
    public function destroy(Bon_kas $Bon_kas)
    {
        //
    }
}
