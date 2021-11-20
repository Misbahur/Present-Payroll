<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kelompok_kerja;
use App\Models\Pegawai;
use App\Models\Pola;
use App\Models\User;

class Kelompok_kerjaController extends Controller
{
    //
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $kelompok_kerja = Kelompok_kerja::all();
        $pola = Pola::all();
        $pegawais = Pegawai::all();

        return view('gocay.kelompok-kerja', [
            'kelompok_kerja' => $kelompok_kerja,
            'pola' => $pola,
            'pegawais' => $pegawais
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
            'pola_kerja_id' => 'required',
            'pegawai_id' => 'required',
         
        ]);

        $jumlahPegawai = sizeof($request->pegawai_id);
        for ($i=0; $i < $jumlahPegawai; $i++) { 
            $Kelompok_kerja = new Kelompok_kerja;
            $Kelompok_kerja->nama = $request->nama;
            $Kelompok_kerja->pola_kerja_id = $request->pola_kerja_id;
            $Kelompok_kerja->pegawai_id = $request->pegawai_id[$i];
            $Kelompok_kerja->save();
        }
        // $pegawai_ids = implode(', ', $pegawai_id);
        // $Kelompok_kerja = new Kelompok_kerja;
        // $Kelompok_kerja->nama = $request->nama;
        // $Kelompok_kerja->pola_kerja_id = $request->pola_kerja_id;
        // $Kelompok_kerja->pegawai_id = $pegawai_ids;
        // $Kelompok_kerja->save();

         if($Kelompok_kerja){
            return redirect()->route('kelompok-kerja')->with(['success' => 'Data Kelompok_kerja'.$request->input('nama').'berhasil disimpan']);
        }else{
            return redirect()->route('kelompok-kerja')->with(['danger' => 'Data Tidak Terekam!']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Kelompok_kerja  $Kelompok_kerja
     * @return \Illuminate\Http\Response
     */
    public function show(Kelompok_kerja $Kelompok_kerja)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $Request)
    {
        $kelompok_kerja = Kelompok_kerja::findOrFail($Request->get('id'));
        echo json_encode($kelompok_kerja);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Kelompok_kerja  $Kelompok_kerja
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Kelompok_kerja $Kelompok_kerja)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Kelompok_kerja  $Kelompok_kerja
     * @return \Illuminate\Http\Response
     */
    public function destroy(Kelompok_kerja $Kelompok_kerja)
    {
        //
    }
}
