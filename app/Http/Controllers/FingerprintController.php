<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Rats\Zkteco\Lib\ZKTeco;
use App\Models\Fingerprint;
use App\Models\Kehadiran;
use Illuminate\Http\Request;
use App\Models\Pegawai;
use App\Models\Jabatan;
use App\Models\Jadwal;
use App\Models\Pola;


class FingerprintController extends Controller
{
    public function index()
    {
        // $this->getDataFingerprint();
        // $datafingers = Fingerprint::where('tanggal', date('Y-m-d'))->get(); 
        // $jabatans = Jabatan::all(); 
        


        return view('gocay.fingerprint', [
            // 'datafingers' => $datafingers,
            // 'jabatans' => $jabatans,
            // 'pegawais' => $pegawais,
        ]);
    }
    public function getDataFingerprint()
    {
        $zk = new ZKTeco('192.168.22.71', 4370);
        $zk->connect();
        $zk->disableDevice();
        $users = $zk->getUser();
        $att = $zk->getAttendance();
        $zk2 = new ZKTeco('192.168.22.73', 4370);
        $zk2->connect();
        $zk2->disableDevice();
        $att2 = $zk2->getAttendance();
        $hariini = date('Y-m-d');
            
        foreach ($users as $u):
            $data = Kehadiran::where('tanggal', $hariini)
            ->where('pegawai_id', $u['userid'])
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
                            $time = date('H:i', strtotime($a['timestamp']));
                            $data->tanggal = date('Y-m-d', strtotime($a['timestamp']));
                            $data->pegawai_id = $u['userid'];

                            if ($polas->nama == 'PS' || $polas->nama == 'ps'):
                                if ($data->jam_masuk == null && $time <= date('H:i', strtotime($polas->jam_masuk.'+60 minute'))):
                                    $data->jam_masuk = $time;
                                
                                elseif ($data->jam_istirahat == null  && $time >= date('H:i', strtotime($polas->jam_istirahat.'-30 minute')) && $time < date('H:i', strtotime('15:00')) ):
                                    $data->jam_istirahat = $time;
                                
                                elseif ($data->jam_masuk_istirahat == null && $time >= date('H:i', strtotime('15:00')) && $time <= date('H:i', strtotime($polas->jam_istirahat_masuk.'+30 minute')) ):
                                    $data->jam_masuk_istirahat = $time;
                                
                                elseif ($data->jam_pulang == null  && $time >= date('H:i', strtotime($polas->jam_pulang.'-30 minute')) && $time <= date('H:i', strtotime($polas->jam_pulang.'+60 minute')) ):
                                    $data->jam_pulang = $time;
                                endif;
                            else:
                                if ($data->jam_masuk == null && $time <= date('H:i', strtotime($polas->jam_masuk.'+60 minute'))):
                                    $data->jam_masuk = $time;
                                
                                elseif ($data->jam_istirahat == null  && $time >= date('H:i', strtotime($polas->jam_istirahat.'-30 minute')) && $time < date('H:i', strtotime($polas->jam_istirahat.'+30 minute')) ):
                                    $data->jam_istirahat = $time;
                                
                                elseif ($data->jam_masuk_istirahat == null && $time >= date('H:i', strtotime($polas->jam_istirahat_masuk.'-35 minute')) && $time <= date('H:i', strtotime($polas->jam_istirahat_masuk.'+30 minute')) ):
                                    $data->jam_masuk_istirahat = $time;
                                
                                elseif ($data->jam_pulang == null  && $time >= date('H:i', strtotime($polas->jam_pulang.'-30 minute')) && $time <= date('H:i', strtotime($polas->jam_pulang.'+60 minute')) ):
                                    $data->jam_pulang = $time;
                                endif;
                            endif;

                            // if ($data->jam_masuk == null && $time <= $polas->jam_masuk  && $time > date('H:i', strtotime($polas->jam_masuk.'+60 minute'))):
                            //     $data->jam_masuk = $time;
                            // elseif ($data->jam_istirahat == null  && $time <= date('H:i', strtotime($polas->jam_istirahat.'-30 minute')) && $time <= date('H:i', strtotime($polas->jam_istirahat.'+30 minute')) ):
                            //     $data->jam_istirahat = $time;
                            // elseif ($data->jam_masuk_istirahat == null && $time <= date('H:i', strtotime($polas->jam_masuk_istirahat.'-30 minute')) && $time >= date('H:i', strtotime($polas->jam_masuk_istirahat.'+30 minute'))):
                            //     $data->jam_masuk_istirahat = $time;
                            // elseif ($data->jam_pulang == null  && $time <= date('H:i', strtotime($polas->jam_pulang.'-30 minute')) && $time >= date('H:i', strtotime($polas->jam_pulang.'+60 minute')) ):
                            //     $data->jam_pulang = $time;
                            // endif;
                            // if ($data->jam_masuk == null && $time <= date('H:i', strtotime($polas->jam_masuk.'+60 minute'))):
                            //     $data->jam_masuk = $time;
                            // elseif ($data->jam_istirahat == null  && $time >= date('H:i', strtotime($polas->jam_istirahat.'-30 minute')) && $time < date('H:i', strtotime($polas->jam_istirahat.'+30 minute')) ):
                            //     $data->jam_istirahat = $time;
                            // elseif ($data->jam_masuk_istirahat == null && $time >= date('H:i', strtotime($polas->jam_istirahat_masuk.'-35 minute')) && $time <= date('H:i', strtotime($polas->jam_istirahat_masuk.'+30 minute')) ):
                            //     $data->jam_masuk_istirahat = $time;
                            // elseif ($data->jam_pulang == null  && $time >= date('H:i', strtotime($polas->jam_pulang.'-30 minute')) && $time <= date('H:i', strtotime($polas->jam_pulang.'+60 minute')) ):
                            //     $data->jam_pulang = $time;
                            // endif;
                            
                        endif;
                        $data->update();
                    endif;
                endforeach; //attedance 1
                foreach ($att2 as $a2):
                  
                    if(date('Y-m-d', strtotime($a2['timestamp'])) == $hariini):
                        if($a2['id'] != $u['userid']):
                            continue;
                        else:
                            $time = date('H:i', strtotime($a2['timestamp']));
                            $data->tanggal = date('Y-m-d', strtotime($a2['timestamp']));
                            $data->pegawai_id = $u['userid'];
  
                            // if ($polas->nama == 'PS' || $polas->nama == 'ps'):
                            //     if ($data->jam_masuk == null && $time <= date('H:i', strtotime($polas->jam_masuk.'+60 minute'))):
                            //         $data->jam_masuk = $time;
                                
                            //     elseif ($data->jam_istirahat == null  && $time >= date('H:i', strtotime($polas->jam_istirahat.'-30 minute')) && $time < date('H:i', strtotime('15:00')) ):
                            //         $data->jam_istirahat = $time;
                                
                            //     elseif ($data->jam_masuk_istirahat == null && $time >= date('H:i', strtotime('15:00')) && $time <= date('H:i', strtotime($polas->jam_istirahat_masuk.'+30 minute')) ):
                            //         $data->jam_masuk_istirahat = $time;
                                
                            //     elseif ($data->jam_pulang == null  && $time >= date('H:i', strtotime($polas->jam_pulang.'-30 minute')) && $time <= date('H:i', strtotime($polas->jam_pulang.'+60 minute')) ):
                            //         $data->jam_pulang = $time;
                            //     endif;
                            // else:
                                if ($data->jam_masuk == null && $time <= date('H:i', strtotime($polas->jam_masuk.'+60 minute'))):
                                    $data->jam_masuk = $time;
                                
                                elseif ($data->jam_istirahat == null  && $time >= date('H:i', strtotime($polas->jam_istirahat.'-30 minute')) && $time < date('H:i', strtotime($polas->jam_istirahat.'+30 minute')) ):
                                    $data->jam_istirahat = $time;
                                
                                elseif ($data->jam_masuk_istirahat == null && $time >= date('H:i', strtotime($polas->jam_istirahat_masuk.'-35 minute')) && $time <= date('H:i', strtotime($polas->jam_istirahat_masuk.'+30 minute')) ):
                                    $data->jam_masuk_istirahat = $time;
                                
                                elseif ($data->jam_pulang == null  && $time >= date('H:i', strtotime($polas->jam_pulang.'-30 minute')) && $time <= date('H:i', strtotime('22:00')) ):
                                    $data->jam_pulang = $time;
                                endif;
                            // endif;
  
                        endif;
                        $data->update();
                    endif;
                endforeach; //attedance 2
            endif;
        endforeach;
                   
    }

    public function updateFingerData(Request $request)
    {
        // $time = date('H:i:s', strtotime($a['timestamp']));
        // $data->tanggal = date('Y-m-d', strtotime($a['timestamp']));
        $hariini = date('Y-m-d');
        // $data->pegawai_id = $u['userid'];

        $users = array(
            [
                'userid' => '1',
                'nama' => 'Rina'
            ],
            [
                'userid' => '2',
                'nama' => 'Aisyah'
            ],
            [
                'userid' => '3',
                'nama' => 'Deny'
            ],
            [
                'userid' => '4',
                'nama' => 'Ghofur'
            ]
        );

        $att = array(
            [
                'timestamp' => '03-01-2022 07:54:07',
                'id' => '1'
            ],
            [
                'timestamp' => '03-01-2022 08:00:40',
                'id' => '3'
            ],
            
            [
                'timestamp' => '03-01-2022 11:20:40',
                'id' => '2'
            ],
            [
                'timestamp' => '03-01-2022 13:27:37',
                'id' => '1'
            ],
            [
                'timestamp' => '03-01-2022 13:59:37',
                'id' => '1'
            ],
            // [
            //     'timestamp' => '03-01-2022 13:59:40',
            //     'id' => '3'
            // ],
            
            [
                'timestamp' => '03-01-2022 15:22:00',
                'id' => '3'
            ],
            [
                'timestamp' => '03-01-2022 15:23:00',
                'id' => '3'
            ],
            [
                'timestamp' => '03-01-2022 16:58:00',
                'id' => '3'
            ],
            [
                'timestamp' => '03-01-2022 21:08:00',
                'id' => '1'
            ],
            [
                'timestamp' => '03-01-2022 17:03:00',
                'id' => '2'
            ],
            [
                'timestamp' => '03-01-2022 17:53:00',
                'id' => '2'
            ],
            [
                'timestamp' => '03-01-2022 21:03:00',
                'id' => '2'
            ],
            [
                'timestamp' => '03-01-2022 21:05:00',
                'id' => '3'
            ],
        );

            
            foreach ($users as $u):
                $data = Kehadiran::where('tanggal', $hariini)
                ->where('pegawai_id', $u['userid'])
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
                                $time = date('H:i', strtotime($a['timestamp']));
                                $data->tanggal = date('Y-m-d', strtotime($a['timestamp']));
                                $data->pegawai_id = $u['userid'];

                                // if ($polas->nama == 'PS' || $polas->nama == 'ps'):
                                //     if ($data->jam_masuk == null && $time <=  date('H:i', strtotime('+60 minutes', strtotime($polas->jam_masuk))) ):
                                //         $data->jam_masuk = $time;
                                    
                                //     elseif ($data->jam_istirahat == null  && $time >=  date('H:i', strtotime('-30 minutes', strtotime($polas->jam_istirahat))) && $time >=  date('H:i', strtotime('+30 minutes', strtotime($polas->jam_istirahat))) && $time >= date('H:i', strtotime('13:00')) && $time <= date('H:i', strtotime('17:00')) ):
                                //         $data->jam_istirahat = $time;
                                    
                                //     elseif ($data->jam_istirahat != null && $data->jam_masuk_istirahat == null && $time >= date('H:i', strtotime('13:00')) && $time <= date('H:i', strtotime('17:00')) && $time > date('H:i', strtotime('+30 minutes', strtotime($data->jam_istirahat))) ):
                                //         $data->jam_masuk_istirahat = $time;
                                    
                                //     elseif ($data->jam_pulang == null  && $time >= date('H:i', strtotime('-30 minutes', strtotime($polas->jam_pulang))) && $time <= date('H:i', strtotime('22:00')) ):
                                //         $data->jam_pulang = $time;
                                //     endif;
                                // else:
                                //     if ($data->jam_masuk == null && $time <= date('H:i', strtotime('+60 minutes', strtotime($polas->jam_masuk))) ):
                                //         $data->jam_masuk = $time;
                                    
                                //     elseif ($data->jam_istirahat == null  && $time >=  date('H:i', strtotime('-30 minutes', strtotime($polas->jam_istirahat))) && $time <=  date('H:i', strtotime('+30 minutes', strtotime($polas->jam_istirahat))) ):
                                //         $data->jam_istirahat = $time;
                                    
                                //     elseif ($data->jam_masuk_istirahat == null && $time >= date('H:i', strtotime('-35 minutes', strtotime($polas->jam_istirahat_masuk))) && $time <= date('H:i', strtotime('+30 minutes', strtotime($polas->jam_istirahat_masuk))) ):
                                //         $data->jam_masuk_istirahat = $time;
                                //     elseif ($data->jam_pulang == null  && $time >= date('H:i', strtotime('-30 minutes', strtotime($polas->jam_pulang))) && $time <= date('H:i', strtotime('22:00')) ):
                                //         $data->jam_pulang = $time;
                                //     endif;
                                // endif;

                                // if ($polas->nama == 'PS' || $polas->nama == 'ps'):
                                //     if ($data->jam_masuk == null && $time <= date('H:i', strtotime($polas->jam_masuk.'+60 minute'))):
                                //         $data->jam_masuk = $time;
                                    
                                //     elseif ($data->jam_istirahat == null  && $time >= date('H:i', strtotime($polas->jam_istirahat.'-30 minute')) && $time < date('H:i', strtotime('15:00')) ):
                                //         $data->jam_istirahat = $time;
                                    
                                //     elseif ($data->jam_masuk_istirahat == null && $time >= date('H:i', strtotime('15:00')) && $time <= date('H:i', strtotime($polas->jam_istirahat_masuk.'+30 minute')) ):
                                //         $data->jam_masuk_istirahat = $time;
                                    
                                //     elseif ($data->jam_pulang == null  && $time >= date('H:i', strtotime($polas->jam_pulang.'-30 minute')) && $time <= date('H:i', strtotime($polas->jam_pulang.'+60 minute')) ):
                                //         $data->jam_pulang = $time;
                                //     endif;
                                // else:
                                //     if ($data->jam_masuk == null && $time <= date('H:i', strtotime($polas->jam_masuk.'+60 minute'))):
                                //         $data->jam_masuk = $time;
                                    
                                //     elseif ($data->jam_istirahat == null  && $time >= date('H:i', strtotime($polas->jam_istirahat.'-30 minute')) && $time < date('H:i', strtotime($polas->jam_istirahat.'+30 minute')) ):
                                //         $data->jam_istirahat = $time;
                                    
                                //     elseif ($data->jam_masuk_istirahat == null && $time >= date('H:i', strtotime($polas->jam_istirahat_masuk.'-35 minute')) && $time <= date('H:i', strtotime($polas->jam_istirahat_masuk.'+30 minute')) ):
                                //         $data->jam_masuk_istirahat = $time;
                                    
                                //     elseif ($data->jam_pulang == null  && $time >= date('H:i', strtotime($polas->jam_pulang.'-30 minute')) && $time <= date('H:i', strtotime($polas->jam_pulang.'+60 minute')) ):
                                //         $data->jam_pulang = $time;
                                //     endif;
                                // endif;
                                
                            
                                if ($data->jam_masuk == null && date('H:i', strtotime( $time)) <= date('H:i', strtotime($polas->jam_masuk.'+60 minute')) ):
                                    $data->jam_masuk = date('H:i', strtotime( $time));
                                elseif ($data->jam_istirahat == null  && date('H:i', strtotime( $time )) >= date('H:i', strtotime($polas->jam_istirahat.'-30 minute')) && date('H:i', strtotime( $time )) <= date('H:i', strtotime($polas->jam_istirahat.'+30 minute')) ):
                                    $data->jam_istirahat = date('H:i', strtotime( $time));
                                elseif ($data->jam_masuk_istirahat == null && date('H:i', strtotime( $time )) > date('H:i', strtotime($polas->jam_istirahat_masuk.'-35 minute')) && date('H:i', strtotime( $time )) <= date('H:i', strtotime($polas->jam_istirahat_masuk.'+30 minute')) ):
                                    $data->jam_masuk_istirahat = date('H:i', strtotime( $time));
                                elseif ($data->jam_pulang == null  && date('H:i', strtotime( $time)) >= date('H:i', strtotime($polas->jam_pulang.'-30 minute')) && date('H:i', strtotime( $time )) <= date('H:i', strtotime('22:00')) ):
                                    $data->jam_pulang = date('H:i', strtotime( $time));
                                endif;
                                $data->update();
                            endif;
                        endif;
                        
                    endforeach;
                endif;
            endforeach;
            
            // dd($data);

            // return redirect()->route('kehadiran');
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
    //     $zk = new ZKTeco('192.168.1.201', 4370);
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
        // $zk = new ZKTeco('192.168.1.201', 4370);
        // $zk2 = new ZKTeco('192.168.22.73', 4370);
        $zk2 = new ZKTeco('192.168.22.71', 4370);
        $zk2->connect();
        $zk2->disableDevice();
        $att2 = $zk2->getAttendance();

        dd($att2);

    }

    public function cekUserFingerprint()
    {
        // $zk = new ZKTeco('192.168.1.201', 4370);
        $zk2 = new ZKTeco('192.168.22.73', 4370);
        $zk2->connect();
        $zk2->disableDevice();
        $users2 = $zk2->getUser();

        dd($users2);

    }

    public function addPegawaiToFingerprint()
    {
        $zk = new ZKTeco('192.168.22.71', 4370);
        $zk->connect();
        $zk->disableDevice();
        $zk2 = new ZKTeco('192.168.22.73', 4370);
        $zk2->connect();
        $zk2->disableDevice();

        $pegawais = Pegawai::latest('id')->first();
        $zk->setUser($pegawais->id, $pegawais->id, $pegawais->nama, '');
        $zk2->setUser($pegawais->id, $pegawais->id, $pegawais->nama, '');
        // foreach ($pegawais as $item):
            // $zk2->setUser($item->id, $item->id, $item->nama, strtolower($item->nama));
        // endforeach;

        return redirect()->back();
        
        // return view('gocay.fingerprint', [
        //     'datafingers' => $datafingers,
        //     'jabatans' => $jabatans,
        // ]);
    }

    public function setUserFingerprint(Request $request)
    {
        $zk = new ZKTeco('192.168.22.73', 4370);
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
        $zk = new ZKTeco('192.168.22.73', 4370);
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
        $zk = new ZKTeco('192.168.22.73', 4370);
        $zk->connect();
        $zk->disableDevice();
        $zk->clearAttendance();

        // return view('gocay.fingerprint', [
        //     'datafingers' => $datafingers,
        //     'jabatans' => $jabatans,
        // ]);
    }
}
