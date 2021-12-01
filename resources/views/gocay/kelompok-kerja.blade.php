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
                    <h2 class="text-lg font-medium truncate mr-5">Daftar Kelompok Karyawan</h2>
                    <a href="javascript:;" data-toggle="modal" data-target="#header-footer-modal-preview"
                        class="btn btn-primary shadow-md mr-2">Tambah Kelompok</a>
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
                                <th class="whitespace-nowrap">Nama Kelompok</th>
                                <th class="text-center whitespace-nowrap">Shift</th>
                                <th class="text-center whitespace-nowrap">Nama Pegawai</th>
                                <th class="text-center whitespace-nowrap">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; ?>
                            @foreach ($kelompok_kerja as $item)
                                <tr class="intro-x">
                                    <td class="w-40">
                                    {{ $no++ }}
                                    </td>
                                    <td class="text-center">
                                        <a href="" class="font-medium whitespace-nowrap">{{ $item->nama }}</a>
                                    </td>
                                    <td class="text-center">
                                        <a href="" class="font-medium whitespace-nowrap">{{ $item->pola->nama }}</a>
                                    </td>
                                    <td class="text-center">
                                        <a href="" class="font-medium whitespace-nowrap">
                                            <?php 
                                                $pegawai_id = explode ('|', $item->pegawai_id);
                                            ?>
                                            @foreach ($pegawai_id as $id)
                                                @php 
                                                    $p = App\Http\Controllers\Kelompok_kerjaController::pegawai_name($id);
                                                    $pegawai_name = preg_replace("/[^a-zA-Z]/", "", $p);
                                                @endphp
                                                {{ $pegawai_name }} ,
                                            @endforeach
                                        </a>
                                    </td>
                                    <td class="table-report__action w-56">
                                            <div class="flex justify-center items-center">
                                                <a class="flex items-center mr-3 kelompok-kerja-edit" href="javascript:void(0)" data-toggle="modal" 
                                                id="{{ $item->id }}" data-target="#header-footer-modal-preview-edit" data-id="{{ $item->id }}">
                                                    <i data-feather="check-square" class="w-4 h-4 mr-1"></i> Edit 
                                                </a>
                                                <a class="flex items-center text-theme-6" href="/kelompok-kerjadelete/{{$item->id}}" onclick="return confirm('Apakah Anda Yakin Menghapus Data?');">
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
                <form method="POST" action="{{ route('kelompok-kerjaadd') }}">
                        @csrf
                <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                    <div class="col-span-12 sm:col-span-12">
                        <label for="modal-form-1" class="form-label">Nama Kelempok</label>
                        <input id="modal-form-1" name="nama" type="text" class="form-control" placeholder="Kelompok Hore.,...">
                    </div>
                    <div class="col-span-12 sm:col-span-12">
                        <label for="modal-form-2" class="form-label">Pola Kerja</label>
                        <select id="modal-form-2" class="form-select" name="pola_kerja_id">
                        @foreach ($pola as $item)
                            <option value="{{ $item->id }}">{{ $item->nama }}</option>
                        @endforeach
                        </select>
                    </div>
                    
                    <div class="col-span-12 sm:col-span-12">
                        <label for="modal-form-3" class="form-label">Pegawai</label>
                        <select name="pegawai_id[]" data-placeholder="Select your favorite actors" class="tail-select w-full" id="modal-form-3" multiple>
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
                    <h2 class="font-medium text-base mr-auto">Update Kelompok Kerja</h2>
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
                <form method="POST" action="{{ route('kelompok-kerjaupdate') }}">
                <input type="hidden" name="id" id="modal-update-id">
                        @csrf
                <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                    <div class="col-span-12 sm:col-span-12">
                        <label for="modal-form-1-edit" class="form-label">Nama Kelempok</label>
                        <input id="modal-form-1-edit" name="nama" type="text" class="form-control" placeholder="Kelompok Hore.,...">
                    </div>
                    <div class="col-span-12 sm:col-span-12">
                        <label for="modal-form-2-edit" class="form-label">Pola Kerja</label>
                        <select id="modal-form-2-edit" class="form-select" name="pola_kerja_id">
                        @foreach ($pola as $item)
                            <option value="{{ $item->id }}">{{ $item->nama }}</option>
                        @endforeach
                        </select>
                    </div>
                    
                    <div class="col-span-12 sm:col-span-12">
                        <label for="modal-form-3-edit" class="form-label">Pegawai</label>
                        <select name="pegawai_id[]" data-placeholder="Select your favorite actors" class="tail-select w-full" id="modal-form-3-edit" multiple required>
                            @foreach ($pegawais as $item)
                                <option value="{{$item->id}}">{{$item->nama}}</option>
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
                
                $('.kelompok-kerja-edit').on('click',function() {
                    var id = $(this).attr('data-id');

                    $.ajax({
                        url : "{{route('kelompok-kerjaedit')}}?id="+id,
                        type: "GET",
                        dataType: "JSON",
                        success: function(data)
                        {

                            $('#modal-update-id').val(data.id);
                            $('#modal-form-1-edit').val(data.nama);
                            $('#modal-form-2-edit').val(data.pola_kerja_id);
                            
                            var datapegawai = data.pegawai_id.split('|');
                            $.each(datapegawai, function(i,e){
                                // $("#modal-form-3-edit option[value='" + e + "']").prop("selected", true);
                                $('#modal-form-3-edit').find('option[value="'+ e +'"]').attr('Selected', 'Selected');
                                $("#modal-form-3-edit").trigger('chosen:updated');  
                                // $('.label-inner').hide();
                                // $('.select-label').append('<div class="select-handle" data-key="'+value+'" data-group="#">'+value+'</div>');

                                // $('.label-inner').replaceWith($('<div class="select-handle" data-key="'+e+'" data-group="#">'+e+'</div>'));
                            });
                           
                            

                        }
                    });
                });
            });
        </script>


</div>
@endsection
