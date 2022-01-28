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
                    <h2 class="font-medium text-base mr-auto">Data Karyawan</h2>
                </div>
                <table class="table">
                    <tr>
                        <th>NAMA</th>
                        <td>:</td>
                        <td>{{ $pegawai->pegawai->nama }}</td>
                    </tr>
                    <tr>
                        <th>JABATAN</th>
                        <td>:</td>
                        <td>{{ $pegawai->jabatan->nama }}</td>
                    </tr>
                </table>
            </div>
            <div class="intro-y box p-5 bg-theme-9 text-white mt-5">
                <div class="flex items-center">
                    <div class="font-medium text-lg">Peringatan</div>
                    <div class="text-xs bg-white dark:bg-theme-1 dark:text-white text-gray-800 px-1 rounded-md ml-auto">:)</div>
                </div>
                <div class="mt-4">Padaha halaman ini admin dapat menyesuaikan kembali penghasilan dan potongan yang akan di dapat oleh pegawai</div>
                <div class="font-medium flex mt-5">
                    <button type="button" class="btn py-1 px-2 border-white text-white dark:border-gray-700 dark:text-gray-300">Oke</button>
                </div>
            </div>
        </div>
        <!-- END: Profile Menu -->
        <div class="col-span-12 lg:col-span-8 xxl:col-span-9">
            <div class="grid grid-cols-12 gap-6">
                <!-- BEGIN: Daily Sales -->
                <div class="intro-y box col-span-12 xxl:col-span-12">
                    <div class="flex items-center px-5 py-5 sm:py-3 border-b border-gray-200 dark:border-dark-5">
                        <h2 class="font-medium text-base mr-auto">Data gaji</h2>
                        <div class="dropdown ml-auto">
                            <a class="dropdown-toggle btn btn-primary" href="javascript:;" aria-expanded="false" data-toggle="modal" data-target="#header-footer-modal-preview">
                                + Tambah Bonus / Potongan
                            </a>
                        </div>
                    </div>
                    <div class="overflow-x-auto px-4 py-2">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="border-b-2 dark:border-dark-5 whitespace-nowrap">#</th>
                                    <th class="border-b-2 dark:border-dark-5 whitespace-nowrap">Nama / Keterangan</th>
                                    <th class="border-b-2 dark:border-dark-5 whitespace-nowrap">Nominal</th>
                                    <th class="border-b-2 dark:border-dark-5 whitespace-nowrap">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($detail_gajis as $key=>$item)                                    
                                <tr>
                                    <td class="border-b dark:border-dark-5">{{ ++$key }}</td>
                                    <td class="border-b dark:border-dark-5">{{ $item->keterangan }}</td>
                                    <td class="border-b dark:border-dark-5">{{ $item->nominal }}</td>
                                    <td class="border-b dark:border-dark-5">
                                        <a href="{{ route('hapusbonuspotongan', $item->id) }}" class="btn btn-danger w-24 inline-block mr-1 mb-2">
                                            <i data-feather="trash" class="w-4 h-4 mr-2"></i>Hapus</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <a href="{{ route('penggajian') }}" class="btn btn-secondary flex my-4 ">Kembali list Penggajian</a>
                    </div>
                </div>
                <!-- END: Daily Sales -->
            </div>
        </div>

        <!-- BEGIN: Modal Content -->
        <div id="header-footer-modal-preview" class="modal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <!-- BEGIN: Modal Header -->
                    <div class="modal-header">
                        <h2 class="font-medium text-base mr-auto">Tambah item</h2>
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
                    <form method="POST" action="{{ route('tambahbonuspotongan') }}">
                        @csrf
                    <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                        <div class="col-span-12 sm:col-span-12">
                            <label for="modal-form-1" class="form-label">Keterangan</label>
                            <input id="modal-form-1" name="keterangan" type="text" class="form-control" placeholder="Keterangan tambahan">
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
                        <input type="hidden" name="penggajian_id" value="{{ $id }}">
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
@endsection
