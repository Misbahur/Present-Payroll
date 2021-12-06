<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Periode;
use App\Models\Penggajian;
use App\Models\Metapenggajian;
use App\Models\Pegawai;
use App\Models\Temporaries;
use Illuminate\Support\Facades\DB;

class PenggajianController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $penggajians = Penggajian::paginate(10);
        $periodes = Periode::orderBy('created_at', 'DESC')->get();
        return view('gocay/gaji', [
            'penggajians' => $penggajians,
            'periodes' => $periodes,
        ]);
    }

    public function filterperiode(Request $request)
    {
        $request->validate([
            'periode_id' => 'required' 
        ]);

        $penggajians = Penggajian::where('periode_id', $request->periode_id)->paginate(10);
        $periodes = Periode::orderBy('created_at', 'DESC')->get();
        return view('gocay/gaji', [
            'penggajians' => $penggajians,
            'periodes' => $periodes,
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

     //Tambahkan Periodenya

    public function tambahperiode(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'nama' => 'required',
            'tanggal_awal' => 'required',
            'tanggal_akhir' => 'required',
        ]);

        $periode = ([
            'nama' => $request->input('nama'),
            'tanggal_awal' => date("Y-m-d",strtotime($request->input('tanggal_awal'))),
            'tanggal_akhir' => date("Y-m-d",strtotime($request->input('tanggal_akhir'))), 
        ]);
        $last_periode_id = Periode::create($periode)->id;

        $pegawai = Pegawai::all();
        for ($i=0; $i < count($pegawai); $i++) {
            $penggajian = ([
                'status_print' => 'Belum Print',
                'pegawai_id' => $pegawai[$i]->id,
                'jabatan_id' => $pegawai[$i]->jabatan_id,
                'periode_id' => $last_periode_id,
            ]);
            $last_penggajian_id = Penggajian::create($penggajian)->id; 
            $meta_in = DB::table('temporaries')
            ->select('pegawai_id', DB::raw('SUM(nominal) as total_lembur'))
            ->where('status', 'in')
            ->groupBy('pegawai_id')
            ->get();
            // dd($meta_in);
            foreach ($meta_in as $key => $value) {
            $meta_in_insert = ([
                'nominal' => $value->total_lembur,
                'status' => 'in',
                'keterangan' => 'Lembur Harian',
                'penggajian_id' => $last_penggajian_id,
            ]);
            Metapenggajian::create($meta_in_insert);
            }
            $meta_out = DB::table('temporaries')
            ->select('pegawai_id', DB::raw('SUM(nominal) as total_potongan'))
            ->where('status', 'out')
            ->groupBy('pegawai_id')
            ->get();
            foreach ($meta_out as $key => $value) {
            $meta_out_insert = ([
                'nominal' => $value->total_potongan,
                'status' => 'out',
                'keterangan' => 'Potongan Harian',
                'penggajian_id' => $last_penggajian_id,
            ]);
            Metapenggajian::create($meta_out_insert);
            }
        }


        // if($periode){
        //     return redirect()->route('penggajian')->with(['success' => 'Data Periode'.$request->input('nama').'berhasil disimpan']);
        // }else{
        //     return redirect()->route('penggajian')->with(['danger' => 'Data Tidak Terekam!']);
        // }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
