<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Bank;


class BankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Bank::insert([
            [
                'nama' => 'BCA',
            ],
            [
                'nama' => 'BNI',
            ],
            [
                'nama' => 'Mandiri',
            ],
            [
                'nama' => 'BRI',
            ]
        ]);
    }
}
