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
        $kehadirans = Kehadiran::where('tanggal', Carbon::now()->toDateString())
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
        $pegawais = Pegawai::all();
        // $batas_tanggal = date('t');
        // $kehadiran_bulanan = Kehadiran::whereBetween('tanggal', [date('Y-m-d', strtotime('first day of this month')),date('Y-m-d', strtotime('last day of this month'))])
        // ->orderBy('pegawai_id', 'asc')
        // ->orderBy('tanggal', 'asc')->get();
        $tanggal = date('Y') .'-' . date('m') .'-' . $request->tanggal;
        $kehadiran_data = Kehadiran::where('tanggal', $tanggal)
        ->where('pegawai_id', $request->pegawai_id)
        ->get();
        foreach ($pegawais as $p):
            for ($x=1; $x <= date('t'); $x++):
                $tanggal = date('Y') .'-' . date('m') .'-' . $x;
                $kehadiran_bulanan[$p->id][$x] = Kehadiran::where('tanggal', date('Y-m-d', strtotime($tanggal)))
                ->where('pegawai_id', $p->id)
                ->get();
            endfor;
        endforeach;
        // $tanggal_terakhir = Kehadiran::latest()->first();

        // $kehadirans = Kehadiran::where('tanggal', Carbon::now()->toDateString())
        // ->orderBy('tanggal', 'asc')
        // ->orderBy('pegawai_id', 'asc')
        // ->paginate(10);

        $bulan=array("Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
        return view('gocay.kehadiran-bulanan', [
            'kehadiran_bulanan' => $kehadiran_bulanan,
            // 'kehadirans' => $kehadirans,
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
            $kehadirans = Kehadiran::where('tanggal', $tanggal)
                        ->orderBy('tanggal', 'desc')
                        ->orderBy('pegawai_id', 'asc')
                        ->paginate(10);
        elseif( !$pegawai_id->isEmpty()):
            $kehadirans = Kehadiran::where('tanggal', $tanggal)
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
        if ($jadwals):
            $polas = Pola::findOrFail($jadwals->pola_id);
            return response()->json($polas);
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

    public function telatlembur(Request $request)
    {
        $request->validate([
            'tanggal' => 'required',
            'durasi' => 'required',
            'status' => 'required',
            'pegawai_id' => 'required',
         
        ]);

        $temp = Temporary::where('tanggal', $request->tanggal)
        ->where('pegawai_id', $request->pegawai_id)
        ->where('status', $request->status)
        ->get();

        $lembur = Lembur::all();
        $pengecualian = Pengecualian::where('tanggal', date('Y-m-d', strtotime('-1 day', strtotime($request->tanggal))))
                        ->where('pegawai_id', $request->pegawai_id)
                        ->get();
       
        if ($temp->isEmpty()):
            if ($request->status == 'out-telat-harian' && $request->durasi >  $lembur[1]->durasi && $pengecualian->isEmpty()):
                $temporary_out = new Temporary;
                $temporary_out->status = 'out-telat-harian';
                $temporary_out->tanggal = $request->tanggal;
                $temporary_out->pegawai_id = $request->pegawai_id;
                for($i=1; $i <= intval($request->durasi/$lembur[1]->durasi); $i++ ):
                    $temporary_out->nominal +=  $lembur[1]->nominal;
                endfor;
                $temporary_out->save();
            endif;
            if ($request->status == 'out-istirahat' && $request->durasi >  $lembur[1]->durasi && $pengecualian->isEmpty()):
                $temporary_out = new Temporary;
                $temporary_out->status = 'out-istirahat';
                $temporary_out->tanggal = $request->tanggal;
                $temporary_out->pegawai_id = $request->pegawai_id;
                for($i=1; $i <= intval($request->durasi/$lembur[1]->durasi); $i++ ):
                    $temporary_out->nominal +=  $lembur[1]->nominal;
                endfor;
                $temporary_out->save();
            endif;
            if ($request->status == 'out-istirahat-masuk' && $request->durasi >  $lembur[1]->durasi && $pengecualian->isEmpty()):
                $temporary_out = new Temporary;
                $temporary_out->status = 'out-istirahat-masuk';
                $temporary_out->tanggal = $request->tanggal;
                $temporary_out->pegawai_id = $request->pegawai_id;
                for($i=1; $i <= intval($request->durasi/$lembur[1]->durasi); $i++ ):
                    $temporary_out->nominal +=  $lembur[1]->nominal;
                endfor;
                $temporary_out->save();
            endif;
            if ($request->status == 'in-lembur-harian' && $request->durasi >  $lembur[0]->durasi):
                    $temporary_in = new Temporary;
                    $temporary_in->status = 'in-lembur-harian';
                    $temporary_in->tanggal = $request->tanggal;
                    $temporary_in->pegawai_id = $request->pegawai_id;
                    for($i=1; $i <= intval($request->durasi/$lembur[0]->durasi); $i++ ):
                        $temporary_in->nominal +=  $lembur[0]->nominal;
                    endfor;
                    $temporary_in->save();

                endif;
        endif;
        

        
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
}
