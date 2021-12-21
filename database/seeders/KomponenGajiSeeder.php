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
                'masuklibur' => '0',
                'tidakmasuk' => '0',
                'jabatan_id' => '0',
            ],
            [ 
                'nama' => 'Bonus Bulanan',
                'nominal' => '50000',
                'masuklibur' => '0',
                'tidakmasuk' => '0',
                'jabatan_id' => '0',
            ],
             [ 
                'nama' => 'Gaji Kasir Junior',
                'nominal' => '4500000',
                'masuklibur' => '100000',
                'tidakmasuk' => '80000',
                'jabatan_id' => '1',
            ],
             [ 
                'nama' => 'Gaji Kasir Senior',
                'nominal' => '5000000',
                'masuklibur' => '200000',
                'tidakmasuk' => '100000',
                'jabatan_id' => '1',
            ],
            [ 
                'nama' => 'Gaji Satpam Junior',
                'nominal' => '4500000',
                'masuklibur' => '100000',
                'tidakmasuk' => '80000',
                'jabatan_id' => '1',
            ],
             [ 
                'nama' => 'Gaji Satpam Senior',
                'nominal' => '5000000',
                'masuklibur' => '200000',
                'tidakmasuk' => '100000',
                'jabatan_id' => '1',
            ],
           
        ]);
    }
}
