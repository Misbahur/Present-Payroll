<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Rats\Zkteco\Lib\ZKTeco;
use App\Models\Fingerprint;
use App\Models\Kehadiran;
use Illuminate\Http\Request;
use App\Models\Kehadiran;
use App\Models\Pegawai;
use App\Models\Jabatan;
use App\Models\Jadwal;
use App\Models\Pola;


class FingerprintController extends Controller
{
    public function index()
    {
        // $this->getDataFingerprint();
        $datafingers = Fingerprint::where('tanggal', date('Y-m-d'))->get(); 
        $jabatans = Jabatan::all(); 


        return view('gocay.fingerprint', [
            'datafingers' => $datafingers,
            'jabatans' => $jabatans,
        ]);
    }
    public function getDataFingerprint()
    {
        $zk = new ZKTeco('192.168.22.71', 4370);
        $zk->connect();
        $zk->disableDevice();
        $users = $zk->getUser();
        $att = $zk->getAttendance();
        $hariini = date('Y-m-d');

        // dd($att);

        foreach ($users as $u):
            $data = Kehadiran::where('tanggal', $hariini)
            ->where('pegawai_id', 1)
            ->first();

            if ($data == null):
                continue;
            else:
                $jadwals = Jadwal::where('tanggal', $hariini)
                ->where('pegawai_id', $u['userid'])
                ->first();
                if ($jadwals != null):
                    $polas = Pola::findOrFail($jadwals->pola_id);
                else:
                    continue;
                endif;
                foreach ($att as $a):
                    
                    if(date('Y-m-d', strtotime($a['timestamp'])) == $hariini):
                        if($a['id'] != $u['userid']):
                            continue;
                        else:
                            $time = date('H:i:s', strtotime($a['timestamp']));
                            $data->tanggal = date('Y-m-d', strtotime($a['timestamp']));
                            $data->pegawai_id = $u['userid'];

                            if ($data->jam_masuk == null  && $time <= $polas->jam_masuk):
                                $data->jam_masuk = $time;
                            elseif ($data->jam_istirahat == null  && $time >= $polas->jam_istirahat && $time <= $polas->jam_masuk_istirahat):
                                $data->jam_istirahat = $time;
                            elseif ($data->jam_masuk_istirahat == null && $time >= $polas->jam_istirahat && $time <= $polas->jam_masuk_istirahat):
                                $data->jam_masuk_istirahat = $time;
                            elseif ($data->jam_pulang == null  && $time >= $polas->jam_pulang ):
                                $data->jam_pulang = $time;
                            endif;

                        endif;

                        $data->update();
                        if ($data->update()):
                            echo 'berhasil';
                        endif;

                    endif;
                endforeach;
            endif;
        endforeach;
                
        // $datafingers = Keha::all(); 
        // $jabatans = Jabatan::all(); 



        // return view('gocay.fingerprint', [
        //     'datafingers' => $datafingers,
        //     'jabatans' => $jabatans,
        // ]);
                   
    }

    public function updateFingerData(Request $request)
    {
        // $time = date('H:i:s', strtotime($a['timestamp']));
        // $time = date('H:i:s', strtotime($request->time);
        // $data->tanggal = date('Y-m-d', strtotime($a['timestamp']));
        $hariini = date('Y-m-d');
        // $data->pegawai_id = $u['userid'];

            $data = Kehadiran::where('tanggal', $hariini)
            ->where('pegawai_id', $request->pegawai_id)
            ->first();
            if ($data == null):
                
            else:
                $jadwals = Jadwal::where('tanggal', $hariini)
                ->where('pegawai_id', $request->pegawai_id)
                ->first();
                if ($jadwals != null):
                    $polas = Pola::findOrFail($jadwals->pola_id);
                else:
                    
                endif;

                if ($data->jam_masuk == null && $request->time <= date('H:i', strtotime($polas->jam_masuk.'+60 minute'))):
                    $data->jam_masuk = $request->time;
                elseif ($data->jam_istirahat == null  && $request->time >= date('H:i', strtotime($polas->jam_istirahat.'-30 minute')) && $request->time < date('H:i', strtotime($polas->jam_istirahat.'+30 minute')) ):
                    $data->jam_istirahat = $request->time;
                elseif ($data->jam_masuk_istirahat == null && $request->time >= date('H:i', strtotime($polas->jam_istirahat_masuk.'-30 minute')) && $request->time <= date('H:i', strtotime($polas->jam_istirahat_masuk.'+30 minute')) ):
                    $data->jam_masuk_istirahat = $request->time;
                elseif ($data->jam_pulang == null  && $request->time >= date('H:i', strtotime($polas->jam_pulang.'-30 minute')) && $request->time <= date('H:i', strtotime($polas->jam_pulang.'+60 minute')) ):
                    $data->jam_pulang = $request->time;
                endif;
                $data->update();
            endif;

            return redirect()->route('kehadiran');
    }

    // public function updateFingerData()
    // {
    //     $pegawais = Pegawai::all();
    //     $batas_tanggal = date('t');
    //     // $batas_tanggal = 3;
    //     for ($i = 0; $i < $batas_tanggal; $i++):
    //         foreach ($pegawais as $item):
    //             $data = new Fingerprint;
    //             $data->tanggal = date('Y-m-d', strtotime('+'.$i.' day', strtotime('first day of this month')));
    //             $data->pegawai_id = $item->id;
    //             $data->jam_masuk = null;
    //             $data->jam_istirahat = null;
    //             $data->jam_masuk_istirahat = null;
    //             $data->jam_pulang = null;
    //             $data->save();
    //         endforeach;
    //     endfor;
        
    // }

    // public function updateFingerData()
    // {
    //     $zk = new ZKTeco('192.168.22.71', 4370);
    //     $zk->connect();
    //     $zk->disableDevice();
        

    //     $pegawais = Pegawai::all();
    //     foreach ($pegawais as $item):
    //         $data = $zk->getFingerprint(1);
    //         if ($data):
    //             $pegawais_update = Pegawai::find($item->id);
    //             $pegawais_update->fingerprint = $data;
    //             $pegawais_update->update();
    //         else:
    //             continue;
    //         endif;
    //     endforeach;

    //     // dd($data);

    // }

    public function cekDataFingerprint()
    {
        $zk = new ZKTeco('192.168.22.71', 4370);
        $zk->connect();
        $zk->disableDevice();
        $att = $zk->getAttendance();

        dd($att);

    }

    public function cekUserFingerprint()
    {
        $zk = new ZKTeco('192.168.22.71', 4370);
        $zk->connect();
        $zk->disableDevice();
        $users = $zk->getUser();

        dd($users);

    }

    public function addPegawaiToFingerprint()
    {
        $zk = new ZKTeco('192.168.22.71', 4370);
        $zk->connect();
        $zk->disableDevice();

        $pegawais = Pegawai::all();
        foreach ($pegawais as $item):
            $zk->setUser($item->id, $item->id, $item->nama, strtolower($item->nama));
        endforeach;
        
        // return view('gocay.fingerprint', [
        //     'datafingers' => $datafingers,
        //     'jabatans' => $jabatans,
        // ]);
    }

    public function setUserFingerprint(Request $request)
    {
        $zk = new ZKTeco('192.168.22.71', 4370);
        $zk->connect();
        $zk->disableDevice();
        $users = $zk->getUser();

        $u = end($users); 
        $pegawais = $u['uid'] + 1;
        
        $zk->setUser($pegawais, $pegawais, $request->nama, strtolower($request->nama));
        // dd($pegawais);
        return view('gocay.fingerprint', [
            'datafingers' => $datafingers,
            'jabatans' => $jabatans,
        ]);
    }
    

    public function deleteAllUserFingerptint()
    {
        $zk = new ZKTeco('192.168.22.71', 4370);
        $zk->connect();
        $zk->disableDevice();
        $zk->clearUsers();

        // return view('gocay.fingerprint', [
        //     'datafingers' => $datafingers,
        //     'jabatans' => $jabatans,
        // ]);
    }

    public function deleteAllLogFingerptint()
    {
        $zk = new ZKTeco('192.168.22.71', 4370);
        $zk->connect();
        $zk->disableDevice();
        $zk->clearAttendance();

        // return view('gocay.fingerprint', [
        //     'datafingers' => $datafingers,
        //     'jabatans' => $jabatans,
        // ]);
    }
}
