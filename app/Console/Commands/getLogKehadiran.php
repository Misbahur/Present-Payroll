<?php

namespace App\Console\Commands;
use Illuminate\Console\Command;

use Rats\Zkteco\Lib\ZKTeco;
use App\Models\Fingerprint;
use App\Models\Pegawai;
use App\Models\Jabatan;
use App\Models\Jadwal;
use App\Models\Pola;

class getLogKehadiran extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'kehadiran:log';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get Log Data Kehadiran Pegawai';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $zk = new ZKTeco('192.168.1.201', 4370);
        $zk->connect();
        $zk->disableDevice();
        $users = $zk->getUser();
        $att = $zk->getAttendance();
        $hariini = date('Y-m-d');
            
        foreach ($users as $u):
            $data = Fingerprint::where('tanggal', $hariini)
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
                            $time = date('H:i:s', strtotime($a['timestamp']));
                            $data->tanggal = date('Y-m-d', strtotime($a['timestamp']));
                            $data->pegawai_id = $u['userid'];

                            if ($data->jam_masuk == null  && $time < $polas->jam_masuk):
                                $data->jam_masuk = $time;
                            elseif ($data->jam_istirahat == null  && $time > $polas->jam_istirahat && $time < $polas->jam_masuk_istirahat):
                                $data->jam_istirahat = $time;
                            elseif ($data->jam_masuk_istirahat == null  && $time < $polas->jam_masuk_istirahat):
                                $data->jam_masuk_istirahat = $time;
                            elseif ($data->jam_pulang == null  && $time > $polas->jam_pulang ):
                                $data->jam_pulang = $time;
                            endif;
                        endif;
                        $data->update();
                    endif;
                endforeach;
            endif;
        endforeach;

        $this->info('Data log kehadiran Pegawai berhasil ditambahkan');

    }
}