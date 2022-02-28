@extends('../layout/' . $layout)

@section('subhead')
    <title>Sistem Present & Payrol Gocay</title>
@endsection

@section('subcontent')
     <div class="intro-y flex items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">Modul Penggajian Karyawan</h2>
    </div>
    <div class="grid grid-cols-12 gap-6 mt-5">
        <!-- BEGIN: Profile Menu -->
        <div class="col-span-12 lg:col-span-4 xxl:col-span-3 flex lg:block flex-col-reverse">
            <div class="intro-y box mt-5 lg:mt-0">
                <div class="relative flex items-center p-5 border-b">
                    <h2 class="font-medium text-base mr-auto">Filter Periode</h2>
                </div>
                <form method="GET" action="{{ route('filterperiode') }}">
                <div class="p-5 border-gray-200">
                    <select name="periode_id" class="form-select mt-2 sm:mr-2" aria-label="Default select example">
                        @foreach ($periodes as $item)
                            <option value="{{ $item->id }}">{{ $item->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="p-5 border-t border-gray-200 dark:border-dark-5 flex">
                    <button type="submit" class="btn btn-primary py-1 px-2 ml-auto">Submit</button>
                </div>
                </form>
            </div>
            <div class="intro-y box mt-5 lg:mt-2">
                <div class="relative flex items-center p-5 border-b">
                    <h2 class="font-medium text-base mr-auto">Tambah Periode</h2>
                </div>
                <form method="POST" action="{{ route('periodeadd') }}">
                @csrf
                <div class="px-4 pt-5">
                    <label for="nama">Nama Periode</label>
                    <input class="form-control" type="text" name="nama" id="nama">
                </div>
                <div class="p-2">
                    <div class="px-2 py-2">
                        <label for="tanggal_awal">Tanggal Awal</label>
                        <div id="tanggal_awal" class="relative mx-auto">
                            <div class="absolute rounded-l w-10 h-full flex items-center justify-center bg-gray-100 border text-gray-600 dark:bg-dark-1 dark:border-dark-4">
                                <i data-feather="calendar" class="w-4 h-4"></i>
                            </div>
                            <input type="text" name="tanggal_awal" class="datepicker form-control pl-12" data-single-mode="true">
                        </div>
                    </div>  
                     <div class="px-2 py-2">
                        <label for="tanggal_akhir">Tanggal Akhir</label>
                        <div id="tanggal_akhir" class="relative mx-auto">
                            <div class="absolute rounded-l w-10 h-full flex items-center justify-center bg-gray-100 border text-gray-600 dark:bg-dark-1 dark:border-dark-4">
                                <i data-feather="calendar" class="w-4 h-4"></i>
                            </div>
                            <input type="text" name="tanggal_akhir" class="datepicker form-control pl-12" data-single-mode="true">
                        </div>
                    </div> 
                </div>
                <div class="p-5 border-t border-gray-200 dark:border-dark-5 flex">
                    <button type="submit" class="btn btn-primary py-1 px-2 ml-auto">Save</button>
                </div>
                </form>
            </div>
            <div class="intro-y box p-5 bg-theme-9 text-white mt-5">
                <div class="flex items-center">
                    <div class="font-medium text-lg">Peringatan</div>
                    <div class="text-xs bg-white dark:bg-theme-1 dark:text-white text-gray-800 px-1 rounded-md ml-auto">:)</div>
                </div>
                <div class="mt-4">Sebelum melakukan penggajian diharap untuk menambah data periode terlebih dahulu</div>
                <div class="font-medium flex mt-5">
                    <button type="button" class="btn py-1 px-2 border-white text-white dark:border-gray-700 dark:text-gray-300">Oke</button>
                </div>
            </div>
        </div>
        <!-- END: Profile Menu -->
        @if (Auth::user()->role == 'su')
        <div class="col-span-12 lg:col-span-8 xxl:col-span-9">
            <div class="grid grid-cols-12 gap-6">
                <!-- BEGIN: Daily Sales -->
                <div class="intro-y box col-span-12 xxl:col-span-12">
                    <div class="flex items-center px-5 py-5 sm:py-3 border-b border-gray-200 dark:border-dark-5">
                        <h2 class="font-medium text-base mr-auto">Daily Sales</h2>
                        <div class="dropdown ml-auto sm:hidden">
                            <a class="dropdown-toggle w-5 h-5 block" href="javascript:;" aria-expanded="false">
                                <i data-feather="more-horizontal" class="w-5 h-5 text-gray-600 dark:text-gray-300"></i>
                            </a>
                            <div class="dropdown-menu w-40">
                                <div class="dropdown-menu__content box dark:bg-dark-1 p-2">
                                    <a href="javascript:;" data-toggle="modal" data-target="#header-footer-modal-preview" class="flex items-center p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md">
                                        <i data-feather="plus" class="w-4 h-4 mr-2"></i> Bunus All
                                    </a>
                                </div>
                            </div>
                        </div>
                        <a href="javascript:;" data-toggle="modal" data-target="#header-footer-modal-preview" class="btn btn-outline-primary hidden sm:flex">
                            <i data-feather="plus" class="w-4 h-4 mr-2"></i> Bunus All
                        </a>
                        <a href="javascript:;" data-toggle="modal" data-target="#cetak-jadwal-bulan"
                        class="btn btn-primary shadow-md ml-2 mr-2">
                        <i data-feather="printer" class="w-4 h-4 mr-2"></i>Print
                        </a>
                    </div>
                    <div class="overflow-x-auto px-4 py-2">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="border-b-2 dark:border-dark-5 whitespace-nowrap">#</th>
                                    <th class="border-b-2 dark:border-dark-5 whitespace-nowrap">Nam Pegawai</th>
                                    <th class="border-b-2 dark:border-dark-5 whitespace-nowrap">Jabatan</th>
                                    <th class="border-b-2 dark:border-dark-5 whitespace-nowrap">Periode</th>
                                    <th class="border-b-2 dark:border-dark-5 whitespace-nowrap">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($penggajians as $key=>$item)
                                <tr>
                                    <td class="border-b dark:border-dark-5">{{ ++   $i }}</td>
                                    <td class="border-b dark:border-dark-5">{{ $item->pegawai->nama }}</td>
                                    <td class="border-b dark:border-dark-5">{{ $item->jabatan->nama }}</td>
                                    <td class="border-b dark:border-dark-5">{{ $item->periode->nama }}</td>
                                    <td class="border-b dark:border-dark-5">
                                        <a href="{{ route('penggajiandetail', $item->id) }}" class="btn btn-warning w-24 inline-block mr-1 mb-2">
                                            <i data-feather="alert-circle" class="w-4 h-4 mr-2"></i>Detail</a>
                                        <a href="{{ route('slipgaji', $item->id) }}" class="btn btn-primary w-24 inline-block mr-1 mb-2" target="_BLANK">
                                            <i data-feather="printer" class="w-4 h-4 mr-2"></i>Print</a>
                                        <a href="{{ route('kirim-email', $item->id) }}" class="btn btn-primary w-24 inline-block mr-1 mb-2">
                                            <i data-feather="send" class="w-4 h-4 mr-2"></i>Email</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $penggajians->appends($data_request)->links() }}
                    </div>
                </div>
                <!-- END: Daily Sales -->
            </div>
        </div>
        @endif
         @if (Auth::user()->role == 'koordinator')
        <div class="col-span-12 lg:col-span-8 xxl:col-span-9">
            <div class="grid grid-cols-12 gap-6">
                <!-- BEGIN: Daily Sales -->
                <div class="intro-y box col-span-12 xxl:col-span-12">
                    <div class="flex items-center px-5 py-5 sm:py-3 border-b border-gray-200 dark:border-dark-5">
                        <h2 class="font-medium text-base mr-auto">Daily Sales</h2>
                    </div>
                    <div class="overflow-x-auto px-4 py-2">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="border-b-2 dark:border-dark-5 whitespace-nowrap">#</th>
                                    <th class="border-b-2 dark:border-dark-5 whitespace-nowrap">Nam Pegawai</th>
                                    <th class="border-b-2 dark:border-dark-5 whitespace-nowrap">Jabatan</th>
                                    <th class="border-b-2 dark:border-dark-5 whitespace-nowrap">Periode</th>
                                    <th class="border-b-2 dark:border-dark-5 whitespace-nowrap">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($penggajians as $key=>$item)
                                <tr>
                                    <td class="border-b dark:border-dark-5">{{ ++   $key }}</td>
                                    <td class="border-b dark:border-dark-5">{{ $item->pegawai->nama }}</td>
                                    <td class="border-b dark:border-dark-5">{{ $item->jabatan->nama }}</td>
                                    <td class="border-b dark:border-dark-5">{{ $item->periode->nama }}</td>
                                    <td class="border-b dark:border-dark-5">
                                        <a href="{{ route('penggajiandetail', $item->id) }}" class="btn btn-warning w-24 inline-block mr-1 mb-2">
                                            <i data-feather="alert-circle" class="w-4 h-4 mr-2"></i>Detail</a>
                                        <a href="{{ route('slipgaji', $item->id) }}" class="btn btn-primary w-24 inline-block mr-1 mb-2" target="_BLANK">
                                            <i data-feather="printer" class="w-4 h-4 mr-2"></i>Print</a>
                                        <a href="{{ route('kirim-email', $item->id) }}" class="btn btn-primary w-24 inline-block mr-1 mb-2">
                                            <i data-feather="send" class="w-4 h-4 mr-2"></i>Email</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $penggajians->links() }}
                    </div>
                </div>
                <!-- END: Daily Sales -->
            </div>
        </div>
        @endif

        <!-- BEGIN: Modal Content -->
        <div id="header-footer-modal-preview" class="modal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <!-- BEGIN: Modal Header -->
                    <div class="modal-header">
                        <h2 class="font-medium text-base mr-auto">Tambah Bunus Semua Pegawai</h2>
                        <div class="dropdown sm:hidden">
                            <a class="dropdown-toggle w-5 h-5 block" href="javascript:;" aria-expanded="false">
                                <i data-feather="more-horizontal" class="w-5 h-5 text-gray-600 dark:text-gray-600"></i>
                            </a>
                            <div class="dropdown-menu w-40">
                                <div class="dropdown-menu__content box dark:bg-dark-1 p-2">
                                    <a href="javascript:;"
                                        class="flex items-center p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md">
                                        <i data-feather="file" class="w-4 h-4 mr-2"></i> Download Docs
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- END: Modal Header -->
                    <!-- BEGIN: Modal Body -->
                    <form method="POST" action="{{ route('bonusall') }}">
                        @csrf
                    <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                        <div class="col-span-12 sm:col-span-12">
                            <label for="modal-form-1" class="form-label">Keterangan</label>
                            <input id="modal-form-1" name="keterangan" type="text" class="form-control" placeholder="Keterangan">
                        </div>
                        <div class="col-span-12 sm:col-span-12">
                            <label for="modal-form-2" class="form-label">Jabatan</label>
                            <select id="modal-form-2" class="form-select" name="status">
                                <option value="in">Bonus</option>
                                <option value="out">Potongan</option>
                            </select>
                        </div>
                        <div class="col-span-12 sm:col-span-12">
                            <label for="modal-form-3" class="form-label">Nominal</label>
                            <input id="modal-form-3" name="nominal" type="number" class="form-control" placeholder="Nominal">
                        </div>
                         @php
                            $periode_id = $_GET['periode_id'];
                        @endphp
                        <input type="hidden" name="periode_id" value="{{ $periode_id }}">
                    </div>
                    <!-- END: Modal Body -->
                    <!-- BEGIN: Modal Footer -->
                    <div class="modal-footer text-right">
                        <button type="button" data-dismiss="modal"
                            class="btn btn-outline-secondary w-20 mr-1">Cancel</button>
                        <button type="submit" class="btn btn-primary w-20">Send</button>
                    </div>
                    </form>
                    <!-- END: Modal Footer -->
                </div>
            </div>
        </div>
        <!-- END: Modal Content -->

    </div>
     <!-- BEGIN: Modal Content -->
    <div id="cetak-jadwal-bulan" class="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <!-- BEGIN: Modal Header -->
                <div class="modal-header">
                    <h2 class="font-medium text-base mr-auto">Cetak Gaji Bulanan</h2>
                    <div class="dropdown sm:hidden">
                        <a class="dropdown-toggle w-5 h-5 block" href="javascript:;" aria-expanded="false">
                            <i data-feather="more-horizontal" class="w-5 h-5 text-gray-600 dark:text-gray-600"></i>
                        </a>
                        <div class="dropdown-menu w-40">
                            <div class="dropdown-menu__content box dark:bg-dark-1 p-2">
                         <!--        <a href="javascript:;"
                                    class="flex items-center p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md">
                                    <i data-feather="file" class="w-4 h-4 mr-2"></i> Download Docs
                                </a> -->
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END: Modal Header -->
                <!-- BEGIN: Modal Body -->
                <form method="GET" id= "form-jadwal" action="{{ route('cetak-penggajian-pdf') }}">

                        @csrf
                <input type="hidden" name="periode_id" value={{ request()->get('periode_id') }}>
                <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                    <div class="col-span-12 sm:col-span-12">
                        <label for="modal-form-3" class="form-label">Pegawai</label>
                        <select name="penggajian_id[]" id="modal-form-3" data-placeholder="Pilih Pegawai" data-search="true" class="tail-select w-full" multiple>
                            @foreach ($penggajians as $item)
                                <option value="{{ $item->id }}">{{ $item->pegawai->nama }}</option>
                            @endforeach
                        </select>
                    </div>

                </div>
              
                <div class="modal-footer text-right">
                    <button type="button" data-dismiss="modal"
                        class="btn btn-outline-secondary w-20 mr-1">Cancel</button>
                    <button type="submit" class="btn btn-primary w-20">Send</button>
                </div>
                </form>
              
            </div>
        </div>
    </div>
@endsection
