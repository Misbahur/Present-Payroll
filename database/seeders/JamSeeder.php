<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Jam;

class JamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Jam::insert([
            [
                'name' => 'Jam Kantor',
                'value' => '07:00 - 21:00',
            ]
        ]);
    }
}
