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
    public function index(Request $request)
    {
        //
        $jabatans = Jabatan::paginate(10);
        return view('gocay.jabatan', [
            'jabatans' => $jabatans
        ])->with('i', ($request->input('page', 1) - 1) * 10);
        
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
    public function edit(Request $Request)
    {
        $jabatans = Jabatan::findOrFail($Request->get('id'));
        echo json_encode($jabatans);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Jabatan  $Jabatan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Jabatan $jabatans)
    {
        $this->validate($request, [
            'nama' => 'required',
            'deskripsi' => 'required',
            ]);
   
        $jabatans = Jabatan::find($request->id);
        $jabatans->update($request->all());

        if($jabatans){
            return redirect()->back()->with(['success' => 'Data Jabatan'.$request->input('nama').'berhasil disimpan']);
        }else{
            return redirect()->back()->with(['danger' => 'Data Tidak Terekam!']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Jabatan  $Jabatan
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // $jabatans = Jabatan::find($id);
        // $jabatans->delete();
        $jabatans = Jabatan::where('id', $id)
              ->delete();
        return redirect()->back()
                        ->with('success','Post deleted successfully');
    }
}
