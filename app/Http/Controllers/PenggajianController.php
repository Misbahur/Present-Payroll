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
// titip
use App\Models\Lembur;
use App\Models\Kehadiran;
use App\Models\Jadwal;
use App\Models\Pengecualian;
use App\Models\Temporary;
use App\Models\Pola;
use App\Models\Libur;
use Carbon\Carbon;
use App\Models\Komponen_gaji;
//endtitip
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
        ini_set('max_execution_time', 600);
        
        $tanggal_awal = date("Y-m-d",strtotime($request->input('tanggal_awal')));
        $tanggal_akhir = date("Y-m-d",strtotime($request->input('tanggal_akhir')));
        // dd($tanggal_awal);
        // dd($tanggal_akhir);

        $komponen = Komponen_gaji::all();

        $pegawai = Pegawai::all();
        $lembur = Lembur::all();

        foreach ($pegawai as $p):
            $kehadiran = Kehadiran::whereBetween('tanggal', [$tanggal_awal, $tanggal_akhir])->where('pegawai_id', $p->id)->get();

            // dd($kehadiran);
            
            foreach ($kehadiran as $k):
                
            
            $jadwals = Jadwal::where('tanggal', $k->tanggal)
            ->where('pegawai_id', $p->id)
            ->first();

            $pengecualian = Pengecualian::where('tanggal', date('Y-m-d', strtotime('-1 day', strtotime($k->tanggal))))
            ->where('pegawai_id', $p->id)
            ->get();

            

           

            if ($jadwals != null):
                $polas = Pola::findOrFail($jadwals->pola_id);

                if ($polas):
                //cek Absen Pegawai

                $cekKehadiran = Kehadiran::where('tanggal', $k->tanggal)
                    ->where('jam_masuk', null)
                        ->where('jam_istirahat', null)
                        ->where('jam_masuk_istirahat', null)
                        ->where('jam_pulang', null)
                        ->where('pegawai_id', $p->id)
                        ->get();
                   
                    $cekLibur = Libur::where('tanggal', $k->tanggal)
                        ->where('pegawai_id', $p->id)
                        ->first();

                    $cekPengecualian = Pengecualian::where('tanggal', date('Y-m-d', strtotime('-1 day', strtotime($k->tanggal))))
                    ->where('pegawai_id', $p->id)
                    ->first();

                    $tempAbsen = Temporary::where('tanggal', $k->tanggal)
                    ->where('pegawai_id', $p->id)
                    ->where('status', 'out-absen-harian')
                    ->first();

                    $komponen_gaji = Komponen_gaji::where('jabatan_id', $p->jabatan_id)->first();

                    if ($cekKehadiran->isNotEmpty()):
                        if($cekLibur == null):
                            if($cekPengecualian == null):
                                if ($tempAbsen == null):
                                    $temporary_out = new Temporary;
                                    $temporary_out->tanggal = date('Y-m-d', strtotime( $k->tanggal));
                                    $temporary_out->status = 'out-absen-harian';
                                    $temporary_out->created_at = date('Y-m-d h:i:s', strtotime( $k->tanggal));
                                    $temporary_out->updated_at = date('Y-m-d h:i:s', strtotime( $k->tanggal));
                                    $temporary_out->pegawai_id = $p->id;
                                    $temporary_out->nominal = $komponen_gaji->tidakmasuk;
                                    $temporary_out->save();

                                endif;
                            endif;
                        endif;
                    endif;
                    
                endif;

                if($polas != null && $k->jam_masuk != null):
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

                    
                    if($k->jam_masuk > $k->pola_masuk && $k->durasi_masuk >=  $lembur[1]->durasi && $pengecualian->isEmpty() ):
                        $temporary_out = new Temporary;
                        $temporary_out->status = 'out-telat-harian';
                        $temporary_out->tanggal = $k->tanggal;
                        $temporary_out->pegawai_id = $p->id;
                        for($i=1; $i <= intval($k->durasi_masuk/$lembur[1]->durasi); $i++ ):
                            $temporary_out->nominal +=  $lembur[1]->nominal;
                        endfor;
                        $temporary_out->save();
                    endif;
                    
                    if($jam_masuk_istirahat > $pola_istirahat_masuk && $k->durasi_masuk_istirahat >=  $lembur[1]->durasi && $pengecualian->isEmpty()):
                        $temporary_out_istirahat = new Temporary;
                        $temporary_out_istirahat->status = 'out-istirahat-masuk';
                        $temporary_out_istirahat->tanggal = $k->tanggal;
                        $temporary_out_istirahat->pegawai_id = $p->id;
                        for($i=1; $i <= intval($k->durasi_masuk_istirahat/$lembur[1]->durasi); $i++ ):
                            $temporary_out_istirahat->nominal +=  $lembur[1]->nominal;
                        endfor;
                        $temporary_out_istirahat->save();
                    endif;
                    

                    if($k->pola_nama == 'Pagi' && $k->jam_pulang > $k->pola_pulang):
                        $k->status = 'in-lembur-harian';
                        $jam_pulang = strtotime($k->jam_pulang);
                        $pola_pulang = strtotime($k->pola_pulang);
                        $k->durasi_lembur = abs($jam_pulang - $pola_pulang)/60;
                    endif;
                    // if($k->pola_nama == 'Full Day 1' ):
                    //     $k->status = 'in-lembur-FD-1';
                    //     $jam_masuk_istirahat = strtotime($k->jam_masuk_istirahat);
                    //     $jam_istirahat = strtotime($k->jam_istirahat);
                    //     $k->durasi = abs($jam_masuk_istirahat - $jam_istirahat)/60;
                    // endif;
                    // if($k->pola_nama == 'Full Day 2' ):
                    //     $k->status = 'in-lembur-FD-2';
                    //     $jam_masuk_istirahat = strtotime($k->jam_masuk_istirahat);
                    //     $jam_istirahat = strtotime($k->jam_istirahat);
                    //     $k->durasi = abs($jam_masuk_istirahat - $jam_istirahat)/60;
                    // endif;
                    // if($k->pola_nama == 'Full Day 3' ):
                    //     $k->status = 'in-lembur-FD-3';
                    //     $jam_masuk_istirahat = strtotime($k->jam_masuk_istirahat);
                    //     $jam_istirahat = strtotime($k->jam_istirahat);
                    //     $k->durasi = abs($jam_masuk_istirahat - $jam_istirahat)/60;
                    // endif;
            

                    $FD = Temporary::where('tanggal', $k->tanggal)
                    ->where('pegawai_id', $p->id)
                    ->first();

                    $harian = Temporary::where('tanggal', $k->tanggal)
                    ->where('pegawai_id', $p->id)
                    ->where('status', 'in-lembur-harian')
                    ->first();

                    if ( $k->pola_nama == 'Pagi' && $k->durasi_lembur >  $lembur[0]->durasi && $harian == null ):
                        $temporary_in = new Temporary;
                        $temporary_in->status = 'in-lembur-harian';
                        $temporary_in->tanggal = $k->tanggal;
                        $temporary_in->pegawai_id = $p->id;
                        $temporary_in->nominal = intval($k->durasi_lembur/$lembur[0]->durasi) * $lembur[0]->nominal;
                        $temporary_in->save();
                    endif;

                    // if ($FD == null):
                
                        if ($k->pola_nama == 'Full Day 1'):
                            if ($k->jam_masuk != null || $k->jam_masuk_istirahat != null || $k->jam_istirahat != null || $k->jam_pulang != null ):
                                $temporary_in = new Temporary;
                                $temporary_in->status = 'in-lembur-FD-1';
                                $temporary_in->tanggal = $k->tanggal;
                                $temporary_in->pegawai_id = $p->id;
                                $temporary_in->nominal = $lembur[0]->nominal + $lembur[0]->nominal;
                                $temporary_in->save();
                            endif;
                        endif;
                
                        if ($k->pola_nama == 'Full Day 2'):
                            if ($k->jam_masuk != null || $k->jam_masuk_istirahat != null || $k->jam_istirahat != null || $k->jam_pulang != null ):
                                $temporary_in = new Temporary;
                                $temporary_in->status = 'in-lembur-FD-2';
                                $temporary_in->tanggal = $k->tanggal;
                                $temporary_in->pegawai_id = $p->id;
                                $temporary_in->nominal = $lembur[0]->nominal + $lembur[0]->nominal;
                                $temporary_in->save();
                            endif;
                        endif;
                
                        if ($k->pola_nama == 'Full Day 3'):
                            if ($k->jam_masuk != null || $k->jam_masuk_istirahat != null || $k->jam_istirahat != null || $k->jam_pulang != null ):
                                $temporary_in = new Temporary;
                                $temporary_in->status = 'in-lembur-FD-3';
                                $temporary_in->tanggal = $k->tanggal;
                                $temporary_in->pegawai_id = $p->id;
                                $temporary_in->nominal = $lembur[0]->nominal + $lembur[0]->nominal;
                                $temporary_in->save();
                            endif;
                        endif;



                    // endif;

                    //Absen Kehadiran

                    // $cekKehadiran = Kehadiran::where('tanggal', $k->tanggal)
                    // ->where('jam_masuk', null)
                    //     ->where('jam_istirahat', null)
                    //     ->where('jam_masuk_istirahat', null)
                    //     ->where('jam_pulang', null)
                    //     ->where('pegawai_id', $p->id)
                    //     ->get();
                   
                    // $cekLibur = Libur::where('tanggal', $k->tanggal)
                    //     ->where('pegawai_id', $p->id)
                    //     ->first();

                    // $cekPengecualian = Pengecualian::where('tanggal', date('Y-m-d', strtotime('-1 day', strtotime($k->tanggal))))
                    // ->where('pegawai_id', $p->id)
                    // ->first();

                    // $tempAbsen = Temporary::where('tanggal', $k->tanggal)
                    // ->where('pegawai_id', $p->id)
                    // ->where('status', 'out-absen-harian')
                    // ->first();

                    // $komponen_gaji = Komponen_gaji::where('jabatan_id', $p->jabatan_id)->first();

                    // if ($cekKehadiran->isNotEmpty()):
                    //     if($cekLibur == null):
                    //         if($cekPengecualian == null):
                    //             if ($tempAbsen == null):
                    //                 $temporary_out = new Temporary;
                    //                 $temporary_out->tanggal = date('Y-m-d', strtotime( $k->tanggal));
                    //                 $temporary_out->status = 'out-absen-harian';
                    //                 $temporary_out->created_at = date('Y-m-d h:i:s', strtotime( $k->tanggal));
                    //                 $temporary_out->updated_at = date('Y-m-d h:i:s', strtotime( $k->tanggal));
                    //                 $temporary_out->pegawai_id = $p->id;
                    //                 $temporary_out->nominal = $komponen_gaji->tidakmasuk;
                    //                 $temporary_out->save();

                    //             endif;
                    //         endif;
                    //     endif;
                    // endif;


                    if (date('d', strtotime($k->tanggal)) <= 7):
                        $awal = date('Y-m-01', strtotime($k->tanggal));
                        $akhir = date('Y-m-d', strtotime('+6 day', strtotime($awal)));
                    endif;
                    if (date('d', strtotime($k->tanggal)) > 7 && date('d', strtotime($k->tanggal)) <= 14):
                        $awal = date('Y-m-08', strtotime($k->tanggal));
                        $akhir = date('Y-m-d', strtotime('+6 day', strtotime($awal)));
                    endif;
                    if (date('d', strtotime($k->tanggal)) > 14 && date('d', strtotime($k->tanggal)) <= 21):
                        $awal = date('Y-m-15', strtotime($k->tanggal));
                        $akhir = date('Y-m-d', strtotime('+6 day', strtotime($awal)));
                    endif;
                    if (date('d', strtotime($k->tanggal)) > 21 && date('d', strtotime($k->tanggal)) <= date('t', strtotime($k->tanggal))):
                        $awal = date('Y-m-22', strtotime($k->tanggal));
                        $akhir = date('Y-m-d', strtotime('+6 day', strtotime($awal)));
                    endif;
        
        
        
                    $tempMingguan = Temporary::where('tanggal', $awal)
                        ->where('pegawai_id', $p->id)
                        ->where('status', 'in-bonus-mingguan')
                        ->first();
        
        
                    $countDate = Kehadiran::whereBetween('tanggal', [$awal ,$akhir])
                            ->where('jam_masuk', '!=', null)
                            ->where('pegawai_id', $p->id)
                            ->get()->count('pegawai_id');

                    if ($countDate >= 6 && $tempMingguan == null):
                        $temporary_in = new Temporary;
                        $temporary_in->tanggal = $awal;
                        $temporary_in->created_at = date('Y-m-d h:i:s', strtotime($awal));
                        $temporary_in->updated_at = date('Y-m-d h:i:s', strtotime($akhir));
                        $temporary_in->status = 'in-bonus-mingguan';
                        $temporary_in->pegawai_id = $p->id;
                        $temporary_in->nominal = $komponen[0]->nominal;
                        $temporary_in->save();
                    endif;

                    $cekLibur = Libur::where('tanggal', $k->tanggal)
                                ->where('pegawai_id', $p->id)
                                ->first();
        
                    if ($cekLibur != null):
                        if($jam_masuk != null):
                            $temporary_in = new Temporary;
                            $temporary_in->tanggal = $awal;
                            $temporary_in->created_at = date('Y-m-d h:i:s', strtotime($awal));
                            $temporary_in->updated_at = date('Y-m-d h:i:s', strtotime($akhir));
                            $temporary_in->status = 'in-bonus-libur-masuk';
                            $temporary_in->pegawai_id = $p->id;
                            $temporary_in->nominal = $komponen_gaji->masuklibur;
                            $temporary_in->save();
                        endif;
                    endif;

                else:
                    continue;
                endif;
            else:
                continue;
            endif;
            

        endforeach;
    endforeach;


        // $pegawai = Pegawai::all();
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

            $FD1 = DB::table('temporaries')->where('status', 'in-lembur-FD-1')->where('pegawai_id', $pegawai[$i]->id)->get()->sum('nominal');
            if ($FD1):
                $meta_in_insert = ([
                    'nominal' => $FD1,
                    'status' => 'in',
                    'keterangan' => 'Bonus FullDay 1',
                    'penggajian_id' => $last_penggajian_id,
                ]);
                Metapenggajian::create($meta_in_insert);
            endif;

            $FD2 = DB::table('temporaries')->where('status', 'in-lembur-FD-2')->where('pegawai_id', $pegawai[$i]->id)->get()->sum('nominal');
            if ($FD2):
                $meta_in_insert = ([
                    'nominal' => $FD2,
                    'status' => 'in',
                    'keterangan' => 'Bonus FullDay 2',
                    'penggajian_id' => $last_penggajian_id,
                ]);
                Metapenggajian::create($meta_in_insert);
            endif;

            $FD3 = DB::table('temporaries')->where('status', 'in-lembur-FD-3')->where('pegawai_id', $pegawai[$i]->id)->get()->sum('nominal');
            if ($FD3):
                $meta_in_insert = ([
                    'nominal' => $FD3,
                    'status' => 'in',
                    'keterangan' => 'Bonus FullDay 3',
                    'penggajian_id' => $last_penggajian_id,
                ]);
                Metapenggajian::create($meta_in_insert);
            endif;

            // istirahate lebih karepe dewe pegawai e
            $potonganistirahat = DB::table('temporaries')->where('status', 'out-istirahat-masuk')->where('pegawai_id', $pegawai[$i]->id)->get()->sum('nominal');
            if ($potonganistirahat):
                $meta_in_insert = ([
                    'nominal' => $potonganistirahat,
                    'status' => 'out',
                    'keterangan' => 'Potongan Istirahat',
                    'penggajian_id' => $last_penggajian_id,
                ]);
                Metapenggajian::create($meta_in_insert);
            endif;
            
            
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
        
        $deletetemporary = Temporary::whereBetween('tanggal', [$tanggal_awal, $tanggal_akhir])->delete();

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

     


        $data_id = $request->penggajian_id;
        // dd($data_id);

        // $updateprint = Penggajian::find($id);
        // $updateprint->status_print = 'Sudah Print';
        // $updateprint->update();
        
        $periodes = Periode::orderBy('created_at', 'DESC')->get();



        $gaji =  Metapenggajian::whereIn('penggajian_id', $data_id)->where('status', 'in')->get();
        $potongan =  Metapenggajian::whereIn('penggajian_id', $data_id)->where('status', 'out')->get();


        $in = array();
        $out = array();

        for ($i=0; $i < count($data_id); $i++) { 


        $in[$i] = Metapenggajian::where('penggajian_id', array($data_id[$i]))->where('status', 'in')->get()->sum('nominal');
        $out[$i] = Metapenggajian::where('penggajian_id', array($data_id[$i]))->where('status', 'out')->get()->sum('nominal');
        $pegawai[$i] = Penggajian::whereIn('id',array($data_id[$i]))->first();

        }
        // dd($pegawai);
     
       // dd($gaji);
// dd($pegawai->periode->tanggal_awal);
        $setting = Setting::all();

      $pdf = DomPDF::loadView('gocay.cetak.slipgaji', [
            'data_id' => $data_id,
            'setting' => $setting,
            'pegawai' => $pegawai,
            'gaji' => $gaji,
            'potongan' => $potongan,
            'periodes' => $periodes,
            'in' => $in,
            'out' => $out,
    ])->setPaper('a3');
      // download PDF file with download method
      return $pdf->stream('slipgaji '.$pegawai[0]->periode->tanggal_awal.' - '.$pegawai[0]->periode->tanggal_akhir.'.pdf');
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
