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
                                    <!-- <th class="text-center whitespace-nowrap">Aksi</th> -->
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
                                    <!-- <td class="table-report__action w-56">
                                        <div class="flex justify-center items-center">
                                            <a class="flex items-center mr-3 kehadiran-edit" href="javascript:void(0)" data-toggle="modal" 
                                            id="{{ $item->id }}" data-target="#header-footer-modal-preview-edit" data-id="{{ $item->id }}">
                                                <i data-feather="check-square" class="w-4 h-4 mr-1"></i> Edit 
                                            </a>
                                            <a class="flex items-center text-theme-6" href="/kehadirandelete/{{$item->id}}" onclick="return confirm('Apakah Anda Yakin Menghapus Data?');">
                                                <i data-feather="trash-2" class="w-4 h-4 mr-1"></i> Delete
                                            </a>
                                        </div>
                                    </td> -->
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
                <!-- <div id="header-footer-modal-preview-edit" class="modal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
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
                            <div class="modal-footer text-right">
                                <button type="button" data-dismiss="modal"
                                    class="btn btn-outline-secondary w-20 mr-1">Cancel</button>
                                <button type="submit" class="btn btn-primary w-20">Send</button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div> -->
                <!-- END: Modal Content -->

                
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

                        
                        // $('.kehadiran-edit').on('click',function() {
                        //     var id = $(this).attr('data-id');

                        //     $.ajax({
                        //         url : "{{route('kehadiranedit')}}?id="+id,
                        //         type: "GET",
                        //         dataType: "JSON",
                        //         success: function(data)
                        //         {
                        //             $('#modal-update-id').val(data.id);
                        //             $('#pegawai_id_edit').val(data.pegawai_id);
                        //             // $('#modal-form-1-edit').val(data.pegawai_id);
                        //             $('#modal-form-1-edit option[value="' + data.pegawai_id +'"]').prop("selected", true);
                        //             $('#modal-form-2-edit').val(data.jam_masuk);
                        //             $('#modal-form-3-edit').val(data.jam_istirahat);
                        //             $('#modal-form-4-edit').val(data.jam_masuk_istirahat);
                        //             $('#modal-form-5-edit').val(data.jam_pulang);
                        //             console.log(data.jam_masuk);

                        //         }
                        //     });
                        // });
                    });
                </script>
                
            </div>
        </div>
        
    </div>

    
@endsection
