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
                        <h2 class="text-lg font-medium truncate mr-5">Modul Fingerprint</h2>
                        <!-- <a href="javascript:;" data-toggle="modal" data-target="#header-footer-modal-preview"
                        class="btn btn-primary shadow-md mr-5">Tambah Pegawai</a> -->
                        <!-- <a href="{{ route('cekUserFingerprint') }}" class="btn btn-success ml-auto flex items-center">
                            <i data-feather="refresh-cw" class="hidden sm:block  mr-2"></i> Get Data User
                        </a>
                        <a href="{{ route('deleteAllUserFingerptint') }}" class="btn btn-warning ml-auto flex items-center">
                            <i data-feather="alert-octagon" class="hidden sm:block  mr-2"></i> Delete All Data User
                        </a>
                        <a href="{{ route('deleteAllLogFingerptint') }}" class="btn btn-danger ml-auto flex items-center">
                            <i data-feather="alert-triangle" class="hidden sm:block  mr-2"></i> Delete All Data Kehadiran
                        </a> -->
                    </div>
                </div>
                <!-- END: General Report -->

                <!-- BEGIN: Weekly Top Products -->
                <div class="col-span-12 mt-6">
                    <div class="intro-y block sm:flex items-center h-10">
                        <h2 class="text-lg font-medium truncate mr-5">Data Fingerprint</h2>
                        <div class="flex items-center sm:ml-auto mt-3 sm:mt-0">
                            <!-- <button class="btn box flex items-center text-gray-700 dark:text-gray-300">
                                <i data-feather="file-text" class="hidden sm:block w-4 h-4 mr-2"></i> Export to Excel
                            </button>
                            <button class="ml-3 btn box flex items-center text-gray-700 dark:text-gray-300">
                                <i data-feather="file-text" class="hidden sm:block w-4 h-4 mr-2"></i> Export to PDF
                            </button> -->
                            <a href="{{ route('addPegawaiToFingerprint') }}" class="btn btn-sm btn-primary ml-3 flex items-center" onclick="return confirm('Apakah Anda Yakin Menambahkan Data?');">
                                <i data-feather="user-plus" class="hidden sm:block  mr-2"></i> Add Pegawai to Fingerprint
                            </a>
                            <!-- <a href="javascript:;" data-toggle="modal" data-target="#header-footer-modal-preview" class="btn btn-sm btn-primary ml-3 flex items-center" onclick="return confirm('Apakah Anda Yakin Menambahkan Data?');">
                                <i data-feather="plus" class="hidden sm:block  mr-2"></i> Update Time </a> -->
                            <a href="{{ route('cekDataFingerprint') }}" class="btn btn-sm btn-primary ml-3 flex items-center">
                                <i data-feather="bar-chart-2" class="hidden sm:block  mr-2"></i> Get Data Fingerprint
                            </a>
                            <a href="{{ route('cekUserFingerprint') }}" class="btn btn-sm btn-success ml-3 flex items-center">
                                <i data-feather="users" class="hidden sm:block  mr-2"></i> Get Data User
                            </a>
                            <!-- <a href="{{ route('deleteAllUserFingerptint') }}" class="btn btn-sm btn-warning ml-3 flex items-center" onclick="return confirm('Apakah Anda Yakin Menghapus Data?');" >
                                <i data-feather="alert-octagon" class="hidden sm:block  mr-2"></i> Delete All Data User
                            </a>
                            <a href="{{ route('deleteAllLogFingerptint') }}" class="btn btn-sm btn-danger ml-3 flex items-center" onclick="return confirm('Apakah Anda Yakin Menghapus Data?');" >
                                <i data-feather="alert-triangle" class="hidden sm:block  mr-2"></i> Delete All Data Kehadiran
                            </a> -->
                        </div>
                    </div>
                </div>
                <!-- END: Weekly Top Products -->
                
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
                    <!-- <form method="POST" action="{{ route('updateFingerData') }}"> -->
                    <form method="POST" action="{{ route('updateFingerData') }}">
                        @csrf
                    <input id="modal-form-1" name="pegawai_id" type="hidden" value="1" class="form-control" placeholder="Nama Pegawai">
                    <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                        <!-- <div class="col-span-12 sm:col-span-12">
                            <label for="modal-form-1" class="form-label">Nama Pegawai</label>
                            <input id="modal-form-1" name="nama" type="text" class="form-control" placeholder="Nama Pegawai">
                        </div> -->
                        <div class="col-span-12 sm:col-span-12">
                            <label for="modal-form-1" class="form-label">Waktu</label>
                            <input id="modal-form-1" name="time" type="time" class="form-control" placeholder="Nama Pegawai">
                        </div>
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
        
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        
    </div>

    
@endsection
