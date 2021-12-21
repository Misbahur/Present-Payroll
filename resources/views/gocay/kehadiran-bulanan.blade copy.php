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
                        <h2 class="text-lg font-medium truncate mr-5">Daftar Karyawan</h2>
                        <div class="flex items-center sm:ml-auto mt-3 sm:mt-0">
                            <form method="get" action="{{ route('filter-kehadiran') }}">
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
                            <a href="{{ route('kehadiran') }}" class="btn btn-success flex items-center">
                                <i data-feather="refresh-cw" class="hidden sm:block w-4 h-4"></i>
                            </a>
                            <!-- <button class="ml-3 btn box flex items-center text-gray-700 dark:text-gray-300">
                                <i data-feather="file-text" class="hidden sm:block w-4 h-4 mr-2"></i> Export to PDF
                            </button> -->
                        </div>
                    </div>
                    <div class="intro-y overflow-auto  mt-8 sm:mt-0 table-responsive">
                        @if ($kehadiran_bulanan != null)
                        <table class="table table-report sm:mt-2">
                            <thead>
                                <tr>
                                    <th class="whitespace-nowrap">No</th>
                                    <th class="text-center whitespace-nowrap">Nama Pegawai</th>
                                    @for ($x=0; $x < date('t'); $x++)
                                    <th class="text-center whitespace-nowrap">
                                        {{ $x+1 }}
                                    </th>
                                    @endfor
                                </tr>
                            </thead>
                            <tbody>
                             
                            @foreach ($kehadiran_bulanan as $item)
                            <input type="hidden" name="hidden-id" id="id-{{ $item->pegawai_id }}" value="{{ $item->pegawai_id }}">
                            @endforeach

                            <?php $no = 1; $t=0; ?>
                            @foreach ($pegawais as $p) 
                            <tr class="intro-x ">
                                <td class="text-center">
                                    {{ $no++ }}
                                </td>
                                
                                <td class="text-center">
                                    {{ $p->nama }} 
                                </td> 
                                
                                @for ($x=1; $x <= date('t'); $x++)
                                <input type="hidden" name="hidden-id" id="id-{{ $kehadiran_bulanan[$t]->pegawai_id }}" value="{{ $kehadiran_bulanan[$t]->pegawai_id }}">
                                <input type="hidden" name="hidden-tanggal" id="tanggal-{{ $kehadiran_bulanan[$t]->tanggal }}" value="{{ $kehadiran_bulanan[$t]->tanggal }}">
                                <td class="text-center">
                                    <span class="jam_masuk{{$t}}" value="{{ $kehadiran_bulanan[$t]->jam_masuk }}"> {{ $kehadiran_bulanan[$t]->jam_masuk ? $kehadiran_bulanan[$t]->jam_masuk : '-'  }} </span> <br>
                                    <span class="jam_istirahat{{$t}}" value="{{ $kehadiran_bulanan[$t]->jam_istirahat }}"> {{ $kehadiran_bulanan[$t]->jam_istirahat ? $kehadiran_bulanan[$t]->jam_istirahat : '-'  }} </span> <br>
                                    <span class="jam_masuk_istirahat{{$t}}" value="{{ $kehadiran_bulanan[$t]->jam_masuk_istirahat }}"> {{ $kehadiran_bulanan[$t]->jam_masuk_istirahat ? $kehadiran_bulanan[$t]->jam_masuk_istirahat : '-'  }} </span> <br>
                                    <span class="jam_pulang{{$t}}" value="{{ $kehadiran_bulanan[$t]->jam_pulang }}"> {{ $kehadiran_bulanan[$t]->jam_pulang ? $kehadiran_bulanan[$t]->jam_pulang : '-'  }} </span>
                                </td>
                                <?php 
                                    if ($t != (date('t')*$p->id )):
                                        $t++;
                                    else:
                                        $t = date('t')*$p->id;
                                    endif;  
                                ?>
                                @endfor

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

                        </div>
                    </div>
                </div>
                <!-- END: Weekly Top Products -->

                 <!-- BEGIN: Modal Content -->
                <div id="header-footer-modal-preview-edit" class="modal" tabindex="-1" aria-hidden="true">
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
                            <form method="POST" action="{{ route('kehadiranupdate') }}">
                            <input type="hidden" name="id" id="modal-update-id">
                                @csrf
                            <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                                <div class="col-span-12 sm:col-span-12">
                                    <input type="hidden" name="pegawai_id" id="pegawai_id_edit">
                                    <label for="modal-form-1-edit" class="form-label">Nama Pegawai</label>
                                    <select id="modal-form-1-edit" class="form-select"  disabled>
                                    @foreach ($kehadirans as $item)
                                        <option value="{{ $item->pegawai->id }}">{{ $item->pegawai->nama }}</option>
                                    @endforeach
                                    </select>
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
                                    <input id="modal-form-4-edit" name="jam_masuk_istirahat" type="time" class="form-control" placeholder="">
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

                <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
                <script type="text/javascript">
                    $(document).ready(function() {
                        
                        <?php 
                            for ( $t = 0; $t < $kehadiran_bulanan->count(); $t++): 
                            ?>
                            
                            var id{{ $kehadiran_bulanan[$t]->pegawai_id }} = $('#id-{{ $kehadiran_bulanan[$t]->pegawai_id }}').val();
                            var tanggal{{ $t }} = $('#tanggal-{{ $kehadiran_bulanan[$t]->tanggal }}').val();
                            $.ajax({
                                    // url : "{{route('getpolakerja')}}?id="+id{{ $kehadiran_bulanan[$t]->pegawai_id }},
                                    url : "{{route('getpolakerja')}}?id="+id{{ $kehadiran_bulanan[$t]->pegawai_id }}+"&tanggal="+tanggal{{ $t }},
                                    type: "GET",
                                    dataType: "JSON",
                                    success: function(data)
                                    {
                                        if ( '{{ $kehadiran_bulanan[$t]->jam_masuk }}' > data.jam_masuk){
                                            $('.jam_masuk{{ $t }}').addClass('text-theme-11');
                                        }
                                        if ( '{{ $kehadiran_bulanan[$t]->jam_istirahat }}' < data.jam_istirahat){
                                            $('.jam_istirahat{{ $t }}').addClass('text-theme-11');
                                            
                                        }
                                        if ( '{{ $kehadiran_bulanan[$t]->jam_istirahat_masuk }}' > data.jam_istirahat_masuk){
                                            $('.jam_masuk_istirahat{{ $t }}').addClass('text-theme-11');
                                            
                                        }
                                        if ( '{{ $kehadiran_bulanan[$t]->jam_pulang }}' < data.jam_pulang){
                                            $('.jam_pulang{{ $t }}').addClass('text-theme-11');
                                            
                                        }

                                    }
                                });

                            <?php endfor; ?>
                                                
                        $('.kehadiran-edit').on('click',function() {
                            var id = $(this).attr('data-id');

                            $.ajax({
                                url : "{{route('kehadiranedit')}}?id="+id,
                                type: "GET",
                                dataType: "JSON",
                                success: function(data)
                                {
                                    $('#modal-update-id').val(data.id);
                                    $('#pegawai_id_edit').val(data.pegawai_id);
                                    // $('#modal-form-1-edit').val(data.pegawai_id);
                                    $('#modal-form-1-edit option[value="' + data.pegawai_id +'"]').prop("selected", true);
                                    $('#modal-form-2-edit').val(data.jam_masuk);
                                    $('#modal-form-3-edit').val(data.jam_istirahat);
                                    $('#modal-form-4-edit').val(data.jam_masuk_istirahat);
                                    $('#modal-form-5-edit').val(data.jam_pulang);
                                    console.log(data.jam_masuk);

                                }
                            });
                        });
                    });
                </script>
                
            </div>
        </div>
        
    </div>

    
@endsection
