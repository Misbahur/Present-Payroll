<?php

namespace App\Http\Controllers;

use App\Models\Kehadiran;
use App\Models\Pegawai;
use App\Models\Jabatan;
use App\Models\Jadwal;
use App\Models\Pola;
use App\Models\Temporary;
use App\Models\Lembur;
use App\Models\Libur;
use App\Models\Pengecualian;
use App\Models\Komponen_gaji;
use Carbon\Carbon;
use Illuminate\Http\Request;
use DB;
use PDF;
use SnappyPDF;
class KehadiranController extends Controller
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
        $jabatans = Jabatan::all();
        $kehadirans = Kehadiran::select('kehadirans.*', 'pegawais.id as pegawaiID', 'pegawais.nama as nama_pegawai')
        ->join('pegawais', 'pegawais.id', '=', 'kehadirans.pegawai_id')
        ->where('tanggal', Carbon::now()->toDateString())
        ->orderBy('tanggal', 'asc')
        ->orderBy('pegawai_id', 'asc')
        ->paginate(10);

        $bulan=array("Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
        $jumlahPegawai = Kehadiran::where('tanggal', Carbon::now()->toDateString())
        ->where('jam_masuk', '!=', null)
        ->orderBy('tanggal', 'asc')
        ->orderBy('pegawai_id', 'asc');
        foreach ($jabatans as $item):
            $jabatan_total[$item->id] = Kehadiran::where('tanggal', Carbon::now()->toDateString())
                    ->join('pegawais', 'kehadirans.pegawai_id' ,'=','pegawais.id')
                    ->join('jabatans', 'pegawais.jabatan_id' ,'=','jabatans.id')
                    ->where('jam_masuk', '!=', null)
                    ->where('jabatan_id', $item->id)
                    ->get();
        endforeach;

        $tanggal = date('Y-m-d');
        // $jumlahPegawaiKasir = Kehadiran::where('tanggal', Carbon::now()->toDateString())
        //                         ->whereBetween('jabatan_id', ['1', '2']);
        // $jumlahSatpam = Kehadiran::where('tanggal', Carbon::now()->toDateString())
        //                         ->whereBetween('jabatan_id', ['3', '4']);
        // $jumlahPegawaiKasir = Kehadiran::whereBetween('tanggal', [Carbon::now()->subDays(1),Carbon::now()->addDays(1)])->where('jabatan_id', '1')->groupBy('jabatan_id');
        // $kehadirans = Kehadiran::whereBetween('tanggal', [Carbon::now()->subDays(1),Carbon::now()->addDays(1)])->orderBy('tanggal', 'desc')->orderBy('pegawai_id', 'asc')->get();
        // $kehadirans = Kehadiran::all()->orderBy('tanggal', 'desc')->orderBy('pegawai_id', 'asc');
        return view('gocay.kehadiran', [
            'kehadirans' => $kehadirans,
            'jumlahPegawai' => $jumlahPegawai,
            'jabatan_total' => $jabatan_total,
            'jabatans' => $jabatans,
            'data_request' => $data_request,
            'bulan' => $bulan,
            'tanggal' => $tanggal,
        ])->with('i', ($request->input('page', 1) - 1) * 10);
        
    }

    public function kehadiran_bulanan(Request $request)
    {
        // $batas_tanggal = date('t');
        // $kehadiran_bulanan = Kehadiran::whereBetween('tanggal', [date('Y-m-d', strtotime('first day of this month')),date('Y-m-d', strtotime('last day of this month'))])
        // ->whereYear('tanggal', date('Y'))
        // ->whereMonth('tanggal', date('m'))
        // ->orderBy('pegawai_id', 'asc')
        // ->orderBy('tanggal', 'asc')
        // ->get();
        $tanggal = date('Y') .'-' . date('m') .'-' . $request->tanggal;
        $kehadiran_data = Kehadiran::where('tanggal', $tanggal)
        ->where('pegawai_id', $request->pegawai_id)
        ->get();
        $bulan_jadwal = Kehadiran::orderBy('tanggal', 'desc')
        ->select('tanggal',DB::raw('YEAR(tanggal) year, MONTH(tanggal) month'))
        ->groupBy('year','month')
        ->get();
        $pegawais = Pegawai::all();
        foreach ($pegawais as $p):
            for ($x=1; $x <= date('t'); $x++):
                $tanggal = date('Y') .'-' . date('m') .'-' . $x;
                $kehadiran_bulanan[$p->id][$x] = Kehadiran::where('tanggal', date('Y-m-d', strtotime($tanggal)))
                ->where('pegawai_id', $p->id)
                ->get();
            endfor;
        endforeach;
        $tanggal_terakhir = Kehadiran::latest()->first();

        // $kehadirans = Kehadiran::where('tanggal', Carbon::now()->toDateString())
        // ->orderBy('tanggal', 'asc')
        // ->orderBy('pegawai_id', 'asc')
        // ->paginate(10);

        $bulan=array("Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
        return view('gocay.kehadiran-bulanan', [
            'kehadiran_bulanan' => $kehadiran_bulanan,
            // 'kehadirans' => $kehadirans,
            'bulan_jadwal' => $bulan_jadwal,
            'pegawais' => $pegawais,
            'bulan' => $bulan,
            // 'tanggal_terakhir' => $tanggal_terakhir,
        ]);
    }

    public function data_bulanan(Request $request)
    {
       
        $tanggal = date('Y') .'-' . date('m') .'-' . $request->tanggal;
        $data_bulanan = Kehadiran::where('tanggal', $tanggal)
        ->where('pegawai_id', $request->id)
        ->first();
        if ($data_bulanan):
            return response()->json($data_bulanan);
        endif;
    }


    public function filterkehadiran(Request $request)
    {
        $jabatans = Jabatan::all();
        $data_request = $request->all();
        $pegawai_id = Pegawai::where('nama','like',"%".$request->filter_nama."%")->pluck('id');
        // $bulan_id = date('Y') .'-' . $request->filter_bulan .'-' . $request->filter_tanggal;


        $tanggal = $request->filter_tanggal;

        if ($request->filter_nama == ''):
            $kehadirans = Kehadiran::select('kehadirans.*', 'pegawais.id as pegawaiID', 'pegawais.nama as nama_pegawai')
                        ->join('pegawais', 'pegawais.id', '=', 'kehadirans.pegawai_id')
                        ->where('tanggal', $tanggal)
                        ->orderBy('tanggal', 'desc')
                        ->orderBy('pegawai_id', 'asc')
                        ->paginate(10);
        elseif( !$pegawai_id->isEmpty()):
            $kehadirans = Kehadiran::select('kehadirans.*', 'pegawais.id as pegawaiID', 'pegawais.nama as nama_pegawai')
                        ->join('pegawais', 'pegawais.id', '=', 'kehadirans.pegawai_id')
                        ->where('tanggal', $tanggal)
                        ->where('pegawai_id', $pegawai_id)
                        ->orderBy('tanggal', 'desc')
                        ->orderBy('pegawai_id', 'asc')
                        ->paginate(10);
        else:
            $kehadirans = array();
        endif;
        $bulan=array("Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
        $jumlahPegawai = Kehadiran::where('tanggal', $tanggal)
        ->where('jam_masuk', '!=', null)
        ->orderBy('tanggal', 'asc')
        ->orderBy('pegawai_id', 'asc');
        foreach ($jabatans as $item):
            $jabatan_total[$item->id] = Kehadiran::where('tanggal', $tanggal)
                    ->join('pegawais', 'kehadirans.pegawai_id' ,'=','pegawais.id')
                    ->join('jabatans', 'pegawais.jabatan_id' ,'=','jabatans.id')
                    ->where('jam_masuk', '!=', null)
                    ->where('jabatan_id', $item->id)
                    ->get();
        endforeach;
        return view('gocay.kehadiran', [
            'kehadirans' => $kehadirans,
            'jumlahPegawai' => $jumlahPegawai,
            'jabatan_total' => $jabatan_total,
            'jabatans' => $jabatans,
            'data_request' => $data_request,
            'bulan' => $bulan,
            'tanggal' => $tanggal,
        ])->with('i', ($request->input('page', 1) - 1) * 10);
    }

    public function kehadiran_jabatan(Request $request)
    {
        $data_request = $request->all();
        $kehadirans = Kehadiran::where('tanggal', $request->tanggal)
                    ->join('pegawais', 'kehadirans.pegawai_id' ,'=','pegawais.id')
                    ->join('jabatans', 'pegawais.jabatan_id' ,'=','jabatans.id')
                    ->where('jam_masuk', '!=', null)
                    ->where('jabatan_id', $request->id)
                    ->paginate(10);
        return view('gocay.kehadiran-jabatan', [
            'kehadirans' => $kehadirans,
            'data_request' => $data_request,
        ])->with('i', ($request->input('page', 1) - 1) * 10);
    }


    public function getpolakerja(Request $request)
    {

        $jadwals = Jadwal::where('tanggal', date('Y-m-d', strtotime($request->tanggal)))
        ->where('pegawai_id', $request->id)
        ->first();

        if($jadwals != null):
            $polas = Pola::findOrFail($jadwals->pola_id);
            return response()->json($polas);
            // echo json_encode($polas);
            // return $polas;
        endif;
        // return response()->json($polas);
    }

    public function cekAbsenPegawai()
    {
        $jadwal_libur = Libur::all();
        $komponen_gaji = Komponen_gaji::all();
        $pegawais = Pegawai::all();
        
        if (date('d') <= 7):
            $tanggal_awal = date('Y-m-d', strtotime('first day of this month'));
            $tanggal_akhir = date('Y-m-d', strtotime('+5 day', strtotime($tanggal_awal)));
        elseif (date('d') <= 14):
            $tanggal_awal = date('Y-m-d', strtotime('+7 day', strtotime('first day of this month')));
            $tanggal_akhir = date('Y-m-d', strtotime('+5 day', strtotime($tanggal_awal)));
        elseif (date('d') <= 21):
            $tanggal_awal = date('Y-m-d', strtotime('+14 day', strtotime('first day of this month')));
            $tanggal_akhir = date('Y-m-d', strtotime('+5 day', strtotime($tanggal_awal)));
        elseif (date('d') <= date('t')):
            $tanggal_awal = date('Y-m-d', strtotime('+21 day', strtotime('first day of this month')));
            $tanggal_akhir = date('Y-m-d', strtotime('+5 day', strtotime($tanggal_awal)));
        endif;
        


        foreach ($pegawais as $p):
            $range = Kehadiran::whereBetween('tanggal', [$tanggal_awal ,$tanggal_akhir])
            ->where('pegawai_id', $p->id)
            ->get();

            foreach ($range as $item):
                $libur = Libur::where('tanggal', $item->tanggal)
                    ->where('pegawai_id', $p->id)
                    ->get();
                $cekKehadiran = Kehadiran::where('tanggal', $item->tanggal)
                    ->where('jam_masuk', null)
                    ->where('jam_istirahat', null)
                    ->where('jam_masuk_istirahat', null)
                    ->where('jam_pulang', null)
                    ->where('pegawai_id', $p->id)
                    ->get();
                $pengecualian = Pengecualian::where('tanggal', date('Y-m-d', strtotime('-1 day', strtotime($item->tanggal))))
                ->where('pegawai_id', $p->id)
                ->get();

                if ($cekKehadiran->isEmpty()):
                    continue;
                else:
                    if($libur->isEmpty()):
                        if($pengecualian->isEmpty()):
                            $temporary_out = new Temporary;
                            $temporary_out->tanggal = Carbon::now();
                            $temporary_out->status = 'out-absen-harian';
                            $temporary_out->pegawai_id = $p->id;
                            $temporary_out->nominal = $komponen_gaji[0]->nominal;
                            $temporary_out->save();
                        else:
                            continue;
                        endif;
                    else:
                        continue;
                    endif;
                endif;
            endforeach;

        endforeach;

        
        // return redirect()->route('kehadiran');
        
    }

    public function bonusMingguan()
    {
        $komponen_gaji = Komponen_gaji::all();
        $pegawais = Pegawai::all();
        
        if (date('d') <= 7):
            $tanggal_awal = date('Y-m-d', strtotime('first day of this month'));
            $tanggal_akhir = date('Y-m-d', strtotime('+5 day', strtotime($tanggal_awal)));
        elseif (date('d') <= 14):
            $tanggal_awal = date('Y-m-d', strtotime('+7 day', strtotime('first day of this month')));
            $tanggal_akhir = date('Y-m-d', strtotime('+5 day', strtotime($tanggal_awal)));
        elseif (date('d') <= 21):
            $tanggal_awal = date('Y-m-d', strtotime('+14 day', strtotime('first day of this month')));
            $tanggal_akhir = date('Y-m-d', strtotime('+5 day', strtotime($tanggal_awal)));
        elseif (date('d') <= date('t')):
            $tanggal_awal = date('Y-m-d', strtotime('+21 day', strtotime('first day of this month')));
            $tanggal_akhir = date('Y-m-d', strtotime('+5 day', strtotime($tanggal_awal)));
        endif;
        


        foreach ($pegawais as $p):
            $range = Kehadiran::whereBetween('tanggal', [$tanggal_awal ,$tanggal_akhir])
            ->where('pegawai_id', $p->id)
            ->get();

            if($range->isNotEmpty()):
            foreach ($range as $item):
                $jadwals = Jadwal::where('tanggal', $item->tanggal)
                ->where('pegawai_id', $p->id)
                ->orderBy('tanggal', 'desc')
                ->orderBy('pegawai_id', 'asc')->get();

                $temp = Temporary::where('tanggal', date('Y-m-d'))
                ->where('pegawai_id', $p->id)
                ->where('status', 'in-bonus-mingguan')
                ->first();

                // if($jadwals->isNotEmpty()):
                //     $polas = Pola::findOrFail($jadwals[0]->pola_id);
                // else:
                //     continue;
                // endif;
                $countDate = Kehadiran::whereBetween('tanggal', [$tanggal_awal ,$tanggal_akhir])
                    // ->where('jam_masuk', '<=' ,$polas['jam_masuk'])
                    // ->where('jam_istirahat', '>=' ,$polas['jam_istirahat'])
                    // ->where('jam_masuk_istirahat', '<=' ,$polas['jam_istirahat_masuk'])
                    // ->where('jam_pulang', '>=' ,$polas['jam_pulang'])
                    ->where('jam_masuk', '!=' , null)
                    ->orWhere('jam_istirahat', '!=' , null)
                    ->orWhere('jam_masuk_istirahat', '!=' , null)
                    ->orWhere('jam_pulang', '!=' , null)
                    ->orWhere('pegawai_id', $p->id)
                    ->get()->count('pegawai_id');
                
                if ($countDate == 6 and $temp == null):
                    $temporary_in = new Temporary;
                    $temporary_in->tanggal = Carbon::now();
                    $temporary_in->status = 'in-bonus-mingguan';
                    $temporary_in->pegawai_id = $p->id;
                    $temporary_in->nominal = $komponen_gaji[0]->nominal;
                    $temporary_in->save();
                    break;
                else:
                    continue;
                endif;

                endforeach;
                
            else:
                continue;
            endif;
            
        endforeach;


        
        return redirect()->route('kehadiran');
        
    }

    public function bonusMasukLibur()
    {
        $komponen_gaji = Komponen_gaji::all();
        $pegawais = Pegawai::all();
        
        if (date('d') <= 7):
            $tanggal_awal = date('Y-m-d', strtotime('first day of this month'));
            $tanggal_akhir = date('Y-m-d', strtotime('+6 day', strtotime($tanggal_awal)));
        elseif (date('d') <= 14):
            $tanggal_awal = date('Y-m-d', strtotime('+7 day', strtotime('first day of this month')));
            $tanggal_akhir = date('Y-m-d', strtotime('+6 day', strtotime($tanggal_awal)));
        elseif (date('d') <= 21):
            $tanggal_awal = date('Y-m-d', strtotime('+14 day', strtotime('first day of this month')));
            $tanggal_akhir = date('Y-m-d', strtotime('+6 day', strtotime($tanggal_awal)));
        elseif (date('d') <= date('t')):
            $tanggal_awal = date('Y-m-d', strtotime('+21 day', strtotime('first day of this month')));
            $tanggal_akhir = date('Y-m-d', strtotime('+6 day', strtotime($tanggal_awal)));
        endif;
        


        foreach ($pegawais as $p):
            $range = Kehadiran::whereBetween('tanggal', [$tanggal_awal ,$tanggal_akhir])
            ->where('pegawai_id', $p->id)
            ->get();
            foreach ($range as $item):
                // $jadwals = Jadwal::where('tanggal', $item->tanggal)
                // ->where('pegawai_id', $p->id)
                // ->orderBy('tanggal', 'desc')
                // ->orderBy('pegawai_id', 'asc')->get();
                // $polas = Pola::findOrFail($jadwals[0]->pola_id);
                $countDate = Kehadiran::whereBetween('tanggal', [$tanggal_awal ,$tanggal_akhir])
                    // ->where('jam_masuk', '<=' ,$polas['jam_masuk'])
                    // ->where('jam_istirahat', '>=' ,$polas['jam_istirahat'])
                    // ->where('jam_masuk_istirahat', '<=' ,$polas['jam_istirahat_masuk'])
                    // ->where('jam_pulang', '>=' ,$polas['jam_pulang'])
                    ->where('jam_masuk', '!=' , null)
                    ->orWhere('jam_istirahat', '!=' , null)
                    ->orWhere('jam_masuk_istirahat', '!=' , null)
                    ->orWhere('jam_pulang', '!=' , null)
                    ->orWhere('pegawai_id', $p->id)
                    ->where('pegawai_id', $p->id)
                    ->get()->count('pegawai_id');
            endforeach;
            if ($countDate == 7):
                $temporary_in = new Temporary;
                $temporary_in->tanggal = Carbon::now();
                $temporary_in->status = 'in-bonus-libur-masuk';
                $temporary_in->pegawai_id = $p->id;
                $temporary_in->nominal = $komponen_gaji[0]->nominal;
                $temporary_in->save();
            else:
                continue;
            endif;
        endforeach;

        
        return redirect()->route('kehadiran');
        
    }

    public function bonusBulanan()
    {
        $komponen_gaji = Komponen_gaji::all();
        $pegawais = Pegawai::all();
        
        foreach ($pegawais as $p):
            $countDate = Temporary::whereYear('tanggal', date('Y'))
            ->whereMonth('tanggal', date('m'))
            ->where('pegawai_id', $p->id)
            ->get()->count();
            
            if ($countDate == 4):
                //add bonus mingguan to temporary tabel
                $temporary_in = new Temporary;
                $temporary_in->tanggal = Carbon::now();
                $temporary_in->status = 'in-bonus-bulanan';
                $temporary_in->pegawai_id = $p->id;
                $temporary_in->nominal = $komponen_gaji[1]->nominal;
                $temporary_in->save();
            else:
                continue;
            endif;
        endforeach;

        return redirect()->route('kehadiran');
        
    }

    public function bonusBulananBackup()
    {
        $komponen_gaji = Komponen_gaji::all();
        $pegawais = Pegawai::all();
        
        foreach ($pegawais as $p):
            $range = Kehadiran::whereBetween('tanggal', [date('Y-m-d', strtotime('first day of this month')),date('Y-m-d', strtotime('last day of this month'))])
            ->where('pegawai_id', $p->id)
            ->get();
            foreach ($range as $item):
                $jadwals = Jadwal::where('tanggal', $item->tanggal)
                ->where('pegawai_id', $p->id)
                ->orderBy('tanggal', 'desc')
                ->orderBy('pegawai_id', 'asc')->get();
                $polas = Pola::findOrFail($jadwals[0]->pola_id);
                $countDate = Kehadiran::whereBetween('tanggal', [date('Y-m-d', strtotime('first day of this month')),date('Y-m-d', strtotime('last day of this month'))])
                    ->where('jam_masuk', '<=' ,$polas['jam_masuk'])
                    ->where('jam_istirahat', '>=' ,$polas['jam_istirahat'])
                    ->where('jam_masuk_istirahat', '<=' ,$polas['jam_istirahat_masuk'])
                    ->where('jam_pulang', '>=' ,$polas['jam_pulang'])
                    ->where('pegawai_id', $p->id)
                    ->get()->count('pegawai_id');
                   
            endforeach;
            // if ($countDate >= 2):
            if ($countDate == (date('t'))-4):
                //add bonus mingguan to temporary tabel
                $temporary_in = new Temporary;
                $temporary_in->tanggal = Carbon::now();
                $temporary_in->status = 'in-bonus-bulanan';
                $temporary_in->pegawai_id = $p->id;
                $temporary_in->nominal = $komponen_gaji[2]->nominal;
                $temporary_in->save();
            else:
                continue;
            endif;
        endforeach;

        return redirect()->route('kehadiran');
        
    }

    // public function telatlembur(Request $request)
    // {
    //     $request->validate([
    //         'tanggal' => 'required',
    //         'durasi' => 'required',
    //         'status' => 'required',
    //         'pegawai_id' => 'required',
         
    //     ]);

    //     $temp = Temporary::where('tanggal', $request->tanggal)
    //     ->where('pegawai_id', $request->pegawai_id)
    //     ->where('status', $request->status)
    //     ->get();

    //     $lembur = Lembur::all();
    //     $pengecualian = Pengecualian::where('tanggal', date('Y-m-d', strtotime('-1 day', strtotime($request->tanggal))))
    //                     ->where('pegawai_id', $request->pegawai_id)
    //                     ->get();
       
    //     if ($temp->isEmpty()):
    //         if ($request->status == 'out-telat-harian' && $request->durasi >  $lembur[1]->durasi && $pengecualian->isEmpty()):
    //             $temporary_out = new Temporary;
    //             $temporary_out->status = 'out-telat-harian';
    //             $temporary_out->tanggal = $request->tanggal;
    //             $temporary_out->pegawai_id = $request->pegawai_id;
    //             for($i=1; $i <= intval($request->durasi/$lembur[1]->durasi); $i++ ):
    //                 $temporary_out->nominal +=  $lembur[1]->nominal;
    //             endfor;
    //             $temporary_out->save();
    //         endif;
    //         if ($request->status == 'out-istirahat' && $request->durasi >  $lembur[1]->durasi && $pengecualian->isEmpty()):
    //             $temporary_out = new Temporary;
    //             $temporary_out->status = 'out-istirahat';
    //             $temporary_out->tanggal = $request->tanggal;
    //             $temporary_out->pegawai_id = $request->pegawai_id;
    //             for($i=1; $i <= intval($request->durasi/$lembur[1]->durasi); $i++ ):
    //                 $temporary_out->nominal +=  $lembur[1]->nominal;
    //             endfor;
    //             $temporary_out->save();
    //         endif;
    //         if ($request->status == 'out-istirahat-masuk' && $request->durasi >  $lembur[1]->durasi && $pengecualian->isEmpty()):
    //             $temporary_out = new Temporary;
    //             $temporary_out->status = 'out-istirahat-masuk';
    //             $temporary_out->tanggal = $request->tanggal;
    //             $temporary_out->pegawai_id = $request->pegawai_id;
    //             for($i=1; $i <= intval($request->durasi/$lembur[1]->durasi); $i++ ):
    //                 $temporary_out->nominal +=  $lembur[1]->nominal;
    //             endfor;
    //             $temporary_out->save();
    //         endif;
    //         if ($request->status == 'in-lembur-harian' && $request->durasi >  $lembur[0]->durasi):
    //                 $temporary_in = new Temporary;
    //                 $temporary_in->status = 'in-lembur-harian';
    //                 $temporary_in->tanggal = $request->tanggal;
    //                 $temporary_in->pegawai_id = $request->pegawai_id;
    //                 for($i=1; $i <= intval($request->durasi/$lembur[0]->durasi); $i++ ):
    //                     $temporary_in->nominal +=  $lembur[0]->nominal;
    //                 endfor;
    //                 $temporary_in->save();

    //             endif;
    //         if ($request->status == 'in-lembur-harian-PS'):
    //                 $temporary_in = new Temporary;
    //                 $temporary_in->status = 'in-lembur-harian';
    //                 $temporary_in->tanggal = $request->tanggal;
    //                 $temporary_in->pegawai_id = $request->pegawai_id;
    //                 for($i=1; $i <= intval($request->durasi/$lembur[0]->durasi); $i++ ):
    //                     $temporary_in->nominal +=  $lembur[0]->nominal;
    //                 endfor;
    //                 $temporary_in->save();

    //             endif;
    //     endif;
        

        
    // }

    public function telatlembur()
    {

        $pegawais = Pegawai::all();

        

        $lembur = Lembur::all();
        
       
        foreach ($pegawais as $p):
            $kehadiran = Kehadiran::whereMonth('tanggal', '02')
            ->whereYear('tanggal', '2022')
            ->where('pegawai_id', $p->id)
            ->get();

            foreach ($kehadiran as $k):

            
            $jadwals = Jadwal::where('tanggal', $k->tanggal)
            ->where('pegawai_id', $p->id)
            ->first();

            $pengecualian = Pengecualian::where('tanggal', date('Y-m-d', strtotime('-1 day', strtotime($k->tanggal))))
            ->where('pegawai_id', $p->id)
            ->get();

            $temp = Temporary::where('tanggal', $k->tanggal)
            ->where('pegawai_id', $p->id)
            ->first();

            if ($jadwals != null):
                $polas = Pola::findOrFail($jadwals->pola_id);
                $k->pola_masuk = $polas->jam_masuk;
                $k->pola_istirahat = $polas->jam_istirahat;
                $k->pola_istirahat_masuk = $polas->jam_istirahat_masuk;
                $k->pola_pulang = $polas->jam_pulang;
                $k->pola_nama = $polas->nama;

                $jam_masuk = strtotime($k->jam_masuk);
                $pola_masuk = strtotime($k->pola_masuk);
                $k->durasi_masuk = abs($jam_masuk - $pola_masuk)/60;

                $jam_masuk_istirahat = strtotime($k->jam_masuk_istirahat);
                $pola_istirahat_masuk = strtotime($k->pola_istirahat_masuk);
                $k->durasi_masuk_istirahat = abs($jam_masuk_istirahat - $pola_istirahat_masuk)/60;

                if($k->jam_masuk > $k->pola_masuk && $k->durasi_masuk >  $lembur[1]->durasi && $pengecualian->isEmpty() && $temp == null):
                    $temporary_out = new Temporary;
                    $temporary_out->status = 'out-telat-harian';
                    $temporary_out->tanggal = $k->tanggal;
                    $temporary_out->pegawai_id = $p->id;
                    for($i=1; $i <= intval($k->durasi_masuk/$lembur[1]->durasi); $i++ ):
                        $temporary_out->nominal +=  $lembur[1]->nominal;
                    endfor;
                    $temporary_out->save();
                
                elseif($k->jam_masuk_istirahat > $k->pola_istirahat_masuk && $k->durasi_masuk_istirahat >  $lembur[1]->durasi && $pengecualian->isEmpty() && $temp == null):
                    $temporary_out = new Temporary;
                    $temporary_out->status = 'out-istirahat-masuk';
                    $temporary_out->tanggal = $k->tanggal;
                    $temporary_out->pegawai_id = $p->id;
                    for($i=1; $i <= intval($k->durasi_masuk/$lembur[1]->durasi); $i++ ):
                        $temporary_out->nominal +=  $lembur[1]->nominal;
                    endfor;
                    $temporary_out->save();
                

                elseif($k->jam_pulang > $k->pola_pulang && $k->pola_nama == 'Pagi' ):
                    $k->status = 'in-lembur-harian';
                    $jam_pulang = strtotime($k->jam_pulang);
                    $pola_pulang = strtotime($k->pola_pulang);
                    $k->durasi = abs($jam_pulang - $pola_pulang)/60;
                elseif($k->pola_nama == 'Full Day 1' ):
                    $k->status = 'in-lembur-FD-1';
                    $jam_masuk_istirahat = strtotime($k->jam_masuk_istirahat);
                    $jam_istirahat = strtotime($k->jam_istirahat);
                    $k->durasi = abs($jam_masuk_istirahat - $jam_istirahat)/60;
                elseif($k->pola_nama == 'Full Day 2' ):
                    $k->status = 'in-lembur-FD-2';
                    $jam_masuk_istirahat = strtotime($k->jam_masuk_istirahat);
                    $jam_istirahat = strtotime($k->jam_istirahat);
                    $k->durasi = abs($jam_masuk_istirahat - $jam_istirahat)/60;
                elseif($k->pola_nama == 'Full Day 3' ):
                    $k->status = 'in-lembur-FD-3';
                    $jam_masuk_istirahat = strtotime($k->jam_masuk_istirahat);
                    $jam_istirahat = strtotime($k->jam_istirahat);
                    $k->durasi = abs($jam_masuk_istirahat - $jam_istirahat)/60;
                endif;
            else:
                continue;
            endif;


            if ($temp == null):
                if ( $k->pola_nama == 'Pagi' && $k->durasi >  $lembur[0]->durasi ):
                    $temporary_in = new Temporary;
                    $temporary_in->status = 'in-lembur-harian';
                    $temporary_in->tanggal = $k->tanggal;
                    $temporary_in->pegawai_id = $p->id;
                    for($i=1; $i <= intval($k->durasi/$lembur[0]->durasi); $i++ ):
                        $temporary_in->nominal +=  $lembur[0]->nominal;
                    endfor;
                    $temporary_in->save();
                endif;
           
                if ($k->pola_nama == 'Full Day 1' && $k->durasi < 120):
                    $temporary_in = new Temporary;
                    $temporary_in->status = 'in-lembur-FD-1';
                    $temporary_in->tanggal = $k->tanggal;
                    $temporary_in->pegawai_id = $p->id;
                    for($i=1; $i <= 2; $i++ ):
                        $temporary_in->nominal +=  $lembur[0]->nominal;
                    endfor;
                    $temporary_in->save();
                endif;
           
                if ($k->pola_nama == 'Full Day 2' && $k->durasi < 120):
                    $temporary_in = new Temporary;
                    $temporary_in->status = 'in-lembur-FD-2';
                    $temporary_in->tanggal = $k->tanggal;
                    $temporary_in->pegawai_id = $p->id;
                    for($i=1; $i <= 2; $i++ ):
                        $temporary_in->nominal +=  $lembur[0]->nominal;
                    endfor;
                    $temporary_in->save();
                endif;
          
                if ($k->pola_nama == 'Full Day 3' && $k->durasi < 120):
                    $temporary_in = new Temporary;
                    $temporary_in->status = 'in-lembur-FD-3';
                    $temporary_in->tanggal = $k->tanggal;
                    $temporary_in->pegawai_id = $p->id;
                    for($i=1; $i <= 2; $i++ ):
                        $temporary_in->nominal +=  $lembur[0]->nominal;
                    endfor;
                    $temporary_in->save();
                endif;



            endif;

        endforeach;
    endforeach;
           


            // if ($temp->isEmpty()):
            //     if ($status == 'out-telat-harian' && $durasi >  $lembur[1]->durasi && $pengecualian->isEmpty()):
            //         $temporary_out = new Temporary;
            //         $temporary_out->status = 'out-telat-harian';
            //         $temporary_out->tanggal = $tanggal;
            //         $temporary_out->pegawai_id = $pegawai_id;
            //         for($i=1; $i <= intval($durasi/$lembur[1]->durasi); $i++ ):
            //             $temporary_out->nominal +=  $lembur[1]->nominal;
            //         endfor;
            //         $temporary_out->save();
            //     endif;
            //     if ($status == 'out-istirahat' && $durasi >  $lembur[1]->durasi && $pengecualian->isEmpty()):
            //         $temporary_out = new Temporary;
            //         $temporary_out->status = 'out-istirahat';
            //         $temporary_out->tanggal = $tanggal;
            //         $temporary_out->pegawai_id = $pegawai_id;
            //         for($i=1; $i <= intval($durasi/$lembur[1]->durasi); $i++ ):
            //             $temporary_out->nominal +=  $lembur[1]->nominal;
            //         endfor;
            //         $temporary_out->save();
            //     endif;
            //     if ($status == 'out-istirahat-masuk' && $durasi >  $lembur[1]->durasi && $pengecualian->isEmpty()):
            //         $temporary_out = new Temporary;
            //         $temporary_out->status = 'out-istirahat-masuk';
            //         $temporary_out->tanggal = $tanggal;
            //         $temporary_out->pegawai_id = $pegawai_id;
            //         for($i=1; $i <= intval($durasi/$lembur[1]->durasi); $i++ ):
            //             $temporary_out->nominal +=  $lembur[1]->nominal;
            //         endfor;
            //         $temporary_out->save();
            //     endif;
            //     if ($status == 'in-lembur-harian' && $durasi >  $lembur[0]->durasi):
            //             $temporary_in = new Temporary;
            //             $temporary_in->status = 'in-lembur-harian';
            //             $temporary_in->tanggal = $tanggal;
            //             $temporary_in->pegawai_id = $pegawai_id;
            //             for($i=1; $i <= intval($durasi/$lembur[0]->durasi); $i++ ):
            //                 $temporary_in->nominal +=  $lembur[0]->nominal;
            //             endfor;
            //             $temporary_in->save();

            //         endif;
            //     if ($status == 'in-lembur-harian-PS'):
            //             $temporary_in = new Temporary;
            //             $temporary_in->status = 'in-lembur-harian';
            //             $temporary_in->tanggal = $tanggal;
            //             $temporary_in->pegawai_id = $pegawai_id;
            //             for($i=1; $i <= intval($durasi/$lembur[0]->durasi); $i++ ):
            //                 $temporary_in->nominal +=  $lembur[0]->nominal;
            //             endfor;
            //             $temporary_in->save();

            //         endif;
            // endif;


        

        
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
    public function show(Kehadiran $kehadirans)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Kehadiran  $kehadirans
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $kehadirans = Kehadiran::findOrFail($request->get('id'));
        $kehadirans['jam_masuk'] = date('H:i', strtotime($kehadirans['jam_masuk']));
        $kehadirans['jam_istirahat'] = date('H:i', strtotime($kehadirans['jam_istirahat']));
        $kehadirans['jam_masuk_istirahat'] = date('H:i', strtotime($kehadirans['jam_masuk_istirahat']));
        $kehadirans['jam_pulang'] = date('H:i', strtotime($kehadirans['jam_pulang']));
        return response()->json($kehadirans);

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
            return redirect()->back()->with(['success' => 'Data Kehadiran'.$request->input('nama').'berhasil disimpan']);
        }else{
            return redirect()->back()->with(['danger' => 'Data Tidak Terekam!']);
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
        return redirect()->back()
                        ->with('success','Post deleted successfully');
    }

     public function ExportPDFKehadiraBulanan(Request $request)
    {
     set_time_limit(10000);
     $month = date('m', strtotime($request->tanggal)); 
    //  $pegawais_count = Pegawai::get()->count('id');
     // dd($pegawais_count);
     $pegawais = Pegawai::limit(5)
                ->get();
                $jadwals = Jadwal::all();
                // dd($pegawais);
        // $batas_tanggal = date('t');
        // $kehadiran_bulanan = Kehadiran::whereBetween('tanggal', [date('Y-m-d', strtotime('first day of this month')),date('Y-m-d', strtotime('last day of this month'))])
        // ->whereYear('tanggal', date('Y'))
        // ->whereMonth('tanggal', date('m')) 
        // ->orderBy('pegawai_id', 'asc')
        // ->orderBy('tanggal', 'asc')
        // ->get();
        $tanggal = date('Y') .'-' . date('m') .'-' . $request->tanggal;
        $kehadiran_data = Kehadiran::where('tanggal', $tanggal)
        ->where('pegawai_id', $request->pegawai_id)
        ->get();
        $bulan_jadwal = Kehadiran::orderBy('tanggal', 'desc')
        ->select('tanggal',DB::raw('YEAR(tanggal) year, MONTH(tanggal) month'))
        ->groupBy('year','month')
        ->whereRaw('MONTH(tanggal) = '. $month)->first()
        ->get();
        // dd($bulan_jadwal);
        // foreach ($pegawais as $p):
        //     for ($x=1; $x <= date('t'); $x++):
        //         $tanggal = date('Y') .'-' . date('m') .'-' . $x;
        //         $kehadiran_bulanan[$p->id][$x] = Kehadiran::where('tanggal', date('Y-m-d', strtotime($tanggal)))
        //         ->where('pegawai_id', $p->id)
        //         ->limit(5)
        //         ->get();
        //     endfor;
        // endforeach;
        // $tanggal_terakhir = Kehadiran::latest()->first();

        // $kehadirans = Kehadiran::where('tanggal', Carbon::now()->toDateString())
        // ->orderBy('tanggal', 'asc')
        // ->orderBy('pegawai_id', 'asc')
        // ->paginate(10);

        
        // $setting = Setting::all();
        // dd($kehadiran_bulanan);

        $pegawais = Pegawai::all();
        foreach ($pegawais as $p):
            for ($x=1; $x <= date('t', strtotime($month)); $x++):
                $tanggal = date('Y') .'-' . $month .'-' . $x;
                $kehadiran_bulanan[$p->id][$x] = Kehadiran::where('tanggal', date('Y-m-d', strtotime($tanggal)))
                ->where('pegawai_id', $p->id)
                ->get();
                $jadwal[$p->id][$x] = Jadwal::where('tanggal', date('Y-m-d', strtotime($tanggal)))
                ->where('pegawai_id', $p->id)
                ->first();
                if($jadwal[$p->id][$x] != null):
                    $polas[$p->id][$x] = Pola::where('id', $jadwal[$p->id][$x]->pola_id)->first();
                else:
                    $polas[$p->id][$x] = Pola::where('id', 1)->first();
                endif;
            endfor;
        endforeach;
      $pdf = SnappyPDF::loadView('gocay.cetak.kehadiran_bulanan', [
            'kehadiran_bulanan' => $kehadiran_bulanan,
            // 'kehadirans' => $kehadirans,
            'bulan_jadwal' => $bulan_jadwal,
            'jadwals' => $jadwals,
            'polas' => $polas,
            'bulan' => $request->tanggal,
            'pegawais' => $pegawais,
    ])->setPaper('a4','landscape')
    ->setOption('margin-top', 4)
    ->setOption('margin-bottom', 4)
    ->setOption('margin-left', 4)
    ->setOption('margin-right', 4);
      // download PDF file with download method
      return $pdf->stream('Kehadiran Bulanan Bulan '.'.pdf');
    }
}