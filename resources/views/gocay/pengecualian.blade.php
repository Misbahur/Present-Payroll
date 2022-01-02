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
                        class="btn btn-primary shadow-md mr-2">Tambah Data Pengecualian</a>
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
                                    <th class="whitespace-nowrap">No</th>
                                    <th class="text-center whitespace-nowrap">Nama Pegawai</th>
                                    <th class="text-center whitespace-nowrap">Jabatan</th>
                                    <th class="text-center whitespace-nowrap">Tanggal</th>
                                    <th class="text-center whitespace-nowrap">Keterangan</th>
                                    <th class="text-center whitespace-nowrap">Dokumen</th>
                                    <th class="text-center whitespace-nowrap">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                @foreach ($pengecualians as $item)
                                    <tr class="intro-x">
                                        <td class="w-40">
                                        {{ $no++; }}
                                        </td>
                                        <td class="text-center">
                                            <a href="" class="font-medium whitespace-nowrap">{{ $item->pegawai->nama }}</a>
                                        </td>
                                        <td class="text-center">
                                            <a href="" class="font-medium whitespace-nowrap">{{ $item->jabatan->nama }}</a>
                                        </td>
                                        <td class="text-center">
                                            <a href="" class="font-medium whitespace-nowrap">{{ date('d-m-Y', strtotime($item->tanggal)) }}</a>
                                        </td>
                                        <td class="text-center">
                                            <a href="" class="font-medium whitespace-nowrap">{{ $item->keterangan }}</a>
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ asset('storage/'.$item->dokumen) }}" class="font-medium whitespace-nowrap" target="blank">
                                                Lihat Dokumen
                                            </a>
                                        </td>
                                        <td class="table-report__action w-56">
                                            <div class="flex justify-center items-center">
                                                <a class="flex items-center mr-3 pengecualian-edit" href="javascript:void(0)" data-toggle="modal" 
                                                id="{{ $item->id }}" data-target="#header-footer-modal-preview-edit" data-id="{{ $item->id }}">
                                                    <i data-feather="check-square" class="w-4 h-4 mr-1"></i> Edit 
                                                </a>
                                                <a class="flex items-center text-theme-6" href="/pengecualiandelete/{{$item->id}}" onclick="return confirm('Apakah Anda Yakin Menghapus Data?');">
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
                        @if ($pengecualians != null)
                            {{ $pengecualians->appends($data_request)->links() }}
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
                    <form method="POST" enctype="multipart/form-data" action="{{ route('pengecualianadd') }}">
                    <input type="hidden" name="jabatan_id" id="jabatan_id_hidden">

                        @csrf
                    <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                        <div class="col-span-12 sm:col-span-12">
                            <label for="modal-form-1" class="form-label">Tanggal</label>
                            <input id="modal-form-1" name="tanggal" type="date" class="form-control" placeholder="Tanggal">
                        </div>
                        <div class="col-span-12 sm:col-span-12">
                            <label for="modal-form-2" class="form-label">Nama Pegawai</label>
                            <select id="modal-form-2" class="form-select" name="pegawai_id">
                            @foreach ($pegawais as $item)
                                <option value="{{ $item->id }}">{{ $item->nama }}</option>
                            @endforeach
                            </select>
                        </div>
                        <div class="col-span-12 sm:col-span-12">
                            <label for="modal-form-3" class="form-label">Jabatan</label>
                            <input id="modal-form-3" type="text" class="form-control"  disabled>
                        </div>
                        <div class="col-span-12 sm:col-span-12">
                            <label for="modal-form-4" class="form-label">Keterangan</label>
                            <textarea name="keterangan" id="modal-form-4" class="form-control" cols="30" rows="10" placeholder="Buat apa"></textarea>
                        </div>
                        <div class="col-span-12 sm:col-span-12">
                            <label for="modal-form-5" class="form-label">Dokumen</label>
                            <input id="modal-form-5" name="dokumen" type="file" class="form-control" placeholder="Sertakan dokumen/bukti">
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
                        <h2 class="font-medium text-base mr-auto">Update item</h2>
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
                    <form method="POST" enctype="multipart/form-data" action="{{ route('pengecualianupdate') }}">
                    <input type="hidden" name="id" id="modal-update-id">
                    
                        @csrf
                    <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                        <div class="col-span-12 sm:col-span-12">
                            <label for="modal-form-1-edit" class="form-label">Tanggal</label>
                            <input id="modal-form-1-edit" name="tanggal" type="date" class="form-control" placeholder="Tanggal">
                        </div>
                        <div class="col-span-12 sm:col-span-12">
                            <input type="hidden" name="pegawai_id" id="pegawai_id_edit">
                            <label for="modal-form-2-edit" class="form-label">Nama Pegawai</label>
                            <select id="modal-form-2-edit" class="form-select"  disabled>
                            @foreach ($pegawais as $item)
                                <option value="{{ $item->id }}">{{ $item->nama }}</option>
                            @endforeach
                            </select>
                        </div>
                        <div class="col-span-12 sm:col-span-12">
                            <input type="hidden" name="jabatan_id" id="jabatan_id_edit">
                            <label for="modal-form-3-edit" class="form-label">Jabatan</label>
                            <select id="modal-form-3-edit" class="form-select"  disabled>
                            @foreach ($jabatans as $item)
                                <option value="{{ $item->id }}">{{ $item->nama }}</option>
                            @endforeach

                        </div>
                        <div class="col-span-12 sm:col-span-12">
                            <label for="modal-form-4-edit" class="form-label">Keterangan</label>
                            <textarea name="keterangan" id="modal-form-4-edit" class="form-control" cols="30" rows="10" placeholder="Buat apa"></textarea>
                        </div>
                        <div class="col-span-12 sm:col-span-12">
                            <label for="modal-form-5-edit" class="form-label">Dokumen</label>
                            <img src="" id="image-edit" alt="file" width="100" height="100">
                            <input id="modal-form-5-edit" name="dokumen" type="file" class="form-control" placeholder="Sertakan dokumen/bukti">
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

                
                $('.pengecualian-edit').on('click',function() {
                    var id = $(this).attr('data-id');

                    $.ajax({
                        url : "{{route('pengecualianedit')}}?id="+id,
                        type: "GET",
                        dataType: "JSON",
                        success: function(data)
                        {
                            $('#modal-update-id').val(data.id);
                            $('#modal-form-1-edit').val(data.tanggal);
                            $('#pegawai_id_edit').val(data.pegawai_id);
                            $('#jabatan_id_edit').val(data.jabatan_id);
                            // $('#modal-form-2-edit').val(data.pegawai_id);
                            // $('#modal-form-3-edit').val(data.jabatan_id);
                            $('#modal-form-2-edit option[value="' + data.pegawai_id +'"]').prop("selected", true);
                            $('#modal-form-3-edit option[value="' + data.jabatan_id +'"]').prop("selected", true);
                            $('#modal-form-4-edit').val(data.keterangan);
                            $('#image-edit').attr('src', 'dokumen/'+data.dokumen);
                            $('#modal-form-5-edit').val(data.dokumen);
                            
                        }
                    });
                });

                jQuery($('#modal-form-2')).on('change',function(){
                    var pegawai_id = jQuery(this).val();
                    if(pegawai_id)
                    {
                        jQuery.ajax({
                            url : "{{route('dropdown_jabatan')}}?id="+pegawai_id,
                            type : "GET",
                            dataType : "json",
                            success:function(data)
                            {
                                jQuery.each(data, function(key,value){
                                    $('#modal-form-3').val(value);
                                    $('#jabatan_id_hidden').val(key);

                                    console.log($('#jabatan_id_hidden').val());

                                });
                            }
                        });
                    }
                    else
                    {
                        $('#modal-form-3').empty();
                    }
                });

                jQuery($('#modal-form-2-edit')).on('change',function(){
                    var pegawai_id = jQuery(this).val();
                    if(pegawai_id)
                    {
                        jQuery.ajax({
                            url : "{{route('dropdown_jabatan')}}?id="+pegawai_id,
                            type : "GET",
                            dataType : "json",
                            success:function(data)
                            {
                                jQuery.each(data, function(key,value){
                                    $('#modal-form-3').val(value);
                                });
                            }
                        });
                    }
                    else
                    {
                        $('#modal-form-3-edit').empty();
                    }
                });

            });
        </script>

    </div>
@endsection
