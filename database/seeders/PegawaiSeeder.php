<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pegawai;

class PegawaiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Fake Pegawai
        // Pegawai::factory()->times(10)->create();
        \App\Models\Pegawai::insert([
            [ 
                'nama' => 'Rina',
                'jabatan_id' => '1',
            ],
            [ 
                'nama' => 'Aisyah',
                'jabatan_id' => '1',
            ],
            [ 
                'nama' => 'Deni',
                'jabatan_id' => '2',
            ],
            [ 
                'nama' => 'Ghofur',
                'jabatan_id' => '1',
            ],
        ]);
    }
}
