<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;


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

        // $this->call(PegawaiSeeder::class);
        // $this->call(JabatanSeeder::class);

        
    }
}
