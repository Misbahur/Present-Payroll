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
                        class="btn btn-primary shadow-md mr-2">Tambah bon-kas</a>
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
                                    <th class="text-center whitespace-nowrap">Tanggal</th>
                                    <th class="text-center whitespace-nowrap">Nama Bon-Kas</th>
                                    <th class="text-center whitespace-nowrap">Nama Pegawai</th>
                                    <th class="text-center whitespace-nowrap">Jabatan</th>
                                    <th class="text-center whitespace-nowrap">Nominal</th>
                                    <th class="text-center whitespace-nowrap">Keterangan</th>
                                    <th class="text-center whitespace-nowrap">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($bon_kas as $item)
                                    <tr class="intro-x">
                                        <td class="w-40">
                                        {{ ++ $i}}
                                        </td>
                                        <td class="text-center">
                                            <a href="" class="font-medium whitespace-nowrap">{{ date('d-m-Y', strtotime($item->tanggal)) }}</a>
                                        </td>
                                        <td class="text-center">
                                            <a href="" class="font-medium whitespace-nowrap">{{ $item->nama }}</a>
                                        </td>
                                        <td class="text-center">
                                            <a href="" class="font-medium whitespace-nowrap">{{ $item->pegawai->nama }}</a>
                                        </td>
                                        <td class="text-center">
                                            <a href="" class="font-medium whitespace-nowrap">{{ $item->pegawai->jabatan->nama }}</a>
                                        </td>
                                        <td class="text-center">
                                            <a href="" class="font-medium whitespace-nowrap">{{ "Rp " . number_format($item->nominal,0,',','.'); }}</a>
                                        </td>
                                        <td class="text-center">
                                            <a href="" class="font-medium whitespace-nowrap">{{ $item->keterangan }}</a>
                                        </td>
                                        <td class="table-report__action w-50">
                                            <div class="flex justify-center items-center">
                                            
                                                <a class="flex items-center mr-2 bon-kas-edit" href="javascript:void(0)" data-toggle="modal" 
                                                id="{{ $item->id }}" data-target="#header-footer-modal-preview-edit" data-id="{{ $item->id }}">
                                                    <i data-feather="check-square" class="w-4 h-4 mr-1"></i> Edit 
                                                </a>
                                                <a class="flex items-center text-theme-6" href="/bon-kasdelete/{{$item->id}}" onclick="return confirm('Apakah Anda Yakin Menghapus Data?');">
                                                    <i data-feather="trash-2" class="w-4 h-4 mr-1"></i> Delete
                                                </a>
                                            </div>
                                            <a class="flex items-center mr-3" href="{{ url('cetak-bonkas-pegawai-pdf',$item->pegawai_id) }}">
                                                    <i data-feather="save" class="w-4 h-4 mr-1"></i> Download
                                                </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="intro-y flex flex-wrap sm:flex-row sm:flex-nowrap items-center mt-3">
                        <div class="pagination">
                                {{ $bon_kas->appends($data_request)->links() }}
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
                        <h2 class="font-medium text-base mr-auto">Tambah Bon Kas</h2>
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
                    <form method="POST" action="{{ route('bon-kasadd') }}">
                        @csrf
                    <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                        <div class="col-span-12 sm:col-span-12">
                            <label for="modal-form-1" class="form-label">Nama</label>
                            <input id="modal-form-1" name="nama" type="text" class="form-control" placeholder="Bon-kasnya apa">
                        </div>
                        <div class="col-span-12 sm:col-span-12">
                            <label for="modal-form-2" class="form-label">Tanggal</label>
                            <input id="modal-form-2" name="tanggal" type="date" class="form-control" placeholder="Tanggal berapa">
                        </div>
                        <div class="col-span-12 sm:col-span-12">
                            <label for="modal-form-3" class="form-label">Nama Pegawai</label>
                            <select id="modal-form-3" class="form-select" name="pegawai_id">
                            @foreach ($pegawais as $item)
                                <option value="{{ $item->id }}">{{ $item->nama }}</option>
                            @endforeach
                            </select>
                        </div>
                        <div class="col-span-12 sm:col-span-12">
                            <label for="modal-form-4" class="form-label">Jabatan</label>
                            <select id="modal-form-4" class="form-select" name="jabatan_id">
                            @foreach ($pegawais as $item)
                                <option value="{{ $item->jabatan_id }}">{{ $item->jabatan->nama }}</option>
                            @endforeach
                            </select>
                        </div>
                        <div class="col-span-12 sm:col-span-12">
                            <label for="modal-form-5" class="form-label">Nominal</label>
                            <input id="modal-form-5" name="nominal" type="number" class="form-control" placeholder="Nominal berapa">
                        </div>
                        <div class="col-span-12 sm:col-span-12">
                            <label for="modal-form-6" class="form-label">keterangan</label>
                            <textarea name="keterangan" id="modal-form-6" class="form-control" cols="30" rows="10" placeholder="Buat apa"></textarea>
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
                        <h2 class="font-medium text-base mr-auto">Update Data Bon Kas</h2>
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
                    <form method="POST" action="{{ route('bon-kasupdate') }}">
                    <input type="hidden" name="id" id="modal-update-id">
                        @csrf
                    <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                        <div class="col-span-12 sm:col-span-12">
                            <label for="modal-form-1-edit" class="form-label">Nama</label>
                            <input id="modal-form-1-edit" name="nama" type="text" class="form-control" placeholder="Bon-kasnya apa">
                        </div>
                        <div class="col-span-12 sm:col-span-12">
                            <label for="modal-form-2-edit" class="form-label">Tanggal</label>
                            <input id="modal-form-2-edit" name="tanggal" type="date" class="form-control" placeholder="Tanggal berapa">
                        </div>
                        <div class="col-span-12 sm:col-span-12">
                            <label for="modal-form-3-edit" class="form-label">Nama Pegawai</label>
                            <select id="modal-form-3-edit" class="form-select" name="pegawai_id">
                            @foreach ($pegawais as $item)
                                <option value="{{ $item->id }}">{{ $item->nama }}</option>
                            @endforeach
                            </select>
                        </div>
                        <div class="col-span-12 sm:col-span-12">
                            <label for="modal-form-4-edit" class="form-label">Jabatan</label>
                            <select id="modal-form-4-edit" class="form-select" name="jabatan_id">
                            @foreach ($pegawais as $item)
                                <option value="{{ $item->jabatan_id }}">{{ $item->jabatan->nama }}</option>
                            @endforeach
                            </select>
                        </div>
                        <div class="col-span-12 sm:col-span-12">
                            <label for="modal-form-5-edit" class="form-label">Nominal</label>
                            <input id="modal-form-5-edit" name="nominal" type="number" class="form-control" placeholder="Nominal berapa">
                        </div>
                        <div class="col-span-12 sm:col-span-12">
                            <label for="modal-form-6-edit" class="form-label">keterangan</label>
                            <textarea name="keterangan" id="modal-form-6-edit" class="form-control" cols="30" rows="10" placeholder="Buat apa"></textarea>
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
                
                $('.bon-kas-edit').on('click',function() {
                    var id = $(this).attr('data-id');

                    $.ajax({
                        url : "{{route('bon-kasedit')}}?id="+id,
                        type: "GET",
                        dataType: "JSON",
                        success: function(data)
                        {
                            $('#modal-update-id').val(data.id);
                            $('#modal-form-1-edit').val(data.nama);
                            $('#modal-form-2-edit').val(data.tanggal);
                            $('#modal-form-3-edit').val(data.pegawai_id);
                            $('#modal-form-4-edit').val(data.jabatan_id);
                            $('#modal-form-5-edit').val(data.nominal);
                            $('#modal-form-6-edit').val(data.keterangan);

                        }
                    });
                });

                jQuery($('#modal-form-3')).on('change',function(){
                    var pegawai_id = jQuery(this).val();
                    if(pegawai_id)
                    {
                        jQuery.ajax({
                            url : "{{route('dropdown_jabatan')}}?id="+pegawai_id,
                            type : "GET",
                            dataType : "json",
                            success:function(data)
                            {
                                jQuery('#modal-form-4').empty();
                                jQuery.each(data, function(key,value){
                                $('#modal-form-4').append('<option value="'+ key +'">'+ value +'</option>');
                                });
                            }
                        });
                    }
                    else
                    {
                        $('#modal-form-4').empty();
                    }
                });

                jQuery($('#modal-form-3-edit')).on('change',function(){
                    var pegawai_id = jQuery(this).val();
                    if(pegawai_id)
                    {
                        jQuery.ajax({
                            url : "{{route('dropdown_jabatan')}}?id="+pegawai_id,
                            type : "GET",
                            dataType : "json",
                            success:function(data)
                            {
                                jQuery('#modal-form-4-edit').empty();
                                jQuery.each(data, function(key,value){
                                $('#modal-form-4-edit').append('<option value="'+ key +'">'+ value +'</option>');
                                });
                            }
                        });
                    }
                    else
                    {
                        $('#modal-form-4-edit').empty();
                    }
                });

                // $('#modal-form-3').on('change', function () {
                //     axios.post('{{ route('dropdown_jabatan') }}', {id: $(this).val()})
                //         .then(function (response) {
                //             $('#modal-form-4').empty();

                //             $.each(response.data, function (id, nama) {
                //                 $('#modal-form-4').append(new Option(nama, id))
                                
                //                 console.log($('#modal-form-4').val());
                //             })
                //         });
                // });

                $('#modal-form-3-edit').on('change', function () {
                    axios.post('{{ route('dropdown_jabatan') }}', {id: $(this).val()})
                        .then(function (response) {
                            $('#modal-form-4-edit').empty();

                            $.each(response.data, function (id, nama) {
                                $('#modal-form-4-edit').append(new Option(nama, id))
                            })
                        });
                });


            });
        </script>
        
    </div>
@endsection
