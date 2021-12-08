@extends('../layout/' . $layout)

@section('subhead')
    <title>Sistem Present & Payrol Gocay</title>
@endsection

@section('subcontent')
    <div class="grid grid-cols-12 gap-6">
        <div class="col-span-12 xxl:col-span-9">
            <div class="grid grid-cols-12 gap-6">
                <!-- BEGIN: General Report -->
                <div class="col-span-12 mt-8">
                    <div class="intro-y flex items-center h-10">
                        <h2 class="text-lg font-medium truncate mr-5">Data Kehadiran</h2>
                        <!-- <a href="{{route('cekUserFingerprint')}}" class="ml-auto flex items-center text-theme-1 dark:text-theme-10">
                            <i data-feather="refresh-ccw" class="w-4 h-4 mr-3"></i> Reload Data
                        </a> -->
                        <a href="{{ route('cekUserFingerprint') }}" class="btn btn-success ml-auto flex items-center">
                            <i data-feather="refresh-cw" class="hidden sm:block w-4 h-4"></i>
                        </a>
                    </div>
                </div>
                <!-- END: General Report -->

                <!-- BEGIN: Weekly Top Products -->
                <div class="col-span-12 mt-6">
                    <div class="intro-y block sm:flex items-center h-10">
                        <h2 class="text-lg font-medium truncate mr-5">Data Fingerprint</h2>
                        <div class="flex items-center sm:ml-auto mt-3 sm:mt-0">
                            <button class="btn box flex items-center text-gray-700 dark:text-gray-300">
                                <i data-feather="file-text" class="hidden sm:block w-4 h-4 mr-2"></i> Export to Excel
                            </button>
                            <button class="ml-3 btn box flex items-center text-gray-700 dark:text-gray-300">
                                <i data-feather="file-text" class="hidden sm:block w-4 h-4 mr-2"></i> Export to PDF
                            </button>
                        </div>
                    </div>
                    <div class="intro-y overflow-auto lg:overflow-visible mt-8 sm:mt-0">
                        <table class="table table-report sm:mt-2">
                            <thead>
                                <tr>
                                <th class="whitespace-nowrap">No</th>
                                    <!-- <th class="whitespace-nowrap">NIP</th> -->
                                    <th class="whitespace-nowrap">Tanggal</th>
                                    <th class="text-center whitespace-nowrap">Nama Pegawai</th>
                                    <th class="text-center whitespace-nowrap">Jabatan</th>
                                    <th class="text-center whitespace-nowrap">Jam Masuk</th>
                                    <th class="text-center whitespace-nowrap">Jam Istirahat</th>
                                    <th class="text-center whitespace-nowrap">Jam Istirahat Masuk</th>
                                    <th class="text-center whitespace-nowrap">Jam Pulang</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php $no = 1; ?>
                            @foreach ($datafingers as $item)
                                <tr class="intro-x">
                                    <td class="w-20">
                                    {{ $no++ }}
                                    </td>
                                    <td class="w-20 text-center">
                                        <a href="" class="font-small whitespace-nowrap">{{ $item->tanggal }}</a>
                                    </td>
                                    <!-- <td class="w-20 text-center">
                                        <a href="" class="font-small whitespace-nowrap"></a>
                                    </td> -->
                                    <td class="w-20 text-center">
                                        {{ $item->pegawai_id }}
                                    </td> 
                                    <td class="w-20 text-center">
                                        {{ $item->jabatan_id }}
                                    </td>         
                                    <td class="w-20 text-center jam_masuk{{ $item->pegawai_id }}">
                                        {{ $item->jam_masuk ? $item->jam_masuk : '-'}}
                                    </td>
                                    <td class="w-20 text-center jam_istirahat{{ $item->pegawai_id }}">
                                        {{ $item->jam_istirahat ? $item->jam_istirahat : '-' }}
                                    </td>
                                    <td class="w-20 text-center jam_masuk_istirahat{{ $item->pegawai_id }}">
                                        {{ $item->jam_masuk_istirahat ? $item->jam_masuk_istirahat : '-'}}
                                    </td>
                                    <td class="w-40 text-center jam_pulang{{ $item->pegawai_id }}">
                                        {{ $item->jam_pulang ? $item->jam_pulang : '-'}}
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                </div>
                <!-- END: Weekly Top Products -->
                
            </div>
        </div>
        
    </div>

    
@endsection
