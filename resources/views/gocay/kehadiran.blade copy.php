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
                        <h2 class="text-lg font-medium truncate mr-5">Data Kehadiran</h2>
                        <a href="" class="ml-auto flex items-center text-theme-1 dark:text-theme-10">
                            <i data-feather="refresh-ccw" class="w-4 h-4 mr-3"></i> Reload Data
                        </a>
                    </div>
                    <div class="grid grid-cols-12 gap-6 mt-5">
                        <div class="col-span-12 sm:col-span-6 xl:col-span-2 intro-y">
                            <div class="report-box zoom-in">
                                <div class="box p-5">
                                    <div class="flex">
                                        <i data-feather="users" class="report-box__icon text-theme-10"></i>
                                    </div>
                                    <div class="text-3xl font-bold leading-8 mt-6">{{$jumlahPegawai->count()}}</div>
                                    <div class="text-base text-gray-600 mt-1">Pegawai</div>
                                </div>
                            </div>
                        </div>
                        @foreach ($jabatans as $item)
                        <a href="/kehadiran_jabatan/{{ $item->id }}/{{ $tanggal }}" class="col-span-12 sm:col-span-6 xl:col-span-2 intro-y">
                            <!-- <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y"> -->
                                <div class="report-box zoom-in">
                                    <div class="box p-5">
                                        <div class="flex">
                                            <i data-feather="users" class="report-box__icon text-theme-10"></i>
                                        </div>
                                        <div class="text-3xl font-bold leading-8 mt-6">
                                            {{ $jabatan_total[$item->id]->count() ? $jabatan_total[$item->id]->count() : '0' }}
                                        </div>
                                        <div class="text-base text-gray-600 mt-1">{{ $item->nama }}</div>
                                    </div>
                                </div>
                            <!-- </div> -->
                        </a>
                        @endforeach
                    </div> 
                </div> 
                <!-- END: General Report -->

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
                    <div class="intro-y overflow-auto lg:overflow-visible mt-8 sm:mt-0">
                        @if ($kehadirans != null)
                        <table class="table table-report sm:mt-2">
                            <thead>
                                <tr>
                                    <th class="whitespace-nowrap">No</th>
                                    <!-- <th class="whitespace-nowrap">NIP</th> -->
                                    <th class="whitespace-nowrap">Tanggal</th>
                                    <th class="text-center whitespace-nowrap">Nama Pegawai</th>
                                    <!-- <th class="text-center whitespace-nowrap">Jabatan</th> -->
                                    <th class="text-center whitespace-nowrap">Jam Masuk</th>
                                    <th class="text-center whitespace-nowrap">Jam Istirahat</th>
                                    <th class="text-center whitespace-nowrap">Jam Istirahat Masuk</th>
                                    <th class="text-center whitespace-nowrap">Jam Pulang</th>
                                    <th class="text-center whitespace-nowrap">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php $no = 1; ?>
                            @foreach ($kehadirans as $item) 

                            <input type="hidden" name="hidden-id" id="id-{{ $item->pegawai_id }}" value="{{ $item->pegawai_id }}">
                            <input type="hidden" name="hidden-tanggal" id="tanggal-{{ $item->tanggal }}" value="{{ $item->tanggal }}">
                            <input type="hidden" id="jam_masuk{{ $item->pegawai_id }}" value="{{ $item->jam_masuk }}">
                            <input type="hidden" id="jam_istirahat{{ $item->pegawai_id }}" value="{{ $item->jam_istirahat }}">
                            <input type="hidden" id="jam_masuk_istirahat{{ $item->pegawai_id }}" value="{{ $item->jam_masuk_istirahat }}">
                            <input type="hidden" id="jam_pulang{{ $item->pegawai_id }}" value="{{ $item->jam_pulang }}">
                                <tr class="intro-x tabel-pegawai{{ $item->pegawai_id }}">
                                    <td class="w-20">
                                    {{ ++ $i }}
                                    </td>
                                    <td class="w-20 text-center">
                                        <a href="" class="font-small whitespace-nowrap">{{ $item->tanggal }}</a>
                                    </td>
                                    <!-- <td class="w-20 text-center">
                                        <a href="" class="font-small whitespace-nowrap"></a>
                                    </td> -->
                                    <td class="w-20 text-center">
                                        {{ $item->pegawai->nama }}
                                    </td> 
                                           
                                    <td class="w-20 text-center jam_masuk{{ $item->pegawai_id }}">
                                        {{ $item->jam_masuk ? $item->jam_masuk : '-'}}
                                    </td>
                                    <td class="w-20 text-center jam_istirahat{{ $item->pegawai_id }}">
                                        {{ $item->jam_istirahat ? $item->jam_istirahat : '-' }}
                                    </td>
                                    <td class="w-20 text-center jam_masuk_istirahat{{ $item->pegawai_id }}">
                                        {{ $item->jam_masuk_istirahat ? $item->jam_masuk_istirahat : '-'}}
                                    </td>
                                    <td class="w-40 text-center jam_pulang{{ $item->pegawai_id }}">
                                        {{ $item->jam_pulang ? $item->jam_pulang : '-'}}
                                    </td>
                                    <td class="table-report__action w-56">
                                            <div class="flex justify-center items-center">
                                                <a class="flex items-center mr-3 kehadiran-edit" href="javascript:void(0)" data-toggle="modal" 
                                                id="{{ $item->id }}" data-target="#header-footer-modal-preview-edit" data-id="{{ $item->id }}">
                                                    <i data-feather="check-square" class="w-4 h-4 mr-1"></i> Edit 
                                                </a>
                                                <a class="flex items-center text-theme-6" href="/kehadirandelete/{{$item->id}}" onclick="return confirm('Apakah Anda Yakin Menghapus Data?');">
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
                            @if ($kehadirans != null)
                                {{ $kehadirans->appends($data_request)->links() }}
                            @else

                            @endif
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

                        function telat(a,b,c,d){
                            
                        //    const getSeconds = s => s.split(":").reduce((acc, curr) => acc * 60 + +curr, 0);
                        //    var jam_pegawai = getSeconds(a);
                        //    var jadwal = getSeconds(b);
                           var jam_pegawai = new Date("01/01/2007 " + a).getHours();
                           var jam_jadwal = new Date("01/01/2007 " + b).getHours();
                           var menit_pegawai = new Date("01/01/2007 " + a).getMinutes();
                           var menit_jadwal = new Date("01/01/2007 " + b).getMinutes();
                           var pegawai_id = c;
                           var tanggal = d;
                           var status = 'out-telat-harian';
                        
                           var durasi = ((jam_pegawai - jam_jadwal)*60) + (menit_pegawai - menit_jadwal);
                           console.log('Pegawai ID : ' + pegawai_id);
                           console.log(durasi + ' ' + 'menit');
                           console.log(status);
                           $.ajax({
                                url : "{{route('telatlembur')}}?pegawai_id="+pegawai_id+"&tanggal="+tanggal+"&durasi="+durasi+"&status="+status,
                                type: "GET",
                                dataType: "JSON",
                                success: function(data)
                                {

                                }
                            });
                        }

                        function telat_istirahat(a,b,c,d){
                            
                            //    const getSeconds = s => s.split(":").reduce((acc, curr) => acc * 60 + +curr, 0);
                            //    var jam_pegawai = getSeconds(a);
                            //    var jadwal = getSeconds(b);
                               var jam_pegawai = new Date("01/01/2007 " + a).getHours();
                               var jam_jadwal = new Date("01/01/2007 " + b).getHours();
                               var menit_pegawai = new Date("01/01/2007 " + a).getMinutes();
                               var menit_jadwal = new Date("01/01/2007 " + b).getMinutes();
                               var pegawai_id = c;
                               var tanggal = d;
                               var status = 'out-istirahat';
                            
                               var durasi = ((jam_pegawai - jam_jadwal)*60) + (menit_pegawai - menit_jadwal);
                               console.log('Pegawai ID : ' + pegawai_id);
                               console.log(durasi + ' ' + 'menit');
                               console.log(status);
                               $.ajax({
                                    url : "{{route('telatlembur')}}?pegawai_id="+pegawai_id+"&tanggal="+tanggal+"&durasi="+durasi+"&status="+status,
                                    type: "GET",
                                    dataType: "JSON",
                                    success: function(data)
                                    {
    
                                    }
                                });
                            }

                            function telat_istirahat_masuk(a,b,c,d){
                            
                            //    const getSeconds = s => s.split(":").reduce((acc, curr) => acc * 60 + +curr, 0);
                            //    var jam_pegawai = getSeconds(a);
                            //    var jadwal = getSeconds(b);
                               var jam_pegawai = new Date("01/01/2007 " + a).getHours();
                               var jam_jadwal = new Date("01/01/2007 " + b).getHours();
                               var menit_pegawai = new Date("01/01/2007 " + a).getMinutes();
                               var menit_jadwal = new Date("01/01/2007 " + b).getMinutes();
                               var pegawai_id = c;
                               var tanggal = d;
                               var status = 'out-istirahat-masuk';
                            
                               var durasi = ((jam_pegawai - jam_jadwal)*60) + (menit_pegawai - menit_jadwal);
                               console.log('Pegawai ID : ' + pegawai_id);
                               console.log(durasi + ' ' + 'menit');
                               console.log(status);
                               $.ajax({
                                    url : "{{route('telatlembur')}}?pegawai_id="+pegawai_id+"&tanggal="+tanggal+"&durasi="+durasi+"&status="+status,
                                    type: "GET",
                                    dataType: "JSON",
                                    success: function(data)
                                    {
    
                                    }
                                });
                            }

                        function lembur(a,b,c,d){
                            
                            // const getSeconds = s => s.split(":").reduce((acc, curr) => acc * 60 + +curr, 0);
                            // var durasi = Math.floor(Math.abs(jadwal-jam_pegawai)% 3600 / 60);
                            // var jam_pegawai = getSeconds(a);
                            // var jadwal = getSeconds(b);
                            var pegawai_id = c;
                            var tanggal = d;
                            var pegawai_id = c;
                            var status = 'in-lembur-harian';

                            var jam_pegawai = new Date("01/01/2007 " + a).getHours();
                            var jam_jadwal = new Date("01/01/2007 " + b).getHours();
                            var menit_pegawai = new Date("01/01/2007 " + a).getMinutes();
                            var menit_jadwal = new Date("01/01/2007 " + b).getMinutes();
                            var durasi = ((jam_pegawai - jam_jadwal)*60) + (menit_pegawai - menit_jadwal);
                            console.log('Pegawai ID : ' + pegawai_id);
                            console.log(tanggal);
                            console.log(durasi + ' ' + 'menit');
                            console.log(status);
                            $.ajax({
                                url : "{{route('telatlembur')}}?pegawai_id="+pegawai_id+"&tanggal="+tanggal+"&durasi="+durasi+"&status="+status,
                                type: "GET",
                                dataType: "JSON",
                                success: function(data)
                                {

                                }
                            });

                           
                         }

                        <?php $i = 0; foreach ($kehadirans as $item): ?>
                            var pegawai_id{{ $item->pegawai_id }} = $('#id-{{ $item->pegawai_id }}').val();
                            var tanggal{{ $i }} = $('#tanggal-{{ $item->tanggal }}').val();
                            $.ajax({
                                    url : "{{route('getpolakerja')}}?id="+pegawai_id{{ $item->pegawai_id }}+"&tanggal="+tanggal{{ $i }},
                                    type: "GET",
                                    dataType: "JSON",
                                    success: function(data)
                                    {
                                        if ($('#jam_masuk{{ $item->pegawai_id }}').val() > data.jam_masuk){
                                            $('.jam_masuk{{ $item->pegawai_id }}').addClass('text-theme-11');

                                            telat($('#jam_masuk{{ $item->pegawai_id }}').val(), data.jam_masuk, pegawai_id{{ $item->pegawai_id }}, tanggal{{ $i }});
                                        }
                                        if ($('#jam_istirahat{{ $item->pegawai_id }}').val() < data.jam_istirahat){
                                            $('.jam_istirahat{{ $item->pegawai_id }}').addClass('text-theme-11');

                                            telat_istirahat($('#jam_istirahat{{ $item->pegawai_id }}').val(), data.jam_istirahat, pegawai_id{{ $item->pegawai_id }}, tanggal{{ $i }});
                                            
                                        }
                                        if ($('#jam_masuk_istirahat{{ $item->pegawai_id }}').val() > data.jam_istirahat_masuk){
                                            $('.jam_masuk_istirahat{{ $item->pegawai_id }}').addClass('text-theme-11');
                                            
                                            telat_istirahat_masuk($('#jam_masuk_istirahat{{ $item->pegawai_id }}').val(), data.jam_istirahat_masuk, pegawai_id{{ $item->pegawai_id }}, tanggal{{ $i }});
                                            
                                        }
                                        if ($('#jam_pulang{{ $item->pegawai_id }}').val() < data.jam_pulang){
                                            $('.jam_pulang{{ $item->pegawai_id }}').addClass('text-theme-11');
                                            
                                        }

                                        if ($('#jam_pulang{{ $item->pegawai_id }}').val() > data.jam_pulang){
                                            lembur($('#jam_pulang{{ $item->pegawai_id }}').val(), data.jam_pulang, pegawai_id{{ $item->pegawai_id }}, tanggal{{ $i }});
                                        }

                                    }
                                });
                            <?php $i++; endforeach; ?>

                        
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
