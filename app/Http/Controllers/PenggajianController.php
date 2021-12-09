<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Periode;
use App\Models\Penggajian;
use App\Models\Metapenggajian;
use App\Models\Pegawai;
use App\Models\Temporaries;
use Illuminate\Support\Facades\DB;
use PDF;

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
            
            $gajipokok = DB::table('komponen_gajis')->where('jabatan_id', $pegawai[$i]->jabatan_id)->first();
            // dd($gajipokok);
            $metagaji = new Metapenggajian;
            $metagaji->nominal = $gajipokok->nominal;
            $metagaji->status = 'in';
            $metagaji->keterangan = 'Gaji Pokok';
            $metagaji->penggajian_id = $last_penggajian_id;
            $metagaji->save();
            
            $total_lembur = DB::table('temporaries')->where('status', 'in')->where('pegawai_id', $pegawai[$i]->id)->get()->sum('nominal');

            if ($total_lembur):
                $meta_in_insert = ([
                    'nominal' => $total_lembur,
                    'status' => 'in',
                    'keterangan' => 'Lembur',
                    'penggajian_id' => $last_penggajian_id,
                ]);
                Metapenggajian::create($meta_in_insert);
            endif;

            $total_potongan = DB::table('temporaries')->where('status', 'out')->where('pegawai_id', $pegawai[$i]->id)->get()->sum('nominal');
            // dd($total_potongan);
            if ($total_potongan):
                $meta_out_insert= ([
                    'nominal' => $total_potongan,
                    'status' => 'out',
                    'keterangan' => 'Potongan',
                    'penggajian_id' => $last_penggajian_id,
                ]);
                Metapenggajian::create($meta_out_insert);
            endif;
        } 


        if($periode){
            return redirect()->route('penggajian')->with(['success' => 'Data Periode'.$request->input('nama').'berhasil disimpan']);
        }else{
            return redirect()->route('penggajian')->with(['danger' => 'Data Tidak Terekam!']);
        }

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
    public function detailgaji(Request $request, $id)
    {
        //
        $pegawai = Penggajian::where('id', $id)->first();
        $detail_gajis =  Metapenggajian::where('penggajian_id', $id)->get();    
        $id = $request->id;
        return view('gocay.gajidetail', [
            'pegawai' => $pegawai,
            'detail_gajis' => $detail_gajis,
            'id' => $id
        ]);
    }

    public function tambahbonuspotongan(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'nominal' => 'required',
            'keterangan' => 'required',
            'status' => 'required',
            'penggajian_id' => 'required',
        ]);

        $meta = new Metapenggajian;
        $meta->nominal = $request->input('nominal');
        $meta->keterangan = $request->input('keterangan');
        $meta->status = $request->input('status');
        $meta->penggajian_id = $request->input('penggajian_id');
        $meta->save();
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

    public function yesgajian($id)
    {
        $pegawai = Penggajian::where('id', $id)->first();
        $detail_gajis =  Metapenggajian::where('penggajian_id', $id)->get();

        // share data to view
        $data = [
            'pegawai' => $pegawai,
            'details' => $detail_gajis,
        ];
        view()->share('gocay.invoice', $data);
        $pdf = PDF::loadView('gocay.invoice', $data);
        return $pdf->stream();
        // return view('gocay.invoice');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function hapusbonuspotongan($id)
    {
        //
        $meta = Metapenggajian::find($id);
        $meta->delete();

        return redirect()->back()->with('success','deleted successfully');
    }
}
