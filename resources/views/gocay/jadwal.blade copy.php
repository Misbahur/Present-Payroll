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
                    <h2 class="text-lg font-medium truncate mr-5">Daftar Jadwal Karyawan</h2>
                    <a href="javascript:;" data-toggle="modal" data-target="#header-footer-modal-preview"
                        class="btn btn-primary shadow-md mr-2">Tambah Jadwal</a>
                    <div class="flex items-center sm:ml-auto mt-3 sm:mt-0">
                            <form method="get" action="{{ route('filter-jadwal') }}">
                                @csrf
                                <div class="flex items-center text-gray-700 dark:text-gray-300 mr-2 w-1\/2">
                                    <input type="text" name="filter_nama" class="form-control w-44 mr-2" placeholder="Nama Pegawai" autofocus value="{{Request::old('filter_nama')}}">
                                    <select class="form-select w-15 mr-2" name="filter_tanggal">
                                        @for ($x=0; $x < date('t'); $x++)
                                            <option value="{{ $x+1 }}" {{ $x+1 == date('j') ? 'selected' : '' }}>
                                                {{ $x+1 == date('j') ? date('j') : $x+1 }}
                                            </option>
                                        @endfor
                                    </select>
                                
                                    <select class="form-select w-32 mr-2" name="filter_bulan">
                                        @for ($x=0; $x < count($bulan); $x++)
                                            <option value="{{ $x+1 }}" {{ $x+1 == date('m') ? 'selected' : '' }}>
                                                {{ $x+1 == date('m') ? $bulan[date('m')-1] : $bulan[$x] }}
                                            </option>
                                        @endfor
                                    </select>
                                    <button type='submit' class="btn btn-primary flex items-center search">
                                        <i data-feather="search" class="hidden sm:block w-4 h-4"></i>
                                    </button>
                                </div>
                            </form>
                            <a href="{{ route('jadwal') }}" class="btn btn-success flex items-center">
                                <i data-feather="refresh-cw" class="hidden sm:block w-4 h-4"></i>
                            </a>
                            <!-- <button class="ml-3 btn box flex items-center text-gray-700 dark:text-gray-300">
                                <i data-feather="file-text" class="hidden sm:block w-4 h-4 mr-2"></i> Export to PDF
                            </button> -->
                        </div>
                </div>
                <div class="intro-y overflow-auto lg:overflow-visible mt-8 sm:mt-0">
                    @if ($jadwals != null)
                    <table class="table table-report sm:mt-2">
                        <thead>
                            <tr>
                                <th class="text-center whitespace-nowrap">No</th>
                                <th class="text-center whitespace-nowrap">Tanggal</th>
                                <th class="text-center whitespace-nowrap">Shift</th>
                                <th class="text-center whitespace-nowrap">Nama Pegawai</th>
                                <th class="text-center whitespace-nowrap">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($jadwals as $item)
                                <tr class="intro-x">
                                    <td class="w-40">
                                    {{ ++ $i}}
                                    </td>
                                    <td class="text-center">
                                        <a href="" class="font-medium whitespace-nowrap">{{ $item->tanggal }}</a>
                                    </td>
                                    <td class="text-center">
                                        <a href="" class="font-medium whitespace-nowrap">{{ $item->pola->nama }}</a>
                                    </td>
                                    <td class="text-center">
                                        <a href="" class="font-medium whitespace-nowrap">
                                            {{ $item->pegawai->nama }}
                                        </a>
                                    </td>
                                    <td class="table-report__action w-56">
                                            <div class="flex justify-center items-center">
                                                <a class="flex items-center mr-3 jadwaledit" href="javascript:void(0)" data-toggle="modal" 
                                                id="{{ $item->id }}" data-target="#header-footer-modal-preview-edit" data-id="{{ $item->id }}">
                                                    <i data-feather="check-square" class="w-4 h-4 mr-1"></i> Edit 
                                                </a>
                                                <a class="flex items-center text-theme-6" href="/jadwaldelete/{{$item->id}}" onclick="return confirm('Apakah Anda Yakin Menghapus Data?');">
                                                    <i data-feather="trash-2" class="w-4 h-4 mr-1"></i> Delete
                                                </a>
                                            </div>
                                        </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @else
                        <div class="text-center mt-10">
                            <button class="btn btn-danger text-center w-full">
                                    Data Tidak Ditemukan
                            </button>
                        </div>
                        @endif
                </div>
                <div class="intro-y flex flex-wrap sm:flex-row sm:flex-nowrap items-center mt-3">
                        <div class="pagination">
                        @if ($jadwals != null)
                            {{ $jadwals->appends($data_request)->links() }}
                        @else

                        @endif
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
                    <h2 class="font-medium text-base mr-auto">Tambah Kelompok Kerja</h2>
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
                <form method="POST" action="{{ route('jadwaladd') }}">
                        @csrf
                <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                    <div class="col-span-12 sm:col-span-12">
                        <label for="modal-form-1" class="form-label">Tanggal</label>
                        <!-- <input id="modal-form-1" name="tanggal" type="date" class="form-control" placeholder="Kelompok Hore.,..."> -->
                        <input id="modal-form-1" name="tanggal" data-daterange="true" class="datepicker form-control w-56 block mx-auto">

                    </div>
                    <div class="col-span-12 sm:col-span-12">
                        <label for="modal-form-2" class="form-label">Pola Kerja</label>
                        <select id="modal-form-2" class="form-select" name="pola_id">
                        @foreach ($pola as $item)
                            <option value="{{ $item->id }}">{{ $item->nama }}</option>
                        @endforeach
                        </select>
                    </div>
                    
                    <div class="col-span-12 sm:col-span-12">
                        <label for="modal-form-3" class="form-label">Pegawai</label>
                        <select name="pegawai_id"  class="form-select" id="modal-form-3">
                            @foreach ($pegawais as $item)
                                <option value="{{ $item->id }}">{{ $item->nama }}</option>
                            @endforeach
                        </select>
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
                    <h2 class="font-medium text-base mr-auto">Update Jadwal</h2>
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
                <form method="POST" action="{{ route('jadwalupdate') }}">
                <input type="hidden" name="id" id="modal-update-id">
                        @csrf
                <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                    <div class="col-span-12 sm:col-span-12">
                        <label for="modal-form-1" class="form-label">Tanggal</label>
                        <input id="tanggal-edit" name="tanggal" type="hidden" class="form-control">
                        <input id="modal-form-1-edit"  type="date" class="form-control" disabled>
                        <!-- <input id="modal-form-1-edit" name="tanggal" data-daterange="true" class="datepicker form-control w-56 block mx-auto"> -->

                    </div>
                    <div class="col-span-12 sm:col-span-12">
                        <label for="modal-form-2" class="form-label">Pola Kerja</label>
                        <select id="modal-form-2-edit" class="form-select" name="pola_id">
                        @foreach ($pola as $item)
                            <option value="{{ $item->id }}">{{ $item->nama }}</option>
                        @endforeach
                        </select>
                    </div>
                    
                    <div class="col-span-12 sm:col-span-12">
                        <label for="modal-form-3" class="form-label">Pegawai</label>
                        <input id="pegawai-id-edit" name="pegawai_id" type="hidden" class="form-control">
                        <select class="form-select" id="modal-form-3-edit" disabled>
                            @foreach ($pegawais as $item)
                                <option value="{{ $item->id }}">{{ $item->nama }}</option>
                            @endforeach
                        </select>
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
        <script type="text/javascript">
            $(document).ready(function() {

                // $('#modal-form-1').val(new Date().toDateInputValue());
                
                $('.jadwaledit').on('click',function() {
                    var id = $(this).attr('data-id');

                    $.ajax({
                        url : "{{route('jadwaledit')}}?id="+id,
                        type: "GET",
                        dataType: "JSON",
                        success: function(data)
                        {

                            $('#modal-update-id').val(data.id);
                            $('#modal-form-1-edit').val(data.tanggal);
                            $('#tanggal-edit').val(data.tanggal);
                            $('#modal-form-2-edit option[value="' + data.pola_id +'"]').prop("selected", true);
                            $('#modal-form-3-edit').val(data.pegawai_id);
                            $('#pegawai-id-edit').val(data.pegawai_id);


                        }
                    });
                });
            });
        </script>


</div>
@endsection
