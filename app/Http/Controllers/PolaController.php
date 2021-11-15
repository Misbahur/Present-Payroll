<?php

namespace App\Http\Controllers;

use App\Models\Pola;
use Illuminate\Http\Request;

class PolaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $polas = Pola::all();
        return view('gocay.pola-kerja', ['polas' => $polas]);
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
            'jm' => 'required',
            'ji' => 'required',
            'jim' => 'required',
            'jp' => 'required'
        ]);

        $pola = new Pola;
        $pola->nama = $request->nama;
        $pola->jam_masuk = $request->jm;
        $pola->jam_istirahat = $request->ji;
        $pola->jam_istirahat_masuk = $request->jim;
        $pola->jam_pulang = $request->jp;
        $pola->save();

         if($pola){
            return redirect()->route('pola-kerja')->with(['success' => 'Data Pola Kerja'.$request->input('nama').'berhasil disimpan']);
        }else{
            return redirect()->route('pola-kerja')->with(['danger' => 'Data Tidak Terekam!']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pola  $pola
     * @return \Illuminate\Http\Response
     */
    public function show(Pola $pola)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pola  $pola
     * @return \Illuminate\Http\Response
     */
    public function edit(Pola $pola)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pola  $pola
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pola $pola)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pola  $pola
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pola $pola)
    {
        //
    }
}
