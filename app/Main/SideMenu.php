<?php

namespace App\Main;

class SideMenu
{
    /**
     * List of side menu items.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public static function menu()
    {
        return [
            'Modul Kehadiran' => [
                'icon' => 'monitor',
                'title' => 'Modul Kehadiran',
                'route_name' => 'kehadiran',
                'params' => [
                    'layout' => 'side-menu'
                ],
            ],
            'Modul Pegawai' => [
                'icon' => 'user-plus',
                'route_name' => 'pegawai',
                'params' => [
                    'layout' => 'side-menu'
                ],
                'title' => 'Modul Pegawai'
            ],
            'Modul Kelompok Kerja' => [
                'icon' => 'users',
                'route_name' => 'kelompok-kerja',
                'params' => [
                    'layout' => 'side-menu'
                ],
                'title' => 'Modul Kelompok Kerja'
            ],
            'Modul Jabatan' => [
                'icon' => 'award',
                'route_name' => 'jabatan',
                'params' => [
                    'layout' => 'side-menu'
                ],
                'title' => 'Modul Jabatan'
            ],
            'Modul Bon-Kas' => [
                'icon' => 'trending-down',
                'route_name' => 'bon-kas',
                'params' => [
                    'layout' => 'side-menu'
                ],
                'title' => 'Modul Bon-Kas'
            ],
            'Modul Pola Kerja' => [
                'icon' => 'clock',
                'route_name' => 'pola-kerja',
                'params' => [
                    'layout' => 'side-menu'
                ],
                'title' => 'Modul Pola Kerja'
            ],
            'Modul Kalender Kerja' => [
                'icon' => 'calendar',
                'route_name' => 'kalender',
                'params' => [
                    'layout' => 'side-menu'
                ],
                'title' => 'Modul Kalender Kerja'
            ],
            'Modul Gaji Karyawan' => [
                'icon' => 'dollar-sign',
                'route_name' => 'gaji',
                'params' => [
                    'layout' => 'side-menu'
                ],
                'title' => 'Modul Gaji Karyawan'
            ],
            'Modul Komponen Gaji Karyawan' => [
                'icon' => 'list',
                'route_name' => 'komponen-gaji',
                'params' => [
                    'layout' => 'side-menu'
                ],
                'title' => 'Modul Komponen Gaji Karyawan'
            ],
            'Modul Lembur' => [
                'icon' => 'activity',
                'route_name' => 'lembur',
                'params' => [
                    'layout' => 'side-menu'
                ],
                'title' => 'Modul Lembur'
            ],
            'devider',
            'Setting' => [
                'icon' => 'trello',
                'title' => 'Setting Perusahaan',
                // 'route_name' => 'profile-overview-1',
                'route_name' => 'setting-perusahaan',
                'params' => [
                    'layout' => 'side-menu'
                ],
            ],
                
            
        ];
    }
}
