<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Rats\Zkteco\Lib\ZKTeco;
use App\Models\Fingerprint;
use Illuminate\Http\Request;

class FingerprintController extends Controller
{
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
                    // if(date('Y-m-d', strtotime($a['timestamp'])) == $hariini):
                        if($a['id'] != $u['userid']):
                            continue;
                        else:
                            $time = date('H:i:s', strtotime($a['timestamp']));
                            $data->tanggal = date('Y-m-d', strtotime($a['timestamp']));
                            $data->pegawai_id = $u['userid'];
    
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
                    // endif;
                    $data->save();
                endforeach;
            endforeach;


            // dd($datafingers);
            // foreach ($att as $a):
            //     if( $temp_id != $a['id']):
            //         foreach ($users as $u):
            //             if($u['userid'] == $a['id']):
            //                 // $data = array(
            //                 //     'pegawai_id'     => $u['userid'],
            //                 //     'tanggal'     => date('Y-m-d', strtotime($a['timestamp'])),
            //                 //     'jam_masuk' => '',
            //                 //     'jam_istirahat' => '',
            //                 //     'jam_masuk_istirahat' => '',
            //                 //     'jam_pulang' => '',
            //                 // );

            //                 $data = new Fingerprint;
            //                 $data->tanggal = date('Y-m-d', strtotime($a['timestamp']));
            //                 $data->pegawai_id = $u['userid'];
            //                 $data->jam_masuk = null;
            //                 $data->jam_istirahat = null;
            //                 $data->jam_masuk_istirahat = null;
            //                 $data->jam_pulang = null;
    
            //                 $time = date('h:i:s', strtotime($a['timestamp']));
    
            //                 if ($data->jam_masuk == null):
            //                     $data->jam_masuk = $time;
            //                 elseif ($data->jam_istirahat == null ):
            //                     $data->jam_istirahat = $time;
            //                 elseif ($data->jam_masuk_istirahat == null):
            //                     $data->jam_masuk_istirahat = $time;
            //                 else:
            //                     $data->jam_pulang = $time;
            //                 endif;

            //                 $data->save();

            //             endif;
            //         endforeach;
            //     endif;
            //     $temp_id = $a['id'];
            // endforeach;
                
            $datafingers = Fingerprint::all();
            
            
            return view('gocay.fingerprint', ['datafingers' => $datafingers]);
            
                   
    }
}
