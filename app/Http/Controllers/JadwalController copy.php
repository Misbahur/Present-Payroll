<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jadwal;
use App\Models\Pegawai;
use App\Models\Pola;
use App\Models\User;
use PDF;
class JadwalController extends Controller
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
        $jadwals = Jadwal::orderBy('tanggal', 'desc')
        ->orderBy('pegawai_id', 'asc')
        ->paginate(10);


        $bulan=array("Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");

        $pola = Pola::all();
        $pegawais = Pegawai::all();
        // dd($bulan);
        return view('gocay.jadwal', [
            'jadwals' => $jadwals,
            'pola' => $pola,
            'data_request' => $data_request,
            'pegawais' => $pegawais,
            'bulan' => $bulan,
        ])->with('i', ($request->input('page', 1) - 1) * 10);
        
    }

    public function filterjadwal(Request $request)
    {
        $data_request = $request->all();
        $pegawai_id = Pegawai::where('nama','like',"%".$request->filter_nama."%")->pluck('id');
        $bulan_id = date('Y') .'-' . $request->filter_bulan .'-' . $request->filter_tanggal;
        if ($request->filter_nama == ''):
            $jadwals = Jadwal::where('tanggal', $bulan_id)
                        ->orderBy('pegawai_id', 'asc')
                        ->orderBy('tanggal', 'desc')
                        ->paginate(10);
        elseif( !$pegawai_id->isEmpty()):
            $jadwals = Jadwal::where('tanggal', $bulan_id)
                        ->where('pegawai_id', $pegawai_id)
                        ->orderBy('pegawai_id', 'asc')
                        ->orderBy('tanggal', 'desc')
                        ->paginate(10);
        else:
            $jadwals = array();
        endif;

        $pola = Pola::all();
        $pegawais = Pegawai::all();

        $bulan=array("Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");

        // dd($request->all());
  
        return view('gocay.jadwal', [
            'jadwals' => $jadwals,
            'pola' => $pola,
            'pegawais' => $pegawais,
            'bulan' => $bulan,
            'data_request' => $data_request,
        ])->with('i', ($request->input('page', 1) - 1) * 10);
    }

    public static function pegawai_name($id)
    {
        $pegawais = Pegawai::where('id',$id)->pluck('nama');
        return $pegawais;
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
            'pola_id' => 'required',
            'pegawai_id' => 'required',
         
        ]);
        
        $tanggal = preg_replace("/[^A-Za-z0-9\ ]/", "", explode('-', $request->tanggal));
        // $pegawai_ids = implode('|', $request->pegawai_id);
       
        $x = sizeof(explode('-', $request->tanggal));

        for ($i=0; $i < $x; $i++):
            $tanggal[$i] = date('Y-m-d', strtotime(trim($tanggal[$i], ' ')));
        endfor;


        $tanggal_awal = date_create($tanggal[0]);
        $tanggal_akhir = date_create($tanggal[$x-1]);
        $jarak_tanggal = date_diff($tanggal_awal, $tanggal_akhir)->format('%a');
       

        for ($i=0; $i <= $jarak_tanggal; $i++):
            $tanggal[$i] = date('Y-m-d', strtotime($tanggal[0].'+'.$i.' days'));
            $jadwals = new Jadwal;
            $jadwals->tanggal = $tanggal[$i];
            $jadwals->pola_id = $request->pola_id;
            $jadwals->pegawai_id = $request->pegawai_id;
            $jadwals->save();
            // echo $jadwals . '<br>';
        endfor;
        // $pegawai_ids = implode('|', $request->pegawai_id);
        // $jadwals = new Jadwal;
        // $jadwals->nama = $request->nama;
        // $jadwals->pola_id = $request->pola_id;
        // $jadwals->pegawai_id = $pegawai_ids;
        // $jadwals->save();

        if($jadwals){
            return redirect()->back();
        }else{
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Jadwal  $jadwals
     * @return \Illuminate\Http\Response
     */
    public function show(Jadwal $jadwals)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $Request)
    {
        $jadwals = Jadwal::findOrFail($Request->get('id'));
        echo json_encode($jadwals);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Jadwal  $jadwals
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Jadwal $jadwals)
    {
        $request->validate([
            'tanggal' => 'required',
            'pola_id' => 'required',
            'pegawai_id' => 'required',
        ]);
   
        $jadwals = Jadwal::find($request->id);
        $jadwals->tanggal = $request->tanggal;
        $jadwals->pola_id = $request->pola_id;
        $jadwals->pegawai_id = $request->pegawai_id;
        $jadwals->update();

        if($jadwals){
            return redirect()->back();
        }else{
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Jadwal  $jadwals
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $jadwals = Jadwal::where('id', $id)
              ->delete();
        return redirect()->back()
                        ->with('success','Post deleted successfully');
    }
}
