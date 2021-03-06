<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;


class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
         Setting::insert([
            [
                'name' => 'Web Name',
                'value' => 'Sistem Present & Payroll Gocay'
            ],
            [
                'name' => 'Description',
                'value' => 'Sistem Present & Payroll Gocay'
            ],
            [
                'name' => 'Nama Perusahaan',
                'value' => 'Odete Jaya Kreatif'
            ],
            [
                'name' => 'Copyright',
                'value' => 'Odetejayakreatif.com'
            ], 
            [
                'name' => 'Email',
                'value' => 'misbahur.rifqi61@gmail.com'
            ], 
            [
                'name' => 'Phone',
                'value' => '081331992911'
            ], 
            [
                'name' => 'Address',
                'value' => 'Jl. Gelora No.17, Besuki, Kec. Besuki, Kabupaten Situbondo, Jawa Timur 68356.'
            ],
        ]);
    }
}
