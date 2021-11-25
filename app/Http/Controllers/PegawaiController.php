<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\Jabatan;
use Illuminate\Http\Request;

class PegawaiController extends Controller
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
        $pegawais = Pegawai::all();
        $jabatans = Jabatan::all();
        return view('gocay.pegawai', [
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

        // dd($request);
        $pegawai = new Pegawai;
        $pegawai->nama = $request->nama;
        $pegawai->jabatan_id = $request->jabatan_id;
        $pegawai->save();

         if($pegawai){
            return redirect()->route('pegawai')->with(['success' => 'Data Pegawai'.$request->input('nama').'berhasil disimpan']);
        }else{
            return redirect()->route('pegawai')->with(['danger' => 'Data Tidak Terekam!']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pegawai  $Pegawai
     * @return \Illuminate\Http\Response
     */
    public function show(Pegawai $Pegawai)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pegawai  $Pegawai
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $Request)
    {
        $pegawais = Pegawai::findOrFail($Request->get('id'));
        echo json_encode($pegawais);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pegawai  $Pegawai
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pegawai $pegawais)
    {
        $this->validate($request, [
            'nama' => 'required',
            'jabatan_id' => 'required',
            ]);
   
        $pegawais = Pegawai::find($request->id);
        $pegawais->update($request->all());

        if($pegawais){
            return redirect()->route('pegawai')->with(['success' => 'Data Pegawai'.$request->input('nama').'berhasil disimpan']);
        }else{
            return redirect()->route('pegawai')->with(['danger' => 'Data Tidak Terekam!']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pegawai  $Pegawai
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $pegawais = Pegawai::where('id', $id)
              ->delete();
        return redirect()->route('pegawai')
                        ->with('success','Post deleted successfully');
    }
}
