<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Periode;
use App\Models\Penggajian;
use App\Models\Metapenggajian;
use App\Models\Pegawai;
use App\Models\Temporaries;
use App\Models\Setting;
use App\Models\Bon_kas;
use Illuminate\Support\Facades\DB;
use DomPDF;
use App\Mail\MyTestMail;
use Illuminate\Support\Facades\Mail;

class PenggajianController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data_request = $request->all();
        $penggajians = Penggajian::paginate(10);
        $periodes = Periode::orderBy('created_at', 'DESC')->get();
        return view('gocay/gaji', [
            'penggajians' => $penggajians,
            'periodes' => $periodes,
            'data_request' => $data_request,
        ])->with('i', ($request->input('page', 1) - 1) * 10);
    }

    public function filterperiode(Request $request)
    {
        $request->validate([
            'periode_id' => 'required' 
        ]);
        $data_request = $request->all();
        $penggajians = Penggajian::where('periode_id', $request->periode_id)->paginate(10);
        $periodes = Periode::orderBy('created_at', 'DESC')->get();
        return view('gocay/filtergaji', [
            'penggajians' => $penggajians,
            'periodes' => $periodes,
            'data_request' => $data_request,
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
            
            $total_lembur = DB::table('temporaries')->where('status', 'in-lembur-harian')->where('pegawai_id', $pegawai[$i]->id)->get()->sum('nominal');

            if ($total_lembur):
                $meta_in_insert = ([
                    'nominal' => $total_lembur,
                    'status' => 'in',
                    'keterangan' => 'Lembur',
                    'penggajian_id' => $last_penggajian_id,
                ]);
                Metapenggajian::create($meta_in_insert);
            endif;

            $total_potongan = DB::table('temporaries')->where('status', 'out-telat-harian')->where('pegawai_id', $pegawai[$i]->id)->get()->sum('nominal');
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

            $bolos = DB::table('temporaries')->where('status', 'out-absen-harian')->where('pegawai_id', $pegawai[$i]->id)->get()->sum('nominal');
            // dd($total_potongan);
            if ($bolos):
                $meta_out_insert= ([
                    'nominal' => $bolos,
                    'status' => 'out',
                    'keterangan' => 'Potongan Tidak Masuk',
                    'penggajian_id' => $last_penggajian_id,
                ]);
                Metapenggajian::create($meta_out_insert);
            endif;

            $bonusmingguan = DB::table('temporaries')->where('status', 'in-bonus-mingguan')->where('pegawai_id', $pegawai[$i]->id)->get()->sum('nominal');
            // dd($total_potongan);
            if ($bonusmingguan):
                $meta_in_insert= ([
                    'nominal' => $bonusmingguan,
                    'status' => 'in',
                    'keterangan' => 'Bonus Mingguan',
                    'penggajian_id' => $last_penggajian_id,
                ]);
                Metapenggajian::create($meta_in_insert);
            endif;

            $bonusbulanan = DB::table('temporaries')->where('status', 'in-bonus-bulanan')->where('pegawai_id', $pegawai[$i]->id)->get()->sum('nominal');
            // dd($total_potongan);
            if ($bonusbulanan):
                $meta_in_insert= ([
                    'nominal' => $bonusbulanan,
                    'status' => 'in',
                    'keterangan' => 'Bonus Bulanan',
                    'penggajian_id' => $last_penggajian_id,
                ]);
                Metapenggajian::create($meta_in_insert);
            endif;

            $kepatengen = DB::table('temporaries')->where('status', 'in-bonus-libur-masuk')->where('pegawai_id', $pegawai[$i]->id)->get()->sum('nominal');
            // dd($total_potongan);
            if ($kepatengen):
                $meta_in_insert= ([
                    'nominal' => $kepatengen,
                    'status' => 'in',
                    'keterangan' => 'Bonus Kerja Hari Libur',
                    'penggajian_id' => $last_penggajian_id,
                ]);
                Metapenggajian::create($meta_in_insert);
            endif;

            $tanggal_awal = date("Y-m-d",strtotime($request->input('tanggal_awal')));
            $tanggal_akhir = date("Y-m-d",strtotime($request->input('tanggal_akhir')));
            // dd($tanggal_awal);
            // dd($tanggal_akhir);  

            $bon_kas = Bon_kas::whereDate('tanggal', '>=', $tanggal_awal)->whereDate('tanggal', '<=', $tanggal_akhir)->where('pegawai_id', $pegawai[$i]->id)->get()->sum('nominal');
            // dd($bon_kas);
            if ($bon_kas):
                $meta_out_insert= ([
                    'nominal' => $bon_kas,
                    'status' => 'out',
                    'keterangan' => 'Potongan Bon Kas',
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

    public function bonusall(Request $request)
    {
        $request->validate([
            'keterangan' => 'required',
            'status' => 'required',
            'nominal' => 'required',
            'periode_id' => 'required',
        ]);

        $penggajian_id = Penggajian::where('periode_id', $request->periode_id)->get();
        // dd($penggajian_id);
        $nominal = $request->nominal/Pegawai::count();
        // dd($nominal);
        foreach ($penggajian_id as $value) {
            $tambahbonus = ([
                'keterangan' => $request->keterangan,
                'status' => $request->status,
                'nominal' => $nominal,
                'penggajian_id' => $value->id,
            ]);
            Metapenggajian::create($tambahbonus);
        }

        if($tambahbonus){
            return redirect()->route('penggajian')->with(['success' => 'Data Periode'.$request->input('keterangan').'berhasil disimpan']);
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

        return redirect()->back()->with('success','deleted successfully');
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
        $updateprint = Penggajian::find($id);
        $updateprint->status_print = 'Sudah Print';
        $updateprint->update();

        $pegawai = Penggajian::where('id', $id)->first();

        $gaji =  Metapenggajian::where('penggajian_id', $id)->where('status', 'in')->get();
        $potongan =  Metapenggajian::where('penggajian_id', $id)->where('status', 'out')->get();

        $in = Metapenggajian::where('penggajian_id', $id)->where('status', 'in')->get()->sum('nominal');
        $out = Metapenggajian::where('penggajian_id', $id)->where('status', 'out')->get()->sum('nominal');

        $setting = Setting::all();

        // share data to view
        $data = [
            'setting' => $setting,
            'pegawai' => $pegawai,
            'gaji' => $gaji,
            'potongan' => $potongan,
            'in' => $in,
            'out' => $out,
        ];
        view()->share('gocay.invoice', $data);
        $pdf = DomPDF::loadView('gocay.invoice', $data);
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

    public function ExportPDFPenggajian(Request $request)
    {

     


        $data_id = $request->pegawai_id;
        // dd($data_id);

        // $updateprint = Penggajian::find($id);
        // $updateprint->status_print = 'Sudah Print';
        // $updateprint->update();
        
        $periodes = Periode::where('id', $request->periode_id)->first();

        $pegawai = Penggajian::where('id',$data_id)->first();

        $gaji =  Metapenggajian::whereIn('penggajian_id', $data_id)->where('status', 'in')->get();
        // $potongan =  Metapenggajian::whereIn('penggajian_id', $data_id)->where('status', 'out')->get();


        $in = array();
        $out = array();

        for ($i=0; $i < count($data_id); $i++) { 
            // $in[$i] = Metapenggajian::where('penggajian_id', array($data_id[$i]))->where('status', 'in')->get()->sum('nominal');
            // $out[$i] = Metapenggajian::where('penggajian_id', array($data_id[$i]))->where('status', 'out')->get()->sum('nominal');

            $pemasukan[$i] = Metapenggajian::select('metapenggajians.*' ,'penggajians.pegawai_id','penggajians.id', 'penggajians.periode_id')
                    ->join('penggajians', 'penggajians.id', 'metapenggajians.penggajian_id')
                    ->where('penggajians.periode_id', $request->periode_id)
                    ->where('penggajians.pegawai_id', array($data_id[$i]))
                    ->where('status', 'in')
                    ->get();
            $pengeluaran[$i] = Metapenggajian::select('metapenggajians.*' ,'penggajians.pegawai_id','penggajians.id', 'penggajians.periode_id')
                    ->join('penggajians', 'penggajians.id', 'metapenggajians.penggajian_id')
                    ->where('penggajians.periode_id', $request->periode_id)
                    ->where('penggajians.pegawai_id', array($data_id[$i]))
                    ->where('status', 'out')
                    ->get();

            $in[$i] = Metapenggajian::select('metapenggajians.*' ,'penggajians.pegawai_id','penggajians.id', 'penggajians.periode_id')
                    ->join('penggajians', 'penggajians.id', 'metapenggajians.penggajian_id')
                    ->where('penggajians.periode_id', $request->periode_id)
                    ->where('penggajians.pegawai_id', array($data_id[$i]))
                    ->where('status', 'in')
                    ->get()->sum('nominal');
        
            $out[$i] = Metapenggajian::select('metapenggajians.*' ,'penggajians.pegawai_id','penggajians.id', 'penggajians.periode_id')
                    ->join('penggajians', 'penggajians.id', 'metapenggajians.penggajian_id')
                    ->where('penggajians.periode_id', $request->periode_id)
                    ->where('penggajians.pegawai_id', array($data_id[$i]))
                    ->where('status', 'out')
                    ->get()->sum('nominal');
        }
     
       
// dd($pegawai->periode->tanggal_awal);
        $setting = Setting::all();

      $pdf = DomPDF::loadView('gocay.cetak.slipgaji', [
            'data_id' => $data_id,
            'setting' => $setting,
            'pegawai' => $pegawai,
            'gaji' => $gaji,
            'pemasukan' => $pemasukan,
            'pengeluaran' => $pengeluaran,
            // 'potongan' => $potongan,
            'periodes' => $periodes,
            'in' => $in,
            'out' => $out,
    ])->setPaper('a3');
      // download PDF file with download method
      return $pdf->stream('slipgaji '.$pegawai->periode->tanggal_awal.' - '.$pegawai->periode->tanggal_akhir.'.pdf');
    }

    public function KirimEmailPenggajian($id)
    {
        $datagaji = Penggajian::find($id);
        $datapegawai = Pegawai::where('id', $datagaji['pegawai_id'])->first();
        // dd($datapegawai);

        $pegawai = Penggajian::where('id', $id)->first();

        $gaji =  Metapenggajian::where('penggajian_id', $id)->where('status', 'in')->get();
        $potongan =  Metapenggajian::where('penggajian_id', $id)->where('status', 'out')->get();

        $in = Metapenggajian::where('penggajian_id', $id)->where('status', 'in')->get()->sum('nominal');
        $out = Metapenggajian::where('penggajian_id', $id)->where('status', 'out')->get()->sum('nominal');

        $setting = Setting::all();

        // share data to view
        // $details = [
        //     'setting' => $setting,
        //     'pegawai' => $pegawai,
        //     'gaji' => $gaji,
        //     'potongan' => $potongan,
        //     'in' => $in,
        //     'out' => $out,
        //     'email' => $datapegawai['atas_nama'],
        // ];

        Mail::to($datapegawai['atas_nama'])->send(new MyTestmail($pegawai, $gaji, $potongan, $in, $out, $setting));

        return redirect()->back()->with('success', 'Slip Gaji Berhasil Dikirimkan ke Email Pegawai');
    }
}
