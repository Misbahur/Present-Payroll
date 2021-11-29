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
                        <a href="" class="ml-auto flex items-center text-theme-1 dark:text-theme-10">
                            <i data-feather="refresh-ccw" class="w-4 h-4 mr-3"></i> Reload Data
                        </a>
                    </div>
                    <div class="grid grid-cols-12 gap-6 mt-5">
                        <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                            <div class="report-box zoom-in">
                                <div class="box p-5">
                                    <div class="flex">
                                        <i data-feather="users" class="report-box__icon text-theme-10"></i>
                                    </div>
                                    <div class="text-3xl font-bold leading-8 mt-6">{{$jumlahPegawai->count()}}</div>
                                    <div class="text-base text-gray-600 mt-1">Jumlah Pegawai Hadir</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                            <div class="report-box zoom-in">
                                <div class="box p-5">
                                    <div class="flex">
                                        <i data-feather="shopping-cart" class="report-box__icon text-theme-11"></i>
                                    </div>
                                    <div class="text-3xl font-bold leading-8 mt-6">
                                        {{$jumlahPegawaiKasir->count()}}
                                    </div>
                                    <div class="text-base text-gray-600 mt-1">Total Pegawai Kasir</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                            <div class="report-box zoom-in">
                                <div class="box p-5">
                                    <div class="flex">
                                        <i data-feather="codesandbox" class="report-box__icon text-theme-12"></i>
                                    </div>
                                    <div class="text-3xl font-bold leading-8 mt-6">
                                        {{ $jumlahSatpam->count() }}
                                    </div>
                                    <div class="text-base text-gray-600 mt-1">Total Satpam </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                            <div class="report-box zoom-in">
                                <div class="box p-5">
                                    <div class="flex">
                                        <i data-feather="monitor" class="report-box__icon text-theme-9"></i>
                                    </div>
                                    <div class="text-3xl font-bold leading-8 mt-6">
                                        
                                    </div>
                                    <div class="text-base text-gray-600 mt-1">Total Pegawai Kantor</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END: General Report -->

                <!-- BEGIN: Weekly Top Products -->
                <div class="col-span-12 mt-6">
                    <div class="intro-y block sm:flex items-center h-10">
                        <h2 class="text-lg font-medium truncate mr-5">Daftar Karyawan</h2>
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
                                    <th class="whitespace-nowrap">Tanggal</th>
                                    <th class="text-center whitespace-nowrap">Pegawai</th>
                                    <th class="text-center whitespace-nowrap">Jabatan</th>
                                    <th class="text-center whitespace-nowrap">Jam Masuk</th>
                                    <th class="text-center whitespace-nowrap">Jam Istirahat</th>
                                    <th class="text-center whitespace-nowrap">Jam Istirahat Masuk</th>
                                    <th class="text-center whitespace-nowrap">Jam Pulang</th>
                                    <!-- <th class="text-center whitespace-nowrap">Aksi</th> -->
                                </tr>
                            </thead>
                            <tbody>
                            <?php $no = 1; ?>
                            @foreach ($kehadirans as $item)
                                    <tr class="intro-x">
                                        <td class="w-20 text-right">
                                        {{ $no++ }}
                                        </td>
                                        <td class="w-20 text-center">
                                            <a href="" class="font-small whitespace-nowrap">{{ $item->tanggal }}</a>
                                        </td>
                                        <td class="w-20 text-center">
                                            {{ $item->pegawai->nama }}
                                        </td> 
                                        <td class="w-20 text-center">
                                            {{ $item->jabatan->nama }}
                                        </td>         
                                        <td class="w-20 text-center">
                                            {{ $item->jam_masuk }}
                                        </td>
                                        <td class="w-20 text-center">
                                            {{ $item->jam_istirahat }}
                                        </td>
                                        <td class="w-20 text-center">
                                            {{ $item->jam_masuk_istirahat }}
                                        </td>
                                        <td class="w-40 text-center">
                                            {{ $item->jam_pulang }}
                                        </td>
                                        <!-- <td class="table-report__action w-56">
                                            <div class="flex justify-center items-center">
                                                <a class="flex items-center mr-3" href="">
                                                    <i data-feather="check-square" class="w-4 h-4 mr-1"></i> Edit
                                                </a>
                                                <a class="flex items-center text-theme-6" href="">
                                                    <i data-feather="trash-2" class="w-4 h-4 mr-1"></i> Delete
                                                </a>
                                            </div>
                                        </td> -->
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="intro-y flex flex-wrap sm:flex-row sm:flex-nowrap items-center mt-3">
                        <div class="pagination">
                            {{ $kehadirans->links() }}
                        </div>
                    </div>
                </div>
                <!-- END: Weekly Top Products -->
                
            </div>
        </div>
        
    </div>

    
@endsection
