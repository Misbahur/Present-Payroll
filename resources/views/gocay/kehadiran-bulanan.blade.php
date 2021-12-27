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
                                <input type="hidden" name="hidden-id" id="id-{{ $p->id }}" value="{{ $p->id }}">
                                <input type="hidden" name="hidden-tanggal" id="tanggal-{{ $x }}" value="{{ date('Y') . '-' . date('m') . '-' . $x }}">
                                <td class="text-center">
                                    @foreach ($kehadiran_bulanan[$p->id][$x] as $item)
                                    <span id="jam_masuk-{{ $p->id }}-{{ $x }}"> {{ $item->jam_masuk != null ? $item->jam_masuk : '-' }} </span> <br>
                                    <span id="jam_istirahat-{{ $p->id }}-{{ $x }}">{{ $item->jam_istirahat != null ? $item->jam_istirahat : '-' }}</span> <br>
                                    <span id="jam_masuk_istirahat-{{ $p->id }}-{{ $x }}">{{ $item->jam_masuk_istirahat != null ? $item->jam_masuk_istirahat : '-' }} </span> <br>
                                    <span id="jam_pulang-{{ $p->id }}-{{ $x }}">{{ $item->jam_pulang != null ? $item->jam_pulang : '-' }} </span>
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

                        function total_PS(a,b){
                            var jam_masuk_istirahat = new Date("01/01/2007 " + a).getHours();
                            var jam_istirahat = new Date("01/01/2007 " + b).getHours();
                            var menit_masuk_istirahat = new Date("01/01/2007 " + a).getMinutes();
                            var menit_istirahat = new Date("01/01/2007 " + b).getMinutes();

                            var durasi = ((jam_masuk_istirahat - jam_istirahat)*60) + (menit_masuk_istirahat - menit_istirahat);
                            return durasi;
                        }

                        <?php  foreach ($pegawais as $p):  ?>
                            <?php  for ($x = 1; $x <= date('t'); $x++):  ?>
                            
                            var id{{ $p->id }} = $('#id-{{ $p->id }}').val();
                            var tanggal{{ $x }} = $('#tanggal-{{ $x }}').val();
                            // $.ajax({
                            //         url : "{{route('getpolakerja')}}?id="+id{{ $p->id }}+"&tanggal="+tanggal{{ $x }},
                            //         type: "GET",
                            //         dataType: "JSON",
                            //         success: function(data)
                            //         {
                            //                 if ( $('#jam_masuk-{{ $p->id }}-{{ $x }}').val() > data.jam_masuk){
                            //                     $('#jam_masuk-{{ $p->id }}-{{ $x }}').addClass('text-theme-11');
                            //                 }
                            //                 if ( $('#jam_istirahat-{{ $p->id }}-{{ $x }}').val() < data.jam_istirahat){
                            //                     $('#jam_istirahat-{{ $p->id }}-{{ $x }}').addClass('text-theme-11');
                            //                 }
                            //                 if ( $('#jam_masuk_istirahat-{{ $p->id }}-{{ $x }}').val() > data.jam_istirahat_masuk){
                            //                     $('#jam_masuk_istirahat-{{ $p->id }}-{{ $x }}').addClass('text-theme-11');
                            //                 }
                            //                 if (  $('#jam_pulang-{{ $p->id }}-{{ $x }}').val() < data.jam_pulang){
                            //                     $('#jam_pulang-{{ $p->id }}-{{ $x }}').addClass('text-theme-11');
                            //                 }
                                       
                                        
                            //         }
                            //     });

                                <?php endfor; ?>
                            <?php endforeach; ?>

                        

                        // <?php  foreach ($pegawais as $p):  ?>
                        //     var id{{ $p->id }} = {{ $p->id }};
                        //     <?php  for ($x = 1; $x <= date('t'); $x++):  ?>
                            
                        //     var tanggal{{ $x }} = {{ $x }};
                        //     var pola{{ $x }} = $('#tanggal-{{ $x }}').val();


                        //     $.ajax({
                        //             url : "{{route('data_bulanan')}}?id="+id{{ $p->id }}+"&tanggal="+tanggal{{ $x }},
                        //             type: "GET",
                        //             dataType: "JSON",
                        //             success: function(data)
                        //             {
                        //                 if (data.jam_masuk != null) {
                        //                     $('#jam_masuk-{{ $p->id }}-{{ $x }}').text(data.jam_masuk);
                        //                 }
                        //                 if (data.jam_istirahat != null) {
                        //                     $('#jam_istirahat-{{ $p->id }}-{{ $x }}').text(data.jam_istirahat);
                        //                 }
                        //                 if (data.jam_masuk_istirahat != null) {
                        //                     $('#jam_masuk_istirahat-{{ $p->id }}-{{ $x }}').text(data.jam_masuk_istirahat);
                        //                 }
                        //                 if (data.jam_pulang != null) {
                        //                     $('#jam_pulang-{{ $p->id }}-{{ $x }}').text(data.jam_pulang);
                        //                 }
                        //             }
                        //         });

                        //         <?php endfor; ?>
                        //     <?php endforeach; ?>

                        
                                                
                        
                    });
                </script>
                
            </div>
        </div>
        
    </div>

    
@endsection
