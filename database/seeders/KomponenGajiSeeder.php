<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class KomponenGajiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Komponen_gaji::insert([
            [ 
                'nama' => 'Bonus Mingguan',
                'nominal' => '50000',
                'jabatan_id' => '1',
            ],
            [ 
                'nama' => 'Bonus Bulanan',
                'nominal' => '50000',
                'jabatan_id' => '1',
            ],
             [ 
                'nama' => 'Bonus Libur Masuk',
                'nominal' => '250000',
                'jabatan_id' => '1',
            ],
             [ 
                'nama' => 'Potongan Tidak Masuk',
                'nominal' => '250000',
                'jabatan_id' => '1',
            ],
           
        ]);
    }
}
