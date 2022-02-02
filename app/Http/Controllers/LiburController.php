<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Libur;
use App\Models\Pegawai;
use App\Models\Pola;
use App\Models\User;

class LiburController extends Controller
{
    //
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data_request = $request->all();
        $liburs = Libur::orderBy('tanggal', 'desc')
        ->orderBy('pegawai_id', 'asc')
        ->paginate(10);

        $bulan=array("Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");

        $pola = Pola::all();
        $pegawais = Pegawai::all();
        // $cekIdOnLiburs = Libur::where('tanggal', '=', date('Y-m-d'))->pluck('pegawai_id');
        // $pegawais = Pegawai::whereNotIn('pegawais.id', $cekIdOnLiburs)
        //             ->select('pegawais.id', 'pegawais.nama')
        //             ->get();
        
        return view('gocay.libur', [
            'liburs' => $liburs,
            'pola' => $pola,
            'pegawais' => $pegawais,
            'bulan' => $bulan,
            'data_request' => $data_request,
        ])->with('i', ($request->input('page', 1) - 1) * 10);
        
    }

    public function filterlibur(Request $request)
    {
        $data_request = $request->all();
        $pegawai_id = Pegawai::where('nama','like',"%".$request->filter_nama."%")->pluck('id');
        // $bulan_id = date('Y') .'-' . $request->filter_bulan .'-' . $request->filter_tanggal;
        $bulan_id = $request->filter_bulan;
        if ($request->filter_nama == ''):
            $liburs = Libur::whereYear('tanggal', date('Y'))
                        ->whereMonth('tanggal', $bulan_id)
                        ->orderBy('pegawai_id', 'asc')
                        ->orderBy('tanggal', 'desc')
                        ->paginate(10);
        elseif( !$pegawai_id->isEmpty()):
            $liburs = Libur::whereYear('tanggal', date('Y'))
                        ->whereMonth('tanggal', $bulan_id)
                        ->where('pegawai_id', $pegawai_id)
                        ->orderBy('pegawai_id', 'asc')
                        ->orderBy('tanggal', 'desc')
                        ->paginate(10);
        else:
            $liburs = array();
        endif;

        $pola = Pola::all();
        $pegawais = Pegawai::all();

        $bulan=array("Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
  
        return view('gocay.libur', [
            'liburs' => $liburs,
            'pola' => $pola,
            'pegawais' => $pegawais,
            'data_request' => $data_request,
            'bulan' => $bulan,
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

    // public function checkLibur(Request $request)
    // {
    //     $cekIdOnLiburs = Jadwal::where('tanggal', '=', $request->tanggal)->pluck('pegawai_id');
    //     $pegawais = Pegawai::whereNotIn('pegawais.id', $cekIdOnLiburs)
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
            'pegawai_id' => 'required',
         
        ]);
        
        $x = sizeof($request->pegawai_id);


        for ($i=0; $i < $x; $i++):
            $liburs = new libur;
            $liburs->tanggal = $request->tanggal;
            $liburs->pegawai_id = $request->pegawai_id[$i];
            $liburs->save();
        endfor;
        // $liburs = new libur;
        // $liburs->tanggal = $request->tanggal;
        // $liburs->pegawai_id = $request->pegawai_id;
        // $liburs->save();

        if($liburs){
            return redirect()->route('libur')->with(['success' => 'Data libur'.$request->input('nama').'berhasil disimpan']);
        }else{
            return redirect()->route('libur')->with(['danger' => 'Data Tidak Terekam!']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\libur  $liburs
     * @return \Illuminate\Http\Response
     */
    public function show(libur $liburs)
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
        $liburs = Libur::findOrFail($Request->get('id'));
        echo json_encode($liburs);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\libur  $liburs
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, libur $liburs)
    {
        $request->validate([
            'tanggal' => 'required',
            'pegawai_id' => 'required',
        ]);
   
        $liburs = Libur::find($request->id);
        $liburs->tanggal = $request->tanggal;
        $liburs->pegawai_id = $request->pegawai_id;
        $liburs->update();

        if($liburs){
            return redirect()->route('libur')->with(['success' => 'Data Kelompok Keja'.$request->input('tanggal').'berhasil disimpan']);
        }else{
            return redirect()->route('libur')->with(['danger' => 'Data Tidak Terekam!']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\libur  $liburs
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $liburs = Libur::where('id', $id)
              ->delete();
        return redirect()->route('libur')
                        ->with('success','Post deleted successfully');
    }
}
