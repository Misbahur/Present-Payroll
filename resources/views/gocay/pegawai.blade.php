@extends('../layout/' . $layout)

@section('subhead')
    <title>Sistem Present & Payrol Gocay</title>
@endsection

@section('subcontent')
    <div class="grid grid-cols-12 gap-6">
        <div class="col-span-12 xxl:col-span-9">
            <div class="grid grid-cols-12 gap-6">
                <!-- BEGIN: Weekly Top Products -->
                <div class="col-span-12 mt-6">
                    <div class="intro-y block sm:flex items-center h-10">
                        <h2 class="text-lg font-medium truncate mr-5">Daftar item</h2>
                        <a href="javascript:;" data-toggle="modal" data-target="#header-footer-modal-preview"
                        class="btn btn-primary shadow-md mr-2">Tambah Pegawai</a>
                        <div class="flex items-center sm:ml-auto mt-3 sm:mt-0">
                            <!-- <button class="btn box flex items-center text-gray-700 dark:text-gray-300">
                                <i data-feather="file-text" class="hidden sm:block w-4 h-4 mr-2"></i> Export to Excel
                            </button>
                            <button class="ml-3 btn box flex items-center text-gray-700 dark:text-gray-300">
                                <i data-feather="file-text" class="hidden sm:block w-4 h-4 mr-2"></i> Export to PDF
                            </button> -->
                        </div>
                    </div>
                    <div class="intro-y overflow-auto mt-8 sm:mt-0">
                        <table class="table table-report sm:mt-2">
                            <thead>
                                <tr>
                                    <th class="text-center whitespace-nowrap">No</th>
                                    <th class="text-center whitespace-nowrap">NIK</th>
                                    <th class="text-center whitespace-nowrap">Nama Pegawai</th>
                                    <th class="text-center whitespace-nowrap">Jabatan</th>
                                    <th class="text-center whitespace-nowrap">Tanggal Lahir</th>
                                    <th class="text-center whitespace-nowrap">Alamat</th>
                                    <th class="text-center whitespace-nowrap">No HP</th>
                                    <th class="text-center whitespace-nowrap">Tanggal Masuk</th>
                                    <th class="text-center whitespace-nowrap">Bank</th>
                                    <th class="text-center whitespace-nowrap">No. Rekening</th>
                                    <th class="text-center whitespace-nowrap">Email</th>
                                    <th class="text-center whitespace-nowrap">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pegawais as $item)
                                    <tr class="intro-x">
                                        <td class="w-40">
                                        {{ ++ $i }}
                                        </td>
                                        <td class="text-center">
                                            <a href="" class="font-medium whitespace-nowrap">{{ $item->nik }}</a>
                                        </td>
                                        <td class="text-center">
                                            <a href="" class="font-medium whitespace-nowrap">{{ $item->nama }}</a>
                                        </td>
                                        <td class="text-center">
                                            <a href="" class="font-medium whitespace-nowrap">{{ $item->jabatan->nama }}</a>
                                        </td>
                                        <td class="text-center">
                                            <a href="" class="font-medium whitespace-nowrap">{{ date('d-m-Y', strtotime($item->tanggal_lahir)) }}</a>
                                        </td>
                                        <td class="text-center">
                                            <a href="" class="font-medium whitespace-nowrap">{{ $item->alamat }}</a>
                                        </td>
                                        <td class="text-center">
                                            <a href="" class="font-medium whitespace-nowrap">{{ $item->nohp }}</a>
                                        </td>
                                        <td class="text-center">
                                            <a href="" class="font-medium whitespace-nowrap">{{ date('d-m-Y', strtotime($item->tanggal_masuk)) }}</a>
                                        </td>
                                        <td class="text-center">
                                            <a href="" class="font-medium whitespace-nowrap">{{ $item->bank_id != null ? $item->bank->nama : '' }}</a>
                                        </td>
                                        <td class="text-center">
                                            <a href="" class="font-medium whitespace-nowrap">{{ $item->no_rek }}</a>
                                        </td>
                                        <td class="text-center">
                                            <a href="" class="font-medium whitespace-nowrap">{{ $item->atas_nama }}</a>
                                        </td> 
                                        <td class="table-report__action w-56">
                                            <div class="flex justify-center items-center">
                                                <a class="flex items-center mr-3 pegawai-edit" href="javascript:void(0)" data-toggle="modal" 
                                                id="{{ $item->id }}" data-target="#header-footer-modal-preview-edit" data-id="{{ $item->id }}">
                                                    <i data-feather="check-square" class="w-4 h-4 mr-1"></i> Edit 
                                                </a>
                                                <a class="flex items-center text-theme-6" href="/pegawaidelete/{{$item->id}}" onclick="return confirm('Apakah Anda Yakin Menghapus Data?');">
                                                    <i data-feather="trash-2" class="w-4 h-4 mr-1"></i> Delete
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="intro-y flex flex-wrap sm:flex-row sm:flex-nowrap items-center mt-3">
                        <div class="pagination">
                                {{ $pegawais->appends($data_request)->links() }}
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
                    <form method="POST" action="{{ route('pegawaiadd') }}">
                        @csrf
                    <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                        
                        <div class="col-span-12 sm:col-span-12">
                            <label for="modal-form-1" class="form-label">Nama Pegawai</label>
                            <input id="modal-form-1" name="nama" type="text" class="form-control" placeholder="Nama Pegawai">
                        </div>
                        <div class="col-span-12 sm:col-span-12">
                            <label for="modal-form-2" class="form-label">Jabatan</label>
                            <select id="modal-form-2" class="form-select" name="jabatan_id">
                            @foreach ($jabatans as $item)
                                <option value="{{ $item->id }}">{{ $item->nama }}</option>
                            @endforeach
                            </select>
                        </div>
                        <div class="col-span-12 sm:col-span-12">
                            <label for="modal-form-3" class="form-label">NIK Pegawai</label>
                            <input id="modal-form-3" name="nik" type="number" class="form-control" placeholder="NIK Pegawai">
                        </div>
                        <div class="col-span-12 sm:col-span-12">
                            <label for="modal-form-4" class="form-label">Tanggal Lahir Pegawai</label>
                            <input id="modal-form-4" name="tanggal_lahir" type="date" class="form-control" placeholder="Tanggal Lahir Pegawai">
                        </div>
                        <div class="col-span-12 sm:col-span-12">
                            <label for="modal-form-5" class="form-label">Tanggal Masuk Pegawai</label>
                            <input id="modal-form-5" name="tanggal_masuk" type="date" class="form-control" placeholder="Tanggal Masuk Pegawai">
                        </div>
                        <div class="col-span-12 sm:col-span-12">
                            <label for="modal-form-6" class="form-label">Alamat Pegawai</label>
                            <input id="modal-form-6" name="alamat" type="text" class="form-control" placeholder="Alamat Pegawai">
                        </div>
                        <div class="col-span-12 sm:col-span-12">
                            <label for="modal-form-7" class="form-label">Nomor HP Pegawai</label>
                            <input id="modal-form-7" name="nohp" type="text" class="form-control" placeholder="No HP Pegawai">
                        </div>
                        <div class="col-span-12 sm:col-span-12">
                            <label for="modal-form-8" class="form-label">Bank</label>
                            <select id="modal-form-8" class="form-select" name="bank_id">
                                @foreach ($bank as $item)
                                <option value="{{ $item->id }}">{{ strtoupper($item->nama) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-span-12 sm:col-span-12">
                            <label for="modal-form-9" class="form-label">Nomor Rekening Pegawai</label>
                            <input id="modal-form-9" name="no_rek" type="number" class="form-control" placeholder="No Rekening Pegawai">
                        </div>
                        <div class="col-span-12 sm:col-span-12">
                            <label for="modal-form-10" class="form-label">Email</label>
                            <input id="modal-form-10" name="atas_nama" type="Email" class="form-control" placeholder="Email ya Guys ya">
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
        
        <!-- BEGIN: Modal Content -->
        <div id="header-footer-modal-preview-edit" class="modal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <!-- BEGIN: Modal Header -->
                    <div class="modal-header">
                        <h2 class="font-medium text-base mr-auto">Update Pegawai</h2>
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
                    <form method="POST" action="{{ route('pegawaiupdate') }}">
                    <input type="hidden" name="id" id="modal-update-id">
                        @csrf
                    <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                        <div class="col-span-12 sm:col-span-12">
                            <label for="modal-form-1" class="form-label">Nama Pegawai</label>
                            <input id="modal-form-1-edit" name="nama" type="text" class="form-control" placeholder="Nama Pegawai">
                        </div>
                        <div class="col-span-12 sm:col-span-12">
                            <label for="modal-form-2" class="form-label">Jabatan</label>
                            <select id="modal-form-2-edit" class="form-select" name="jabatan_id">
                            @foreach ($jabatans as $item)
                                <option value="{{ $item->id }}">{{ $item->nama }}</option>
                            @endforeach
                            </select>
                        </div>
                        <div class="col-span-12 sm:col-span-12">
                            <label for="modal-form-3" class="form-label">NIK Pegawai</label>
                            <input id="modal-form-3-edit" name="nik" type="number" class="form-control" placeholder="NIK Pegawai">
                        </div>
                        <div class="col-span-12 sm:col-span-12">
                            <label for="modal-form-4" class="form-label">Tanggal Lahir Pegawai</label>
                            <input id="modal-form-4-edit" name="tanggal_lahir" type="date" class="form-control" placeholder="Tanggal Lahir Pegawai">
                        </div>
                        <div class="col-span-12 sm:col-span-12">
                            <label for="modal-form-5" class="form-label">Tanggal Masuk Pegawai</label>
                            <input id="modal-form-5-edit" name="tanggal_masuk" type="date" class="form-control" placeholder="Tanggal Masuk Pegawai">
                        </div>
                        <div class="col-span-12 sm:col-span-12">
                            <label for="modal-form-6" class="form-label">Alamat Pegawai</label>
                            <input id="modal-form-6-edit" name="alamat" type="text" class="form-control" placeholder="Alamat Pegawai">
                        </div>
                        <div class="col-span-12 sm:col-span-12">
                            <label for="modal-form-7" class="form-label">Nomor HP Pegawai</label>
                            <input id="modal-form-7-edit" name="nohp" type="text" class="form-control" placeholder="No HP Pegawai">
                        </div>
                        <div class="col-span-12 sm:col-span-12">
                            <label for="modal-form-2" class="form-label">Bank</label>
                            <select id="modal-form-2-edit" class="form-select" name="bank_id">
                                @foreach ($bank as $item)
                                <option value="{{ $item->id }}">{{ strtoupper($item->nama) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-span-12 sm:col-span-12">
                            <label for="modal-form-9" class="form-label">Nomor Rekening Pegawai</label>
                            <input id="modal-form-9-edit" name="no_rek" type="number" class="form-control" placeholder="No Rekening Pegawai">
                        </div>
                        <div class="col-span-12 sm:col-span-12">
                            <label for="modal-form-10" class="form-label">Email</label>
                            <input id="modal-form-10-edit" name="atas_nama" type="email" class="form-control" placeholder="Email ya Boss ya">
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
        
        <script type="text/javascript">
            $(document).ready(function() {
                //edit data
                
                $('.pegawai-edit').on('click',function() {
                    var id = $(this).attr('data-id');

                    $.ajax({
                        url : "{{route('pegawaiedit')}}?id="+id,
                        type: "GET",
                        dataType: "JSON",
                        success: function(data)
                        {
                            $('#modal-update-id').val(data.id);
                            $('#modal-form-1-edit').val(data.nama);
                            $('#modal-form-2-edit option[value="' + data.jabatan_id +'"]').prop("selected", true);
                            $('#modal-form-3-edit').val(data.nik);
                            $('#modal-form-4-edit').val(data.tanggal_lahir);
                            $('#modal-form-5-edit').val(data.tanggal_masuk);
                            $('#modal-form-6-edit').val(data.alamat);
                            $('#modal-form-7-edit').val(data.nohp);
                            $('#modal-form-8-edit option[value="' + data.bank_id +'"]').prop("selected", true);
                            // $('#modal-form-8-edit').val(data.bank_id);
                            $('#modal-form-9-edit').val(data.no_rek);
                            $('#modal-form-10-edit').val(data.atas_nama);

                            // $('#header-footer-modal-preview-edit').modal('show');

                        }
                    });
                });
            });
        </script>

    </div>
@endsection
