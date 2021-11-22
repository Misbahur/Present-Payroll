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
            'jam_masuk' => 'required',
            'jam_istirahat' => 'required',
            'jam_istirahat_masuk' => 'required',
            'jam_pulang' => 'required',
        ]);

        $pola = new Pola;
        $pola->nama = $request->nama;
        $pola->jam_masuk = $request->jam_masuk;
        $pola->jam_istirahat = $request->jam_istirahat;
        $pola->jam_istirahat_masuk = $request->jam_istirahat_masuk;
        $pola->jam_pulang = $request->jam_pulang;
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
    public function edit(Request $Request)
    {
        $pola = Pola::findOrFail($Request->get('id'));
        echo json_encode($pola);
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
        $this->validate($request, [
            'nama' => 'required',
            'jam_masuk' => 'required',
            'jam_istirahat' => 'required',
            'jam_istirahat_masuk' => 'required',
            'jam_pulang' => 'required',
            ]);
   
        $pola = Pola::find($request->id);
        $pola->update($request->all());

        if($pola){
            return redirect()->route('pola-kerja')->with(['success' => 'Data Pola Kerja Pegawai'.$request->input('nama').'berhasil disimpan']);
        }else{
            return redirect()->route('pola-kerja')->with(['danger' => 'Data Tidak Terekam!']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pola  $pola
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $pola = Pola::where('id', $id)
              ->delete();
        return redirect()->route('pola-kerja')
                        ->with('success','Post deleted successfully');
    }
}
