<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class LemburSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        \App\Models\Lembur::insert([
            [ 
                'nama' => 'Lembur Harian',
                'durasi' => '30',
                'nominal' => '60000',
            ],
            [ 
                'nama' => 'Keterlambatan Harian',
                'durasi' => '30',
                'nominal' => '50000',
            ],
           
        ]);
    }
}
