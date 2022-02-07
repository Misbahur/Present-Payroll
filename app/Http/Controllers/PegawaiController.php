<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\Kehadiran;
use App\Models\Jabatan;
use App\Models\Bank;
use Illuminate\Http\Request;

class PegawaiController extends Controller
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
        $data_request = $request->all();
        $pegawais = Pegawai::paginate(10);
        $jabatans = Jabatan::all();
        $bank = Bank::all();
        return view('gocay.pegawai', [
            'pegawais' => $pegawais,
            'bank' => $bank,
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
            'nama' => 'required',
            'jabatan_id' => 'required',
            'tanggal_lahir' => 'required',
            'nik' => 'required',
            'tanggal_masuk' => 'required',
            'alamat' => 'required',
         
        ]);
        $pegawai = new Pegawai;
        $pegawai->nama = $request->nama;
        $pegawai->jabatan_id = $request->jabatan_id;
        $pegawai->tanggal_lahir = $request->tanggal_lahir;
        $pegawai->nik = $request->nik;
        $pegawai->tanggal_masuk = $request->tanggal_masuk;
        $pegawai->alamat = $request->alamat;
        $pegawai->nohp = $request->nohp;
        $pegawai->bank_id = $request->bank_id;
        $pegawai->no_rek = $request->no_rek;
        $pegawai->atas_nama = $request->atas_nama;
        $pegawai->save();
        
        $pegawai_last = Pegawai::latest('id')->first();
        $batas_tanggal = date('t');
        for ($i = 0; $i < $batas_tanggal; $i++):
            $kehadirans = new Kehadiran;
            $kehadirans->tanggal = date('Y-m-d', strtotime('+'.$i.' day', strtotime('first day of this month')));
            $kehadirans->pegawai_id = $pegawai_last->id;
            $kehadirans->jam_masuk = null;
            $kehadirans->jam_istirahat = null;
            $kehadirans->jam_masuk_istirahat = null;
            $kehadirans->jam_pulang = null;
            // dd($kehadirans->pegawai_id);
            $kehadirans->save();
        endfor;
        // dd($request);


        if($kehadirans){
            return redirect()->back()->with(['success' => 'Data Pegawai'.$request->input('nama').'berhasil disimpan']);
        }else{
            return redirect()->back()->with(['danger' => 'Data Tidak Terekam!']);
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
            'tanggal_lahir' => 'required',
            'nik' => 'required',
            'tanggal_masuk' => 'required',
            'alamat' => 'required',
            ]);
   
        $pegawai = Pegawai::find($request->id);
        $pegawai->nama = $request->nama;
        $pegawai->jabatan_id = $request->jabatan_id;
        $pegawai->tanggal_lahir = $request->tanggal_lahir;
        $pegawai->nik = $request->nik;
        $pegawai->tanggal_masuk = $request->tanggal_masuk;
        $pegawai->alamat = $request->alamat;
        $pegawai->nohp = $request->nohp;
        $pegawai->bank_id = $request->bank_id;
        $pegawai->no_rek = $request->no_rek;
        $pegawai->atas_nama = $request->atas_nama;
        $pegawai->update();
        // $pegawais->update($request->all());

        if($pegawais){
            return redirect()->back()->with(['success' => 'Data Pegawai'.$request->input('nama').'berhasil disimpan']);
        }else{
            return redirect()->back()->with(['danger' => 'Data Tidak Terekam!']);
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
        return redirect()->back()
                        ->with('success','Post deleted successfully');
    }
}
