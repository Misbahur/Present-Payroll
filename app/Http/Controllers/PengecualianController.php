<?php

namespace App\Http\Controllers;

use App\Models\Pengecualian;
use App\Models\Pegawai;
use App\Models\Jabatan;
use Illuminate\Http\Request;

class PengecualianController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data_request = $request->all();
        $pengecualians = Pengecualian::paginate(10);
        $pegawais = Pegawai::all();
        $jabatans = Jabatan::all();
        return view('gocay.pengecualian', [
            'pengecualians' => $pengecualians,
            'pegawais' => $pegawais,
            'jabatans' => $jabatans,
            'data_request' => $data_request
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
            'tanggal' => 'required',
            'pegawai_id' => 'required',
            'jabatan_id' => 'required',
            'keterangan' => 'required',
            // 'dokumen' => 'required|mimes:jpg,jpeg,png,txt,xlx,xls,pdf|max:2048',
         
        ]);

        
        if ($request->hasFile('dokumen')) {
            $filenameWithExt = $request->file('dokumen')->getClientOriginalName ();
            // Get Filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            // Get just Extension
            $extension = $request->file('dokumen')->getClientOriginalExtension();
            // Filename To store
            $fileNameToStore = $filename.'_'. 'dokumen'.'.'.$extension;
            $path = $request->file('dokumen')->storeAs('pengecualian', $fileNameToStore, 'public');
            }
            // Else add a dummy dokumen
        else {
            $path = 'Nophoto.jpg';
        }
   
        $pengecualians = new pengecualian;
        $pengecualians->tanggal = $request->tanggal;
        $pengecualians->pegawai_id = $request->pegawai_id;
        $pengecualians->jabatan_id = $request->jabatan_id;
        $pengecualians->keterangan = $request->keterangan;
        $pengecualians->dokumen = $path;
        $pengecualians->save();

        if($pengecualians){
            return redirect()->route('pengecualian')->with(['success' => 'Data pengecualian'.$request->input('nama').'berhasil disimpan']);
        }else{
            return redirect()->route('pengecualian')->with(['danger' => 'Data Tidak Terekam!']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pengecualian $pengecualian
     * @return \Illuminate\Http\Response
     */
    public function show(pengecualian $pengecualian)
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
     * @param  \App\Models\Pengecualian $pengecualian
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $Request)
    {
        $pengecualians = Pengecualian::findOrFail($Request->get('id'));
        echo json_encode($pengecualians);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pengecualian $pengecualian
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pengecualian $pengecualians)
    {
        $request->validate([
            'tanggal' => 'required',
            'pegawai_id' => 'required',
            'jabatan_id' => 'required',
            'keterangan' => 'required',
            // 'dokumen' => 'required|mimes:jpg,jpeg,png,txt,xlx,xls,pdf|max:2048',
         
        ]);

        if ($request->hasFile('dokumen')) {
            $filenameWithExt = $request->file('dokumen')->getClientOriginalName ();
            // Get Filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            // Get just Extension
            $extension = $request->file('dokumen')->getClientOriginalExtension();
            // Filename To store
            $fileNameToStore = $filename.'_'. 'dokumen'.'.'.$extension;
            $path = $request->file('dokumen')->storeAs('pengecualian', $fileNameToStore, 'public');
            }
            // Else add a dummy dokumen
        else {
            $path = 'Nophoto.jpg';
        }
   
        $pengecualians = Pengecualian::find($request->id);
        $pengecualians->tanggal = $request->tanggal;
        $pengecualians->pegawai_id = $request->pegawai_id;
        $pengecualians->jabatan_id = $request->jabatan_id;
        $pengecualians->keterangan = $request->keterangan;
        if ($request->dokumen){
            $pengecualians->dokumen = $path;
        }
        else{
            unset($pengecualians->dokumen);
        }
        $pengecualians->update();

        if($pengecualians){
            return redirect()->route('pengecualian')->with(['success' => 'Data pengecualian'.$request->input('nama').'berhasil disimpan']);
        }else{
            return redirect()->route('pengecualian')->with(['danger' => 'Data Tidak Terekam!']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pengecualian $pengecualian
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // $pengecualians = Pengecualian::find($id);
        // $pengecualians->delete();
        $pengecualians = Pengecualian::where('id', $id)
              ->delete();
        return redirect()->back()
                        ->with('success','Post deleted successfully');
    }
}
