<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pola;
use App\Models\Jabatan;
use App\Models\Pegawai;
use App\Models\User;
use App\Models\Setting;
use App\Models\Jam;
use App\Models\Bon_kas;
use App\Models\Lembur;




class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserSeeder::class);
        $this->call(SettingSeeder::class);
        $this->call(PolaKerjaSeeder::class);
        $this->call(PegawaiSeeder::class);
        $this->call(KomponenGajiSeeder::class);
        $this->call(KelompokKerjaSeeder::class);
        $this->call(JamSeeder::class);
        $this->call(JabatanSeeder::class);
        $this->call(BonKasSeeder::class);
        $this->call(LemburSeeder::class);


        // $this->call(PegawaiSeeder::class);
        // $this->call(JabatanSeeder::class);

        
    }
}
