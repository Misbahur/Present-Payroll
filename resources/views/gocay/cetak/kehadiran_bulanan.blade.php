<!doctype html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Sistem Present & Payrol Gocay</title>


    </head>
    <body>

   <table width="100%">
    <tr class="text-center">
        <td><h1><strong>Jadwal:  </strong>{{ \Carbon\Carbon::parse($bulan)->format('M - Y')}}</h1></td>
    </tr>

</table>

<br/>
         @if ($kehadiran_bulanan != null)
                        <table width="100%" class="table table-report sm:mt-2" border="1">
                            <thead style="background-color: lightgray;">
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

                            <tr class="text-center whitespace-nowrap" style="text-align: center;">
                                <td class="text-center">
                                    {{ $no++ }}
                                </td>
                                
                                <td class="text-center">
                                    {{ $p->nama}} 
                                </td> 

                                @for ($x=1; $x <= date('t'); $x++)
                                <td class="text-center">
                                    @foreach ($kehadiran_bulanan[$p->id][$x] as $item)
                                    <span> {{ $item->jam_masuk != null ? $item->jam_masuk : '-' }} </span> <br>
                                    <span>{{ $item->jam_istirahat != null ? $item->jam_istirahat : '-' }}</span> <br>
                                    <span>{{ $item->jam_masuk_istirahat != null ? $item->jam_masuk_istirahat : '-' }} </span> <br>
                                    <span>{{ $item->jam_pulang != null ? $item->jam_pulang : '-' }} </span>
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

</body>
</html>