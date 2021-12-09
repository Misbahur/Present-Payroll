<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Rats\Zkteco\Lib\ZKTeco;
use App\Models\Fingerprint;
use Illuminate\Http\Request;
use App\Models\Pegawai;
use App\Models\Jabatan;


class FingerprintController extends Controller
{
    public function index()
    {
        // $this->getDataFingerprint();
        $datafingers = Fingerprint::all(); 
        $jabatans = Jabatan::all(); 


        return view('gocay.fingerprint', [
            'datafingers' => $datafingers,
            'jabatans' => $jabatans,
        ]);
    }
    public function getDataFingerprint()
    {
        $zk = new ZKTeco('192.168.1.201', 4370);
        $zk->connect();
        $zk->disableDevice();
        $users = $zk->getUser();
        $att = $zk->getAttendance();
        $hariini = date('Y-m-d');
            
        foreach ($users as $u):
            $data = new Fingerprint;
            foreach ($att as $a):
                $cekDataExist = Fingerprint::where('pegawai_id', $u['userid'])
                ->where('tanggal', $hariini)
                ->whereNotNull('jam_masuk')
                ->whereNotNull('jam_istirahat')
                ->whereNotNull('jam_masuk_istirahat')
                ->whereNotNull('jam_pulang')
                ->get();
                if ($cekDataExist->isEmpty()):
                    if(date('Y-m-d', strtotime($a['timestamp'])) == $hariini):
                        if($a['id'] != $u['userid']):
                            continue;
                        else:
                            $time = date('H:i:s', strtotime($a['timestamp']));
                            $data->tanggal = date('Y-m-d', strtotime($a['timestamp']));
                            $data->pegawai_id = $u['userid'];

                            $pegawai = Pegawai::where('id', $u['userid'])->pluck('jabatan_id');
                            if ($pegawai):
                                $data->jabatan_id = $pegawai[0];
                            else:
                                continue;
                            endif;
                            
                            if ($data->jam_masuk == null):
                                $data->jam_masuk = $time;
                            elseif ($data->jam_istirahat == null):
                                $data->jam_istirahat = $time;
                            elseif ($data->jam_masuk_istirahat == null ):
                                $data->jam_masuk_istirahat = $time;
                            else:
                                $data->jam_pulang = $time;
                            endif;
                        endif;
                    else:
                        continue;
                    endif;
                    $data->save();
                endif;
            endforeach;
        endforeach;
                
        $datafingers = Fingerprint::all(); 
        $jabatans = Jabatan::all(); 


        return view('gocay.fingerprint', [
            'datafingers' => $datafingers,
            'jabatans' => $jabatans,
        ]);
                   
    }

    public function updateFingerData()
    {
        $zk = new ZKTeco('192.168.1.201', 4370);
        $zk->connect();
        $zk->disableDevice();
        

        $pegawais = Pegawai::all();
        foreach ($pegawais as $item):
            $data = $zk->getFingerprint(4);
            if ($data):
                // $pegawais_update = Pegawai::find($item->id);
                // $pegawais_update->fingerprint = $data;
                // $pegawais_update->update();
            else:
                continue;
            endif;
        endforeach;

        dd($data);

    }

    public function cekDataFingerprint()
    {
        $zk = new ZKTeco('192.168.1.201', 4370);
        $zk->connect();
        $zk->disableDevice();
        $att = $zk->getAttendance();

        dd($att);

    }

    public function cekUserFingerprint()
    {
        $zk = new ZKTeco('192.168.1.201', 4370);
        $zk->connect();
        $zk->disableDevice();
        $users = $zk->getUser();

        dd($users);

    }

    public function addPegawaiToFingerprint()
    {
        $zk = new ZKTeco('192.168.1.201', 4370);
        $zk->connect();
        $zk->disableDevice();

        $pegawais = Pegawai::all();
        foreach ($pegawais as $item):
            $zk->setUser($item->id, $item->id, $item->nama, strtolower($item->nama));
        endforeach;
        
        return view('gocay.fingerprint', [
            'datafingers' => $datafingers,
            'jabatans' => $jabatans,
        ]);
    }

    public function setUserFingerprint(Request $request)
    {
        $zk = new ZKTeco('192.168.1.201', 4370);
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
        $zk = new ZKTeco('192.168.1.201', 4370);
        $zk->connect();
        $zk->disableDevice();
        $zk->clearUsers();

        return view('gocay.fingerprint', [
            'datafingers' => $datafingers,
            'jabatans' => $jabatans,
        ]);
    }

    public function deleteAllLogFingerptint()
    {
        $zk = new ZKTeco('192.168.1.201', 4370);
        $zk->connect();
        $zk->disableDevice();
        $zk->clearAttendance();

        return view('gocay.fingerprint', [
            'datafingers' => $datafingers,
            'jabatans' => $jabatans,
        ]);
    }
}
