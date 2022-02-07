<?php

namespace App\Console\Commands;
use Illuminate\Console\Command;

use App\Models\Kehadiran;
use App\Models\Pegawai;
use App\Models\Jadwal;
use App\Models\Pola;
use App\Models\Temporary;
use App\Models\Lembur;
use App\Models\Pengecualian;
use App\Models\Komponen_gaji;
use Carbon\Carbon;

class bonusMingguan extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bonus:week';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Schedule penamabahan data bonus mingguan pegawai';

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
       
        $komponen_gaji = Komponen_gaji::all();
        $pegawais = Pegawai::all();
        $hari_ini = date('d');
        // $tanggal_awal = date('Y-m-d', strtotime('+21 day', strtotime('2022-01-01')));
        // $tanggal_akhir = date('Y-m-d', strtotime('+6 day', strtotime($tanggal_awal)));
        
        if ($hari_ini <= 7):
            $tanggal_awal = date('Y-m-d', strtotime('first day of this month'));
            $tanggal_akhir = date('Y-m-d', strtotime('+6 day', strtotime($tanggal_awal)));
        elseif ($hari_ini <= 14):
            $tanggal_awal = date('Y-m-d', strtotime('+7 day', strtotime('first day of this month')));
            $tanggal_akhir = date('Y-m-d', strtotime('+6 day', strtotime($tanggal_awal)));
        elseif ($hari_ini <= 21):
            $tanggal_awal = date('Y-m-d', strtotime('+14 day', strtotime('first day of this month')));
            $tanggal_akhir = date('Y-m-d', strtotime('+6 day', strtotime($tanggal_awal)));
        elseif ($hari_ini <= date('t')):
            $tanggal_awal = date('Y-m-d', strtotime('+21 day', strtotime('first day of this month')));
            $tanggal_akhir = date('Y-m-d', strtotime('+6 day', strtotime($tanggal_awal)));
        endif;
        


        foreach ($pegawais as $p):
           

                // $temp = Temporary::where('tanggal', date('Y-m-d'))
                $temp = Temporary::where('tanggal', $tanggal_awal)
                ->where('pegawai_id', $p->id)
                ->where('status', 'in-bonus-mingguan')
                ->first();


                $countDate = Kehadiran::whereBetween('tanggal', [$tanggal_awal ,$tanggal_akhir])
                ->where('jam_masuk', '!=' , null)
                ->where('pegawai_id', $p->id)
                ->get()->count('pegawai_id');
                
                if ($countDate == 6 && $temp == null):
                    $temporary_in = new Temporary;
                    // $temporary_in->tanggal = Carbon::now();
                    $temporary_in->tanggal = $tanggal_awal;
                    $temporary_in->created_at = date('Y-m-d h:i:s', strtotime($tanggal_awal));
                    $temporary_in->updated_at = date('Y-m-d h:i:s', strtotime($tanggal_awal));
                    $temporary_in->status = 'in-bonus-mingguan';
                    $temporary_in->pegawai_id = $p->id;
                    $temporary_in->nominal = $komponen_gaji[0]->nominal;
                    $temporary_in->save();
                else:
                    continue;
                endif;

        endforeach;

        $this->info('Data bonus mingguan Pegawai berhasil ditambahkan');
    
    }
}
