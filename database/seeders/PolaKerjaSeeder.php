<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Pola;


class PolaKerjaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Pola::insert([
            [
                'nama' => 'Pagi',
                'jam_masuk' => '07:00',
                'jam_istirahat' => '12:00',
                'jam_istirahat_masuk' => '13:00',
                'jam_pulang' => '16:00'
            ],
            [
                'nama' => 'Siang',
                'jam_masuk' => '12:00',
                'jam_istirahat' => '16:00',
                'jam_istirahat_masuk' => '17:00',
                'jam_pulang' => '21:00'
            ],
            [
                'nama' => 'PS',
                'jam_masuk' => '07:00',
                'jam_istirahat' => '12:00',
                'jam_istirahat_masuk' => '16:00',
                'jam_pulang' => '21:00'
            ]
        ]);
    }
}
