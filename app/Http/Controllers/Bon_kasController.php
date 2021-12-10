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
        $bon_kas = Bon_kas::whereMonth('tanggal', date('m'))->paginate(10);
        $pegawais = Pegawai::all();
        // $jabatans = Jabatan::all();
        return view('gocay.bon-kas', [
            'bon_kas' => $bon_kas,
            'pegawais' => $pegawais,
            // 'jabatans' => $jabatans
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
            'tanggal' => 'required',
            'pegawai_id' => 'required',
            'jabatan_id' => 'required',
            'nominal' => 'required',
            'keterangan' => 'required',
        ]);

        $Bon_kas = new Bon_kas;
        $Bon_kas->nama = $request->nama;
        $Bon_kas->tanggal = $request->tanggal;
        $Bon_kas->pegawai_id = $request->pegawai_id;
        $Bon_kas->jabatan_id = $request->jabatan_id;
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

    public function dropdown_jabatan(Request $request)
    {
        $pegawais = Pegawai::find($request->get('id'));
        $jabatans = Jabatan::where("id",$pegawais['jabatan_id'])->pluck("nama","id");
        return response()->json($jabatans);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Bon_kas  $Bon_kas
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $Request)
    {
        $bon_kas = Bon_kas::findOrFail($Request->get('id'));
        echo json_encode($bon_kas);
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
        $request->validate([
            'nama' => 'required',
            'tanggal' => 'required',
            'pegawai_id' => 'required',
            'jabatan_id' => 'required',
            'nominal' => 'required',
            'keterangan' => 'required',
        ]);

        $bon_kas = Bon_kas::find($request->id);
        $bon_kas->update($request->all());

        if($Bon_kas){
            return redirect()->route('bon-kas')->with(['success' => 'Data Bon_kas'.$request->input('nama').'berhasil disimpan']);
        }else{
            return redirect()->route('bon-kas')->with(['danger' => 'Data Tidak Terekam!']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Bon_kas  $Bon_kas
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $bon_kas = Bon_kas::where('id', $id)
              ->delete();
        return redirect()->route('bon-kas')
                        ->with('success','Post deleted successfully');
    }
}
