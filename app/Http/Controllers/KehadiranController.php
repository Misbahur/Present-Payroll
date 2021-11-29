<?php

namespace App\Http\Controllers;

use App\Models\Kehadiran;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use Carbon\Carbon;

class KehadiranController extends Controller
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
        $jumlahPegawai = Kehadiran::all()->groupBy('pegawai_id');
        $kehadirans = Kehadiran::where('tanggal', Carbon::now()->subDays(1)->toDateString())->orderBy('tanggal', 'desc')->orderBy('pegawai_id', 'asc')->paginate(10);
        // $kehadirans = Kehadiran::paginate(10);
        $jumlahPegawaiKasir = Kehadiran::where('tanggal', Carbon::now()->subDays(1)->toDateString())
                                ->whereBetween('jabatan_id', ['1', '2']);
        $jumlahSatpam = Kehadiran::where('tanggal', Carbon::now()->subDays(1)->toDateString())
                                ->whereBetween('jabatan_id', ['3', '4']);
        // $jumlahPegawaiKasir = Kehadiran::whereBetween('tanggal', [Carbon::now()->subDays(1),Carbon::now()->addDays(1)])->where('jabatan_id', '1')->groupBy('jabatan_id');
        // $kehadirans = Kehadiran::whereBetween('tanggal', [Carbon::now()->subDays(1),Carbon::now()->addDays(1)])->orderBy('tanggal', 'desc')->orderBy('pegawai_id', 'asc')->get();
        // $kehadirans = Kehadiran::all()->orderBy('tanggal', 'desc')->orderBy('pegawai_id', 'asc');
        return view('gocay.kehadiran', [
            'kehadirans' => $kehadirans,
            'jumlahPegawai' => $jumlahPegawai,
            'jumlahPegawaiKasir' => $jumlahPegawaiKasir,
            'jumlahSatpam' => $jumlahSatpam,
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
            'deskripsi' => 'required',
         
        ]);

        // dd($request);
        $kehadirans = new Jabatan;
        $kehadirans->nama = $request->nama;
        $kehadirans->deskripsi = $request->deskripsi;
        $kehadirans->save();

        if($kehadirans){
            return redirect()->route('kehadiran')->with(['success' => 'Data Kehadiran'.$request->input('nama').'berhasil disimpan']);
        }else{
            return redirect()->route('kehadiran')->with(['danger' => 'Data Tidak Terekam!']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Kehadiran  $kehadirans
     * @return \Illuminate\Http\Response
     */
    public function show(Jabatan $kehadirans)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Kehadiran  $kehadirans
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $Request)
    {
        $kehadirans = Kehadiran::findOrFail($Request->get('id'));
        echo json_encode($kehadirans);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Kehadiran  $kehadirans
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Jabatan $kehadirans)
    {
        $this->validate($request, [
            'nama' => 'required',
            'deskripsi' => 'required',
            ]);
   
        $kehadirans = Kehadiran::find($request->id);
        $kehadirans->update($request->all());

        if($kehadirans){
            return redirect()->route('kehadiran')->with(['success' => 'Data Kehadiran'.$request->input('nama').'berhasil disimpan']);
        }else{
            return redirect()->route('kehadiran')->with(['danger' => 'Data Tidak Terekam!']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Kehadiran  $kehadirans
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // $kehadirans = Kehadiran::find($id);
        // $kehadirans->delete();
        $kehadirans = Kehadiran::where('id', $id)
              ->delete();
        return redirect()->route('kehadiran')
                        ->with('success','Post deleted successfully');
    }
}
