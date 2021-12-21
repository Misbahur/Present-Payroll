<?php

namespace App\Http\Controllers;

use App\Models\Komponen_gaji;
use App\Models\Pegawai;
use App\Models\Jabatan;
use App\Models\Lembur;
use Illuminate\Http\Request;

class Komponen_gajiController extends Controller
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
        $komponen_gaji = Komponen_gaji::paginate(10);
        $pegawais = Pegawai::all();
        $jabatans = Jabatan::all();
        $lembur = Lembur::where('id', 1)->first();
        $keterlambatan = Lembur::where('id', 2)->first();
        return view('gocay.komponen-gaji', [
            'komponen_gaji' => $komponen_gaji,
            'pegawais' => $pegawais,
            'jabatans' => $jabatans,
            'lembur' => $lembur,
            'keterlambatan' => $keterlambatan,
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
            'nominal' => 'required',
            'masuklibur' => 'required',
            'tidakmasuk' => 'required',
            'jabatan_id' => 'required',
         
        ]);

        // dd($request);
        $komponen_gaji = new Komponen_gaji;
        $komponen_gaji->nama = $request->nama;
        $komponen_gaji->jabatan_id = $request->jabatan_id;
        $komponen_gaji->nominal = $request->nominal;
        $komponen_gaji->masuklibur = $request->masuklibur;
        $komponen_gaji->tidakmasuk = $request->tidakmasuk;
        $komponen_gaji->save();

        // dd($komponen_gaji);
        if($komponen_gaji){
            return redirect()->route('komponen-gaji')->with(['success' => 'Data Komponen Gaji'.$request->input('nama').'berhasil disimpan']);
        }else{
            return redirect()->route('komponen-gaji')->with(['danger' => 'Data Tidak Terekam!']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Komponen_gaji $komponen_gaji
     * @return \Illuminate\Http\Response
     */
    public function show(Komponen_gaji $komponen_gaji)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Komponen_gaji $komponen_gaji
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $Request)
    {
        $komponen = Komponen_gaji::findOrFail($Request->get('id'));
        echo json_encode($komponen);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pegawai  $Pegawai
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Komponen_gaji $komponen_gaji)
    {
        dd($request->all());
        $this->validate($request, [
            'nama' => 'required',
            'jabatan_id' => 'required',
            'nominal' => 'required',
            'masuklibur' => 'required',
            'tidakmasuk' => 'required',
            ]);
   
        $komponen = Komponen_gaji::find($request->id);
        $komponen->update($request->all());

        if($komponen){
            return redirect()->route('komponen-gaji')->with(['success' => 'Data komponen-gaji'.$request->input('nama').'berhasil disimpan']);
        }else{
            return redirect()->route('komponen-gaji')->with(['danger' => 'Data Tidak Terekam!']);
        }
    }

    public function bonusmingguanupdate(Request $request, Komponen_gaji $komponen)
    {
        $this->validate($request, [
            'nominal' => 'required',
        ]);
   
        $komponen_gaji = Komponen_gaji::find(1);
        $komponen_gaji->nominal = $request->nominal;
        $komponen_gaji->update();

        if($komponen_gaji){
            return redirect()->route('komponen-gaji')->with(['success' => 'Data Komponen Gaji berhasil disimpan']);
        }else{
            return redirect()->route('komponen-gaji')->with(['danger' => 'Data Tidak Terekam!']);
        }
    }

    public function bonusbulananupdate(Request $request, Komponen_gaji $komponen_gaji)
    {
        $this->validate($request, [
            'nominal' => 'required',
        ]);
   
        $komponen_gaji = Komponen_gaji::find(2);
        $komponen_gaji->nominal = $request->nominal;
        $komponen_gaji->update();

        if($komponen_gaji){
            return redirect()->route('komponen-gaji')->with(['success' => 'Data Komponen Gaji berhasil disimpan']);
        }else{
            return redirect()->route('komponen-gaji')->with(['danger' => 'Data Tidak Terekam!']);
        }
    }

    // public function liburmasuk(Request $request, Komponen_gaji $komponen_gaji)
    // {
    //      $this->validate($request, [
    //         'nominal' => 'required',
    //     ]);

    //     $komponen_gaji = Komponen_gaji::find(3);
    //     $komponen_gaji->nominal = $request->nominal;
    //     $komponen_gaji->update();

    //     if($komponen_gaji){
    //         return redirect()->route('komponen-gaji')->with(['success' => 'Data Komponen Gaji berhasil disimpan']);
    //     }else{
    //         return redirect()->route('komponen-gaji')->with(['danger' => 'Data Tidak Terekam!']);
    //     }
    // }

    // public function masuklibur(Request $request, Komponen_gaji $komponen_gaji)
    // {
    //      $this->validate($request, [
    //         'nominal' => 'required',
    //     ]);

    //     $komponen_gaji = Komponen_gaji::find(4);
    //     $komponen_gaji->nominal = $request->nominal;
    //     $komponen_gaji->update();

    //     if($komponen_gaji){
    //         return redirect()->route('komponen-gaji')->with(['success' => 'Data Komponen Gaji berhasil disimpan']);
    //     }else{
    //         return redirect()->route('komponen-gaji')->with(['danger' => 'Data Tidak Terekam!']);
    //     }
    // }


    public function lembur(Request $request, Lembur $lembur)
    {
        $this->validate($request, [
            'durasi' => 'required',
            'nominal' => 'required',
        ]);

        $lembur = Lembur::find(1);
        $lembur->durasi = $request->durasi;
        $lembur->nominal = $request->nominal;
        $lembur->update();

        if($lembur){
            return redirect()->route('komponen-gaji')->with(['success' => 'Data Komponen Gaji berhasil disimpan']);
        }else{
            return redirect()->route('komponen-gaji')->with(['danger' => 'Data Tidak Terekam!']);
        }
    }

    public function keterlambatan(Request $request, Lembur $lembur)
    {
        $this->validate($request, [
            'durasi' => 'required',
            'nominal' => 'required',
        ]);

        $lembur = Lembur::find(2);
        $lembur->durasi = $request->durasi;
        $lembur->nominal = $request->nominal;
        $lembur->update();

        if($lembur){
            return redirect()->route('komponen-gaji')->with(['success' => 'Data Komponen Gaji berhasil disimpan']);
        }else{
            return redirect()->route('komponen-gaji')->with(['danger' => 'Data Tidak Terekam!']);
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
        $pegawais = Komponen_gaji::where('id', $id)
              ->delete();
        return redirect()->route('komponen-gaji')
                        ->with('success','Data deleted successfully');
    }
}
