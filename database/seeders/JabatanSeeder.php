<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Jabatan;


class JabatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Fake Jabatan
        // Jabatan::factory()->times(10)->create();
        \App\Models\Jabatan::insert([
            [ 
                'nama' => 'Kasir 1',
                'deskripsi' => 'Kasir 1',
            ],
            [ 
                'nama' => 'Kasir 2',
                'deskripsi' => 'Kasir 2',
            ],
            [ 
                'nama' => 'Satpam 1',
                'deskripsi' => 'Satpam 1',
            ],
            [ 
                'nama' => 'Satpam 2',
                'deskripsi' => 'Satpam 2',
            ]
        ]);
    }
}
