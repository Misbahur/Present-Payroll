<?php

namespace App\Main;

use Auth;


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
            'Fingerprint' => [
                'icon' => 'airplay',
                'route_name' => 'fingerprint',
                'params' => [
                    'layout' => 'side-menu'
                ],
                'title' => 'Fingerprint'
            ],
            
            
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

                    'Modul Jadwal' => [
                        'icon' => 'users',
                        'route_name' => 'jadwal',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                        'title' => 'Modul Jadwal'
                    ],

                    // 'Modul Kalender Kerja' => [
                    //     'icon' => 'calendar',
                    //     'route_name' => 'kalender',
                    //     'params' => [
                    //         'layout' => 'side-menu'
                    //     ],
                    //     'title' => 'Modul Kalender Kerja'
                    // ],

                    'Jadwal Libur Pegawai' => [
                        'icon' => 'activity',
                        'route_name' => 'libur',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                        'title' => 'Jadwal Libur Pegawai'
                    ],

                ],
            ],

            'Kehadiran' => [
                'icon' => 'clock',
                'title' => 'Kehadiran',
                'sub_menu' => [
                    'Kehadiran Harian' => [
                        'icon' => 'bar-chart-2',
                        'title' => 'Kehadiran Harian',
                        'route_name' => 'kehadiran',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                    ],

                    'Kehadiran Bulanan' => [
                        'icon' => 'cloud-drizzle',
                        'title' => 'Kehadiran Bulanan',
                        'route_name' => 'kehadiran_bulanan',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
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
                    'Komponen Gaji' => [
                        'icon' => 'list',
                        'route_name' => 'komponen-gaji',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                        'title' => 'Komponen Gaji'
                    ],
                    'Penggajian' => [
                        'icon' => 'dollar-sign',
                        'route_name' => 'penggajian',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                        'title' => 'Penggajian'
                    ],
                   
                ],
            ],

            'Bank' => [
                'icon' => 'dollar-sign',
                'title' => 'Bank',
                'sub_menu' => [
                    
                    'List Bank' => [
                        'icon' => 'dollar-sign',
                        'route_name' => 'bank',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                        'title' => 'List Bank'
                    ],
                    'Pembayaran ke Bank' => [
                        'icon' => 'dollar-sign',
                        'route_name' => 'bayar_bank',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                        'title' => 'Pembayaran ke Bank'
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
            'users' => [
                'icon' => 'users',
                'route_name' => 'user',
                'params' => [
                    'layout' => 'side-menu'
                ],
                'title' => 'Users'
            ],
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
