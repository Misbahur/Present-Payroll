<?php

namespace App\Http\Controllers\Cetak;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Jadwal;
use App\Models\Pegawai;
use App\Models\Pola;
use App\Models\User;
use App\Models\Bon_kas;
use App\Models\Jabatan;
use App\Models\Penggajian;
use App\Models\Bank;
use App\Models\Metapenggajian;
use App\Models\Setting;

use DB;
use PDF;

class PDFController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
      
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
        //
    }

  public function JadwalPerBulan(Request $request)
    {
         // dd($request->tanggal);
        $month = date('m', strtotime($request->tanggal));

        $jadwal = Jadwal::with(['pegawai','pola'])
        ->whereRaw('MONTH(tanggal) = '. $month)
        ->orderBy('tanggal')  
        ->get();
        $month_title = Jadwal::with(['pegawai','pola'])
        ->whereRaw('MONTH(tanggal) = '. $month)->first();
        $month_title = date('M-Y', strtotime($month_title->tanggal));

      $pdf = PDF::loadView('gocay.cetak.jadwal', ['jadwal' => $jadwal, 'bulan' => $month_title])->setPaper('landscape');
      // download PDF file with download method
      return $pdf->stream('Jadwal Bulan '.$month_title.'.pdf');
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
    public function JadwalPerPegawai($id)
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

    public function BonKasPegawai($id)
    {

        $bonkas = Bon_kas::with(['pegawai'])
        ->whereRaw('pegawai_id = '. $id)
        ->orderBy('tanggal')  
        ->get();
        $pegawai_title = Bon_kas::with(['pegawai'])
        ->whereRaw('pegawai_id = '. $id)
        ->orderBy('tanggal')  
        ->first();
        $total_bon = Bon_kas::with(['pegawai'])
        ->whereRaw('pegawai_id = '. $id)
        ->sum('nominal');

        $pegawai = Pegawai::where('id', $id)->first();

      $pdf = PDF::loadView('gocay.cetak.bonkas', ['adm_pegawai' => $pegawai,'total_bon' => $total_bon,'bonkas' => $bonkas,'pegawai' => $pegawai_title->pegawai->nama])->setPaper('landscape');
      // download PDF file with download method
      return $pdf->stream('Bon Kas '.$pegawai_title->pegawai->nama.'.pdf');
    }
     public function BayarBank(Request $request, $id)
    {

        $bank_title = Bank::whereRaw('id = '. $id) 
        ->first();
        $bank = Bank::all();
        $bank_total = Metapenggajian::select('metapenggajians.*' ,'penggajians.pegawai_id','penggajians.id', 'pegawais.id', 'pegawais.bank_id', 'pegawais.no_rek', 'pegawais.atas_nama', 'pegawais.nama as nama_pegawai')
                            ->join('penggajians', 'penggajians.id', 'metapenggajians.penggajian_id')
                            ->join('pegawais', 'pegawais.id', 'penggajians.pegawai_id')
                            ->where('metapenggajians.status' ,'=', 'in')
                            ->where('pegawais.bank_id' ,'=', $id)
                            ->get()->sum('nominal');
        foreach ($bank as $item):
            $in[$item->id] = Metapenggajian::select('metapenggajians.*' ,'penggajians.pegawai_id','penggajians.id', 'pegawais.id', 'pegawais.bank_id', 'pegawais.no_rek', 'pegawais.atas_nama', 'pegawais.nama as nama_pegawai')
                            ->join('penggajians', 'penggajians.id', 'metapenggajians.penggajian_id')
                            ->join('pegawais', 'pegawais.id', 'penggajians.pegawai_id')
                            ->where('metapenggajians.status' ,'=', 'in')
                            ->where('pegawais.bank_id' ,'=', $item->id)
                            ->get()->sum('nominal');
            $out[$item->id] = Metapenggajian::select('metapenggajians.*' ,'penggajians.pegawai_id','penggajians.id', 'pegawais.id', 'pegawais.bank_id', 'pegawais.no_rek', 'pegawais.atas_nama', 'pegawais.nama as nama_pegawai')
                            ->join('penggajians', 'penggajians.id', 'metapenggajians.penggajian_id')
                            ->join('pegawais', 'pegawais.id', 'penggajians.pegawai_id')
                            ->where('metapenggajians.status' ,'=', 'out')
                            ->where('pegawais.bank_id' ,'=', $item->id)
                            ->get()->sum('nominal');
            $total[$item->id] = intval($in[$item->id] - $out[$item->id]);
            $nama_bank[$item->id] = Bank::where('id', '=' , $item->id)->get()->pluck('nama');
        endforeach;

        $pegawai = Pegawai::where('id', $id)->first();

        $rekening = Metapenggajian::select('metapenggajians.*' ,'penggajians.pegawai_id','penggajians.id', 'pegawais.id', 'pegawais.bank_id', 'pegawais.no_rek', 'pegawais.atas_nama', 'pegawais.nama as nama_pegawai')
                    ->join('penggajians', 'penggajians.id', 'metapenggajians.penggajian_id')
                    ->join('pegawais', 'pegawais.id', 'penggajians.pegawai_id')
                    // ->where('metapenggajians.status' ,'=', 'in')
                    ->where('pegawais.bank_id' ,'=', $id)
                    ->where('metapenggajians.keterangan' ,'=', 'Gaji Pokok')
                    // ->paginate(10);
                    ->get();

        // $request->periode_id == null ? '1' : $request->periode_id;

        // if ($request->periode_id == null):
        //     $periode_id = 1;
        


        // dd($request->periode_id);

        foreach ($rekening as $item):
            $gaji_in[$item->id] = Metapenggajian::select('metapenggajians.*' ,'penggajians.pegawai_id','penggajians.id', 'pegawais.id', 'pegawais.bank_id', 'pegawais.no_rek', 'pegawais.atas_nama', 'pegawais.nama as nama_pegawai')
                                    ->join('penggajians', 'penggajians.id', 'metapenggajians.penggajian_id')
                                    ->join('pegawais', 'pegawais.id', 'penggajians.pegawai_id')
                                    ->where('metapenggajians.status' ,'=', 'in')
                                    ->where('pegawais.id' ,'=', $item->pegawai_id)
                                    ->where('pegawais.bank_id' ,'=', $id)
                                    ->where('penggajians.periode_id' ,'=', $request->periode_id == null ? '1' : $request->periode_id)
                                    ->get()->sum('nominal');   

            $gaji_out[$item->id] = Metapenggajian::select('metapenggajians.*' ,'penggajians.pegawai_id','penggajians.id', 'pegawais.id', 'pegawais.bank_id', 'pegawais.no_rek', 'pegawais.atas_nama', 'pegawais.nama as nama_pegawai')
                                    ->join('penggajians', 'penggajians.id', 'metapenggajians.penggajian_id')
                                    ->join('pegawais', 'pegawais.id', 'penggajians.pegawai_id')
                                    ->where('metapenggajians.status' ,'=', 'out')
                                    ->where('pegawais.id' ,'=', $item->pegawai_id)
                                    ->where('pegawais.bank_id' ,'=', $id)
                                    ->where('penggajians.periode_id' ,'=', $request->periode_id == null ? '1' : $request->periode_id)
                                    ->get()->sum('nominal');      

            $gaji_total[$item->id] = intval($gaji_in[$item->id] - $gaji_out[$item->id]);
        endforeach;

        $bank_id = Bank::where('id', $id)->first();

      $pdf = PDF::loadView('gocay.cetak.bayar-bank', [
            'adm_pegawai' => $pegawai,
            'bank_total' => $bank_total,
            'bank' => $bank,
            'bank_id' => $bank_id,
            'rekening' => $rekening,
            'total' => $total,
            'nama_bank' => $nama_bank,
            'gaji_total' => $gaji_total,
    ])->setPaper('landscape');
      // download PDF file with download method
      return $pdf->stream('Bayar Bank '.$bank_title->nama.'.pdf');
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

  public function Penggajian(Request $request)
    {

     
        $data_id = $request->pegawai_id;
        // dd($data_id);

        // $updateprint = Penggajian::find($id);
        // $updateprint->status_print = 'Sudah Print';
        // $updateprint->update();

        $pegawai = Penggajian::where('id',$data_id)->first();

        $gaji =  Metapenggajian::whereIn('penggajian_id', $data_id)->where('status', 'in')->get();
        $potongan =  Metapenggajian::whereIn('penggajian_id', $data_id)->where('status', 'out')->get();

        $in = Metapenggajian::where('penggajian_id', array($data_id))->where('status', 'in')->get()->sum('nominal');
        $out = Metapenggajian::where('penggajian_id', array($data_id))->where('status', 'out')->get()->sum('nominal');
       

        $setting = Setting::all();

      $pdf = PDF::loadView('gocay.cetak.slipgaji', [
            'data_id' => $data_id,
            'setting' => $setting,
            'pegawai' => $pegawai,
            'gaji' => $gaji,
            'potongan' => $potongan,
            'in' => $in,
            'out' => $out,
    ])->setPaper('a4');
      // download PDF file with download method
      return $pdf->stream('Jadwal Bulan '.'.pdf');
    }

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
