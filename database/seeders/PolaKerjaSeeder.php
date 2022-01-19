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
                'jam_masuk' => '08:00',
                'jam_istirahat' => '12:00',
                'jam_istirahat_masuk' => '13:00',
                'jam_pulang' => '17:00'
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
                'jam_masuk' => '08:00',
                'jam_istirahat' => '12:00',
                'jam_istirahat_masuk' => '17:00',
                'jam_pulang' => '21:00'
            ],
            [
                'nama' => 'Full Day 1',
                'jam_masuk' => '08:00',
                'jam_istirahat' => '13:00',
                'jam_istirahat_masuk' => '15:00',
                'jam_pulang' => '21:00'
            ],
            [
                'nama' => 'Full Day 2',
                'jam_masuk' => '08:00',
                'jam_istirahat' => '14:00',
                'jam_istirahat_masuk' => '16:00',
                'jam_pulang' => '21:00'
            ],
            [
                'nama' => 'Full Day 3',
                'jam_masuk' => '08:00',
                'jam_istirahat' => '15:00',
                'jam_istirahat_masuk' => '17:00',
                'jam_pulang' => '21:00'
            ]

        ]);
    }
}
