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

            'Data Master' => [
                'icon' => 'box',
                'title' => 'Data Master',
                'sub_menu' => [
                    'Modul Pegawai' => [
                        'icon' => 'user-plus',
                        'route_name' => 'pegawai',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                        'title' => 'Modul Pegawai'
                    ],
                    'Modul Jabatan' => [
                        'icon' => 'award',
                        'route_name' => 'jabatan',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                        'title' => 'Modul Jabatan'
                    ],
                ],
            ],
            'Penjadwalan' => [
                'icon' => 'monitor',
                'title' => 'Penjadwalan',
                'sub_menu' => [
                    
                    'Modul Pola Kerja' => [
                        'icon' => 'refresh-cw',
                        'route_name' => 'pola-kerja',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                        'title' => 'Modul Pola Kerja'
                    ],

                    'Modul Kelompok Kerja' => [
                        'icon' => 'users',
                        'route_name' => 'kelompok-kerja',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                        'title' => 'Modul Kelompok Kerja'
                    ],

                    'Modul Kalender Kerja' => [
                        'icon' => 'calendar',
                        'route_name' => 'kalender',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                        'title' => 'Modul Kalender Kerja'
                    ],

                ],
            ],

           

            'Kehadiran' => [
                'icon' => 'clock',
                'title' => 'Kehadiran',
                'sub_menu' => [
                    'Data Kehadiran' => [
                        'icon' => 'minus',
                        'title' => 'Data Kehadiran',
                        'route_name' => 'kehadiran',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                    ],

                    'Modul Lembur' => [
                        'icon' => 'activity',
                        'route_name' => 'lembur',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                        'title' => 'Modul Lembur'
                    ],
                    
                ],
            ],

            
            'Keuangan' => [
                'icon' => 'dollar-sign',
                'title' => 'Keuangan',
                'sub_menu' => [
                    'Modul Bon-Kas' => [
                        'icon' => 'trending-down',
                        'route_name' => 'bon-kas',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                        'title' => 'Modul Bon-Kas'
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
                    
                    
                ],
            ],

            'Pengecualian' => [
                'icon' => 'user-check',
                'route_name' => 'pengecualian',
                'params' => [
                    'layout' => 'side-menu'
                ],
                'title' => 'Pengecualian'
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
