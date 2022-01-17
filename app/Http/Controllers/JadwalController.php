<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jadwal;
use App\Models\Pegawai;
use App\Models\Pola;
use App\Models\User;
use DB;
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
        $bulan_jadwal = Jadwal::orderBy('tanggal', 'desc')
        ->select('tanggal',DB::raw('YEAR(tanggal) year, MONTH(tanggal) month'))
        ->groupBy('year','month')
        ->get();

        // $cekIdOnJadwals = Jadwal::where('tanggal', '=', date('Y-m-d'))->pluck('pegawai_id');
        // $pegawais = Pegawai::whereNotIn('pegawais.id', $cekIdOnJadwals)
        //             ->select('pegawais.id', 'pegawais.nama')
        //             ->get();

        return view('gocay.jadwal', [
            'jadwals' => $jadwals,
            'pola' => $pola,
            'data_request' => $data_request,
            'pegawais' => $pegawais,
            // 'pegawais_edit' => $pegawais_edit,
            'bulan' => $bulan,
            'bulan_jadwal' => $bulan_jadwal,
        ])->with('i', ($request->input('page', 1) - 1) * 10);
        
    }

    public function filterjadwal(Request $request)
    {
        $data_request = $request->all();
        $pegawai_id = Pegawai::where('nama','like',"%".$request->filter_nama."%")->pluck('id');
        // $bulan_id = date('Y') .'-' . $request->filter_bulan .'-' . $request->filter_tanggal;
        if ($request->filter_nama == ''):
            $jadwals = Jadwal::where('tanggal', $request->filter_tanggal)
                        ->orderBy('pegawai_id', 'asc')
                        ->orderBy('tanggal', 'desc')
                        ->paginate(10);
        elseif( !$pegawai_id->isEmpty()):
            $jadwals = Jadwal::where('tanggal', $request->filter_tanggal)
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

    // public function checkJadwal(Request $request)
    // {
    //     $cekIdOnJadwals = Jadwal::where('tanggal', '=', $request->tanggal)->pluck('pegawai_id');
    //     $pegawais = Pegawai::whereNotIn('pegawais.id', $cekIdOnJadwals)
    //                 ->select('pegawais.id', 'pegawais.nama')
    //                 ->get();
    //     return response()->json($pegawais);
    // }

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
        
       
        $x = sizeof($request->pegawai_id);


        for ($i=0; $i < $x; $i++):
            $jadwals = new Jadwal;
            $jadwals->tanggal = $request->tanggal;
            $jadwals->pola_id = $request->pola_id;
            $jadwals->pegawai_id = $request->pegawai_id[$i];
            $jadwals->save();
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


 public function ExportPDFBulanan(Request $request)
    {
         // dd($request->tanggal);
        $month = date('m', strtotime($request->tanggal));

        $jadwal = Jadwal::with(['pegawai','pola'])
        ->whereRaw('MONTH(tanggal) = '. $month)
        ->get();
        $month_title = Jadwal::with(['pegawai','pola'])
        ->whereRaw('MONTH(tanggal) = '. $month)->first();
        $month_title = date('M-Y', strtotime($month_title->tanggal));

      $pdf = PDF::loadView('gocay.cetak.jadwal', ['jadwal' => $jadwal, 'bulan' => $month_title])->setPaper('landscape');
      // download PDF file with download method
      return $pdf->stream('Jadwal Bulan '.$month_title.'.pdf');
    }

     public function ExportPDFPerPegawai($id)
    {
        // dd($id);

        $jadwal = Jadwal::with(['pegawai','pola'])
        ->whereRaw('pegawai_id = '. $id)
        ->orderBy('tanggal')  
        ->get();
        $pegawai_title = Jadwal::with(['pegawai','pola'])
        ->whereRaw('pegawai_id = '. $id)
        ->orderBy('tanggal')  
        ->first();


      $pdf = PDF::loadView('gocay.cetak.jadwal', ['jadwal' => $jadwal,'bulan' => $pegawai_title->pegawai->nama])->setPaper('landscape');
      // download PDF file with download method
      return $pdf->stream('Jadwal Pegawai '.$pegawai_title->pegawai->nama.'.pdf');
    }

}
