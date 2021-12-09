<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Rats\Zkteco\Lib\ZKTeco;
use App\Models\Fingerprint;
use Illuminate\Http\Request;
use App\Models\Pegawai;


class FingerprintController extends Controller
{
    // public function __construct($ip, $port = 4370)
    // {
    //     $zk = new ZKTeco('192.168.1.201', 4370);
    //     $zk->connect();
    //     $zk->disableDevice();

    // }
    public function getData()
    {
        $zk = new ZKTeco('192.168.1.201', 4370);
        $zk->connect();
        $zk->disableDevice();
        $users = $zk->getUser();
        $att = $zk->getAttendance();
        // $fp = $zk->getFingerprint(4);
        // $dn = $zk->deviceName();
        $hariini = date('Y-m-d', strtotime('2021-11-10'));
        // $hariini = date('Y-m-d');

            // dd($users);
            // dd($att);
            // dd($att);
            // dd($dn);
            // echo 'tes commit';

            // foreach ($users as $x) {
            //     $uid = $x['userid'];
            //     $uname = $x['name'];
            // }

            
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
            return view('gocay.fingerprint', ['datafingers' => $datafingers]);     
                   
    }

    public function cekUserFingerprint()
    {
        $zk = new ZKTeco('192.168.1.201', 4370);
        $zk->connect();
        $zk->disableDevice();
        $users = $zk->getUser();

        dd($users);
    }

    public function setUserFingerprint(Request $request)
    {
        $zk = new ZKTeco('192.168.1.201', 4370);
        $zk->connect();
        $zk->disableDevice();
        $users = $zk->getUser();
        

        dd($users);
    }
}
