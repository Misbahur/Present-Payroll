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
                    <h2 class="text-lg font-medium truncate mr-5">Pola Kerja Karyawan</h2>
                    <a href="javascript:;" data-toggle="modal" data-target="#header-footer-modal-preview"
                        class="btn btn-primary shadow-md mr-2">Tambah Pola Kerja</a>
                    <div class="flex items-center sm:ml-auto mt-3 sm:mt-0">
                        <!-- <button class="btn box flex items-center text-gray-700 dark:text-gray-300">
                            <i data-feather="file-text" class="hidden sm:block w-4 h-4 mr-2"></i> Export to Excel
                        </button>
                        <button class="ml-3 btn box flex items-center text-gray-700 dark:text-gray-300">
                            <i data-feather="file-text" class="hidden sm:block w-4 h-4 mr-2"></i> Export to PDF
                        </button> -->
                    </div>
                </div>
                <div class="intro-y overflow-auto lg:overflow-visible mt-8 sm:mt-0">
                    <table class="table table-report sm:mt-2">
                        <thead>
                            <tr>
                                <th class="whitespace-nowrap">ID</th>
                                <th class="text-center whitespace-nowrap">Jadwal</th>
                                <th class="text-center whitespace-nowrap">Jam Masuk</th>
                                <th class="text-center whitespace-nowrap">Jam Istirahat</th>
                                <th class="text-center whitespace-nowrap">Jam Istirahat Masuk</th>
                                <th class="text-center whitespace-nowrap">Jam Pulang</th>
                                <th class="text-center whitespace-nowrap">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($polas as $item)
                                <tr class="intro-x">
                                    <td class="w-40">
                                        {{ $item->id }}
                                    </td>
                                    <td class="text-center">
                                        <a href="#"
                                            class="font-medium whitespace-nowrap">{{ $item->nama }}</a>
                                    </td>
                                    <td class="w-40 text-center">
                                        {{ $item->jam_masuk }}
                                    </td>
                                    <td class="w-40 text-center">
                                        {{ $item->jam_istirahat }}
                                    </td>
                                    <td class="w-40 text-center">
                                        {{ $item->jam_istirahat_masuk }}
                                    </td>
                                    <td class="w-40 text-center">
                                        {{ $item->jam_pulang }}
                                    </td>
                                    <td class="table-report__action w-56">
                                            <div class="flex justify-center items-center">
                                                <a class="flex items-center mr-3 pola-edit" href="javascript:void(0)" data-toggle="modal" 
                                                id="{{ $item->id }}" data-target="#header-footer-modal-preview-edit" data-id="{{ $item->id }}">
                                                    <i data-feather="check-square" class="w-4 h-4 mr-1"></i> Edit 
                                                </a>
                                                <a class="flex items-center text-theme-6" href="/polakerjadelete/{{$item->id}}" onclick="return confirm('Apakah Anda Yakin Menghapus Data?');">
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
                    <ul class="pagination">
                        <li>
                            <a class="pagination__link" href="">
                                <i class="w-4 h-4" data-feather="chevrons-left"></i>
                            </a>
                        </li>
                        <li>
                            <a class="pagination__link" href="">
                                <i class="w-4 h-4" data-feather="chevron-left"></i>
                            </a>
                        </li>
                        <li>
                            <a class="pagination__link" href="">...</a>
                        </li>
                        <li>
                            <a class="pagination__link" href="">1</a>
                        </li>
                        <li>
                            <a class="pagination__link pagination__link--active" href="">2</a>
                        </li>
                        <li>
                            <a class="pagination__link" href="">3</a>
                        </li>
                        <li>
                            <a class="pagination__link" href="">...</a>
                        </li>
                        <li>
                            <a class="pagination__link" href="">
                                <i class="w-4 h-4" data-feather="chevron-right"></i>
                            </a>
                        </li>
                        <li>
                            <a class="pagination__link" href="">
                                <i class="w-4 h-4" data-feather="chevrons-right"></i>
                            </a>
                        </li>
                    </ul>
                    <select class="w-20 form-select box mt-3 sm:mt-0">
                        <option>10</option>
                        <option>25</option>
                        <option>35</option>
                        <option>50</option>
                    </select>
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
                <form method="POST" action="{{ route('polakerjaadd') }}">
                    @csrf
                <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                    <div class="col-span-12 sm:col-span-12">
                        <label for="modal-form-1" class="form-label">Nama Jadwal</label>
                        <input id="modal-form-1" name="nama" type="text" class="form-control" placeholder="Pagi atau Sore atau yang lain deh .......">
                    </div>
                    <div class="col-span-12 sm:col-span-12">
                        <label for="modal-form-2" class="form-label">Jam Masuk</label>
                        <input id="modal-form-2" name="jam_masuk" type="time" class="form-control" placeholder="">
                    </div>
                     <div class="col-span-12 sm:col-span-6">
                        <label for="modal-form-3" class="form-label">Jam Istirahat</label>
                        <input id="modal-form-3" name="jam_istirahat" type="time" class="form-control" placeholder="">
                    </div>
                     <div class="col-span-12 sm:col-span-6">
                        <label for="modal-form-4" class="form-label">Jam Istirahat Masuk</label>
                        <input id="modal-form-4" name="jam_istirahat_masuk" type="time" class="form-control" placeholder="">
                    </div>
                    <div class="col-span-12 sm:col-span-12">
                        <label for="modal-form-5" class="form-label">Jam Pulang</label>
                        <input id="modal-form-5" name="jam_pulang" type="time" class="form-control" placeholder="">
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
                    <h2 class="font-medium text-base mr-auto">Ubah Pola Kerja</h2>
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
                <form method="POST" action="{{ route('polakerjaupdate') }}">
                <input type="hidden" name="id" id="modal-update-id">
                    @csrf
                    <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                    <div class="col-span-12 sm:col-span-12">
                        <label for="modal-form-1-edit" class="form-label">Nama Jadwal</label>
                        <input id="modal-form-1-edit" name="nama" type="text" class="form-control" placeholder="Pagi atau Sore atau yang lain deh .......">
                    </div>
                    <div class="col-span-12 sm:col-span-12">
                        <label for="modal-form-2-edit" class="form-label">Jam Masuk</label>
                        <input id="modal-form-2-edit" name="jam_masuk" type="time" class="form-control" placeholder="">
                    </div>
                     <div class="col-span-12 sm:col-span-6">
                        <label for="modal-form-3-edit" class="form-label">Jam Istirahat</label>
                        <input id="modal-form-3-edit" name="jam_istirahat" type="time" class="form-control" placeholder="">
                    </div>
                     <div class="col-span-12 sm:col-span-6">
                        <label for="modal-form-4-edit" class="form-label">Jam Istirahat Masuk</label>
                        <input id="modal-form-4-edit" name="jam_istirahat_masuk" type="time" class="form-control" placeholder="">
                    </div>
                    <div class="col-span-12 sm:col-span-12">
                        <label for="modal-form-5-edit" class="form-label">Jam Pulang</label>
                        <input id="modal-form-5-edit" name="jam_pulang" type="time" class="form-control" placeholder="">
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
                
                $('.pola-edit').on('click',function() {
                    var id = $(this).attr('data-id');

                    $.ajax({
                        url : "{{route('polakerjaedit')}}?id="+id,
                        type: "GET",
                        dataType: "JSON",
                        success: function(data)
                        {
                            $('#modal-update-id').val(data.id);
                            $('#modal-form-1-edit').val(data.nama);
                            $('#modal-form-2-edit').val(data.jam_masuk);
                            $('#modal-form-3-edit').val(data.jam_istirahat);
                            $('#modal-form-4-edit').val(data.jam_istirahat_masuk);
                            $('#modal-form-5-edit').val(data.jam_pulang);

                            // $('#header-footer-modal-preview-edit').modal('show');

                        }
                    });
                });
            });
        </script>

</div>
@endsection
