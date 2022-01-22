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
                        <h2 class="text-lg font-medium truncate mr-5">Data Karyawan per bulan {{ date('F Y') }}</h2>
                        <!-- <div class="flex items-center sm:ml-auto mt-3 sm:mt-0">
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
                        </div> -->
                                            <a href="javascript:;" data-toggle="modal" data-target="#cetak-jadwal-bulan"
                        class="btn btn-primary shadow-md mr-2">Cetak Kehadiran Bulanan</a>
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
                             
                            <?php $no = 1; $t=0; ?>
                            @foreach ($pegawais as $p) 

                            <!-- <input type="hidden" name="hidden-id" id="id-{{ $p->pegawai_id }}" value="{{ $p->pegawai_id }}"> -->

                            <tr class="intro-x ">
                                <td class="text-center">
                                    {{ $no++ }}
                                </td>
                                
                                <td class="text-center">
                                    {{ $p->nama }} 
                                </td> 
                                
                                @for ($x=1; $x <= date('t'); $x++)
                                <td class="text-center">
                                    @foreach ($kehadiran_bulanan[$p->id][$x] as $item)
                                    <input type="hidden" name="hidden-id" id="id{{$item->id}}" value="{{ $item->pegawai_id }}">
                                    <input type="hidden" name="hidden-tanggal" id="tanggal{{$item->id}}" value="{{ $item->tanggal}}">
                                    <input type="hidden" id="jam_masuk{{ $item->id }}" value="{{ $item->jam_masuk }}">
                                    <input type="hidden" id="jam_istirahat{{ $item->id }}" value="{{ $item->jam_istirahat }}">
                                    <input type="hidden" id="jam_masuk_istirahat{{ $item->id }}" value="{{ $item->jam_masuk_istirahat }}">
                                    <input type="hidden" id="jam_pulang{{ $item->id }}" value="{{ $item->jam_pulang }}">
                                    <span class="jam_masuk{{$item->id}}" value="{{$item->jam_masuk}}"> {{ $item->jam_masuk != null ? $item->jam_masuk : '-' }} </span> <br>
                                    <span class="jam_istirahat{{$item->id}}" value="{{$item->jam_istirahat}}">{{ $item->jam_istirahat != null ? $item->jam_istirahat : '-' }}</span> <br>
                                    <span class="jam_masuk_istirahat{{$item->id}}" value="{{$item->jam_masuk_istirahat}}">{{ $item->jam_masuk_istirahat != null ? $item->jam_masuk_istirahat : '-' }} </span> <br>
                                    <span class="jam_pulang{{$item->id}}" value="{{$item->jam_pulang}}">{{ $item->jam_pulang != null ? $item->jam_pulang : '-' }} </span>
                                    @endforeach
                                </td>
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

                
                <script type="text/javascript">
                    $(document).ready(function() {


                        <?php  foreach ($pegawais as $p):  ?>
                            <?php  for ($x = 1; $x <= date('d'); $x++):  ?>

                            <?php  foreach ($kehadiran_bulanan[$p->id][$x] as $item): ?>
                            
                            var id = $('#id{{$item->id}}').val();
                            var tanggal  = $('#tanggal{{$item->id}}').val();

                            // var id = {{ $item->pegawai_id }};
                            // var tanggal = {{ $item->tanggal }};

                            $.ajax({
                                    url : "{{route('getpolakerja')}}?id="+id +"&tanggal="+tanggal,
                                    type: "GET",
                                    dataType: "JSON",
                                    // contentType: 'text/plain',
                                    success: function(data)
                                    {
                                            if ( $('#jam_masuk{{$item->id}}').val() > data.jam_masuk ){
                                                $('.jam_masuk{{$item->id}}').addClass('text-theme-11');
                                            }
                                            else if ( $('#jam_istirahat{{$item->id}}').val() < data.jam_istirahat ){
                                                $('.jam_istirahat{{$item->id}}').addClass('text-theme-11');
                                            }
                                            else if ( $('#jam_masuk_istirahat{{$item->id}}').val() > data.jam_istirahat_masuk ){
                                                $('.jam_masuk_istirahat{{$item->id}}').addClass('text-theme-11');
                                            }
                                            else if (  $('#jam_pulang{{$item->id}}').val() < data.jam_pulang ){
                                                $('.jam_pulang{{$item->id}}').addClass('text-theme-11');
                                            }

                                    }
                                });

                                    <?php endforeach; ?>
                                <?php endfor; ?>
                            <?php endforeach; ?>

                        

                      
                        
                                                
                        
                    });
                </script>
                
            </div>
        </div>
        
    </div>

     <!-- BEGIN: Modal Content -->
    <div id="cetak-jadwal-bulan" class="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <!-- BEGIN: Modal Header -->
                <div class="modal-header">
                    <h2 class="font-medium text-base mr-auto">Cetak Kehadiran Bulanan</h2>
                    <div class="dropdown sm:hidden">
                        <a class="dropdown-toggle w-5 h-5 block" href="javascript:;" aria-expanded="false">
                            <i data-feather="more-horizontal" class="w-5 h-5 text-gray-600 dark:text-gray-600"></i>
                        </a>
                        <div class="dropdown-menu w-40">
                            <div class="dropdown-menu__content box dark:bg-dark-1 p-2">
           <!--                      <a href="javascript:;"
                                    class="flex items-center p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md">
                                    <i data-feather="file" class="w-4 h-4 mr-2"></i> Download Docs
                                </a> -->
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END: Modal Header -->
                <!-- BEGIN: Modal Body -->
                <form method="POST" id= "form-jadwal" action="{{ route('kehadiran_bulanan-pdf') }}">
                        @csrf
                <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                    <div id="form-cetak-bulan" class="col-span-12 sm:col-span-12">
                        <label for="modal-form-2" class="form-label">Jadwal Kerja</label>
                        <select id="modal-form-2-edit" class="form-select" name="tanggal">
                        @foreach ($bulan_jadwal as $item)
                            <option value="{{ $item->tanggal }}">
                                {{ \Carbon\Carbon::parse($item->tanggal)->format('M - Y')}}
                                </option>
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
@endsection