<?php

namespace App\Http\Controllers;

use App\Models\Jabatan;
use Illuminate\Http\Request;

class JabatanController extends Controller
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
        $jabatans = Jabatan::all();
        return view('gocay.jabatan', ['jabatans' => $jabatans]);
        
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
            'deskripsi' => 'required',
         
        ]);

        // dd($request);
        $jabatan = new Jabatan;
        $jabatan->nama = $request->nama;
        $jabatan->deskripsi = $request->deskripsi;
        $jabatan->save();

         if($jabatan){
            return redirect()->route('jabatan')->with(['success' => 'Data Jabatan'.$request->input('nama').'berhasil disimpan']);
        }else{
            return redirect()->route('jabatan')->with(['danger' => 'Data Tidak Terekam!']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Jabatan  $Jabatan
     * @return \Illuminate\Http\Response
     */
    public function show(Jabatan $Jabatan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Jabatan  $Jabatan
     * @return \Illuminate\Http\Response
     */
    public function edit(Jabatan $Jabatan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Jabatan  $Jabatan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Jabatan $Jabatan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Jabatan  $Jabatan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Jabatan $Jabatan)
    {
        //
    }
}
