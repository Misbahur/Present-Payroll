<?php

namespace App\Http\Controllers;

use App\Models\Kehadiran;
use App\Models\Pegawai;
use App\Models\Kelompok_kerja;
use App\Models\Pola;
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
        
        $kehadirans = Kehadiran::where('tanggal', Carbon::now()->toDateString())
        ->orderBy('tanggal', 'asc')
        ->orderBy('pegawai_id', 'asc')
        ->paginate(10);

        $bulan=array("Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
        $jumlahPegawai = Kehadiran::all()->groupBy('pegawai_id');
        $jumlahPegawaiKasir = Kehadiran::where('tanggal', Carbon::now()->toDateString())
                                ->whereBetween('jabatan_id', ['1', '2']);
        $jumlahSatpam = Kehadiran::where('tanggal', Carbon::now()->toDateString())
                                ->whereBetween('jabatan_id', ['3', '4']);
        // $jumlahPegawaiKasir = Kehadiran::whereBetween('tanggal', [Carbon::now()->subDays(1),Carbon::now()->addDays(1)])->where('jabatan_id', '1')->groupBy('jabatan_id');
        // $kehadirans = Kehadiran::whereBetween('tanggal', [Carbon::now()->subDays(1),Carbon::now()->addDays(1)])->orderBy('tanggal', 'desc')->orderBy('pegawai_id', 'asc')->get();
        // $kehadirans = Kehadiran::all()->orderBy('tanggal', 'desc')->orderBy('pegawai_id', 'asc');
        return view('gocay.kehadiran', [
            'kehadirans' => $kehadirans,
            'jumlahPegawai' => $jumlahPegawai,
            'jumlahPegawaiKasir' => $jumlahPegawaiKasir,
            'jumlahSatpam' => $jumlahSatpam,
            'bulan' => $bulan,
        ]);
        
    }

    public function kehadiran_bulanan()
    {
        $pegawais = Pegawai::all();
        $tanggal_awal = date('j');
        $batas_tanggal = date('t');
        $kehadiran_bulanan = Kehadiran::whereBetween('tanggal', [Carbon::now()->subDays($tanggal_awal),Carbon::now()->addDays($batas_tanggal)])
        ->orderBy('pegawai_id', 'asc')
        ->orderBy('tanggal', 'asc')->get();
        // ->paginate(4);

        $tanggal_terakhir = Kehadiran::latest()->first();
        // dd($kehadiran_bulanan[0]->pegawai_id);

        $kehadirans = Kehadiran::where('tanggal', Carbon::now()->toDateString())
        ->orderBy('tanggal', 'asc')
        ->orderBy('pegawai_id', 'asc')
        ->paginate(10);

        $bulan=array("Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
        return view('gocay.kehadiran-bulanan', [
            'kehadiran_bulanan' => $kehadiran_bulanan,
            'kehadirans' => $kehadirans,
            'pegawais' => $pegawais,
            'bulan' => $bulan,
            'tanggal_terakhir' => $tanggal_terakhir,
        ]);
    }

    // 

    public function filterkehadiran(Request $request)
    {
        $pegawai_id = Pegawai::where('nama','like',"%".$request->filter_nama."%")->pluck('id');
        $bulan_id = date('Y') .'-' . $request->filter_bulan .'-' . $request->filter_tanggal;
        if ($request->filter_nama == ''):
            $kehadirans = Kehadiran::where('tanggal', $bulan_id)
                        ->orderBy('tanggal', 'desc')
                        ->orderBy('pegawai_id', 'asc')
                        ->paginate(10);
        elseif( !$pegawai_id->isEmpty()):
            $kehadirans = Kehadiran::where('tanggal', $bulan_id)
                        ->where('pegawai_id', $pegawai_id)
                        ->orderBy('tanggal', 'desc')
                        ->orderBy('pegawai_id', 'asc')
                        ->paginate(10);
        else:
            $kehadirans = array();
        endif;
        $bulan=array("Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
        $jumlahPegawai = Kehadiran::all()->groupBy('pegawai_id');
        $jumlahPegawaiKasir = Kehadiran::where('tanggal', $bulan_id)
                                ->whereBetween('jabatan_id', ['1', '2']);
        $jumlahSatpam = Kehadiran::where('tanggal', $bulan_id)
                                ->whereBetween('jabatan_id', ['3', '4']);
        // dd($bulan_id);
        return view('gocay.kehadiran', [
            'kehadirans' => $kehadirans,
            'jumlahPegawai' => $jumlahPegawai,
            'jumlahPegawaiKasir' => $jumlahPegawaiKasir,
            'jumlahSatpam' => $jumlahSatpam,
            'bulan' => $bulan,
        ]);
    }

    public function getpolakerja(Request $request)
    {
        $kelompok_kerjas = Kelompok_kerja::all();
        foreach ($kelompok_kerjas as $item):
            $pegawai_id_array = explode('|', $item->pegawai_id);
            for ($x = 0; $x < count($pegawai_id_array); $x++):
                if ($pegawai_id_array[$x] == $request->id):
                    $pegawai_id = $pegawai_id_array[$x];
                    $pola_id = $item->pola_kerja_id;
                    $polas = Pola::findOrFail($pola_id);
                else:
                    continue;
                endif;
            endfor;
        endforeach;
        return response()->json($polas);
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
        $kehadirans['jam_masuk'] = date('H:i', strtotime($kehadirans['jam_masuk']));
        $kehadirans['jam_istirahat'] = date('H:i', strtotime($kehadirans['jam_istirahat']));
        $kehadirans['jam_masuk_istirahat'] = date('H:i', strtotime($kehadirans['jam_masuk_istirahat']));
        $kehadirans['jam_pulang'] = date('H:i', strtotime($kehadirans['jam_pulang']));
        echo json_encode($kehadirans);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Kehadiran  $kehadirans
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Kehadiran $kehadirans)
    {
        $this->validate($request, [
            'pegawai_id' => 'required',
            'jam_masuk' => 'required',
            'jam_istirahat' => 'required',
            'jam_masuk_istirahat' => 'required',
            'jam_pulang' => 'required',
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
