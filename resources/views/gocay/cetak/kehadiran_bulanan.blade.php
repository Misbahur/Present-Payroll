<!doctype html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Sistem Present & Payrol Gocay</title>

        <style>
            table{
                border-collapse: collapse;
            }
            .text-14{
                font-size: 14px;
            }
            .text-yellow{
                color: red;
            }
            thead { display: table-header-group }
            tfoot { display: table-row-group }
            tr { page-break-inside: avoid }
        </style>

    </head>
    <body>

   <table width="100%">

   <tr>
       <td class="text-center">
            <img  src="{{'data:image/png;base64,'.base64_encode(file_get_contents(public_path('dist/images/logo.png')))}}" alt="Company logo" style="width: 150px;" />
       </td>
   </tr>
    <tr class="text-center">
        <td><h1><strong>Kehadiran Pegawai Bulanss:  </strong>{{ \Carbon\Carbon::parse($bulan)->format('M - Y')}}</h1></td>
    </tr>

</table>

<br/>
         @if ($kehadiran_bulanan != null)
                        <table width="100%" class="table table-report sm:mt-2" border="1">
                            <thead style="background-color: lightgray;">
                                <tr>
                                    <th class="whitespace-nowrap">No</th>
                                    <th class="text-center whitespace-nowrap">Nama Pegawai</th>
                                    @for ($x=0; $x < date('t', strtotime($bulan)); $x++)
                                    <th class="text-center whitespace-nowrap">
                                        {{ $x+1 }}
                                    </th>
                                    @endfor
                                </tr>
                            </thead>
                            <tbody>
                             
                            <?php $no = 1; $t=0; ?>
                            @foreach ($pegawais as $p) 

                            <tr class="text-center whitespace-nowrap" style="text-align: center;">
                                <td class="text-center">
                                    {{ $no++ }}
                                </td>
                                
                                <td class="text-center">
                                    {{ $p->nama}}
                                </td> 

                                @for ($x=1; $x <= date('t', strtotime($bulan)); $x++)
                                <td class="text-center">
                                    @foreach ($kehadiran_bulanan[$p->id][$x] as $item)
                                    <span class="text-14 {{ $item->jam_masuk > $polas[$p->id][$x]->jam_masuk ? 'text-yellow' : '' }}"> {{ $item->jam_masuk != null ? date('H:i', strtotime($item->jam_masuk)) : '-' }} </span> <br>
                                    <span class="text-14 {{ $item->jam_istirahat < $polas[$p->id][$x]->jam_istirahat ? 'text-yellow' : '' }}">{{ $item->jam_istirahat != null ? date('H:i', strtotime($item->jam_istirahat)) : '-' }}</span> <br>
                                    <span class="text-14 {{ $item->jam_masuk_istirahat > $polas[$p->id][$x]->jam_istirahat_masuk ? 'text-yellow' : '' }}">{{ $item->jam_masuk_istirahat != null ? date('H:i', strtotime($item->jam_masuk_istirahat)) : '-' }} </span> <br>
                                    <span class="text-14 {{ $item->jam_pulang < $polas[$p->id][$x]->jam_pulang ? 'text-yellow' : '' }}">{{ $item->jam_pulang != null ? date('H:i', strtotime($item->jam_pulang)) : '-' }} </span>
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