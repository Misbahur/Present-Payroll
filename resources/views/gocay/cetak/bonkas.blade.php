<!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Sistem Present & Payrol Gocay</title>

<style type="text/css">
    * {
        font-family: Verdana, Arial, sans-serif;
    }
    table{
        font-size: x-small;
    }
    tfoot tr td{
        font-weight: bold;
        font-size: x-small;
    }
    .gray {
        background-color: lightgray
    }
</style>

</head>
<body>

  <table width="100%">
    <tr>
        <td valign="top">
        <img src="{{ ('dist/images/logo.png') }}" alt="" width="30%"/ style="padding-bottom: 5em; padding-top: 1em">
        </td>

        <td align="right">
            <h3>Gocay Cafe Resto & Supermarket</h3>
            <pre>
                 Jl. Gelora No.17, Kecamatan Besuki,
                 Kabupaten Situbondo, Jawa Timur 68356
            </pre>

        </td>
    </tr>

  </table>

  <table width="100%">
    <tr class="text-center">
        <td><strong>Bonkas:</strong> {{$pegawai}}</td>
    </tr>

  </table>

  <br/>

  <table width="100%" b>
    <thead style="background-color: lightgray;">
      <tr>
        <th class="whitespace-nowrap">ID</th>
        <th class="text-center whitespace-nowrap">Tanggal</th>
        <th class="text-center whitespace-nowrap">Nama Bon-Kas</th>
        <th class="text-center whitespace-nowrap">Nama Pegawai</th>
        <th class="text-center whitespace-nowrap">Jabatan</th>
        <th class="text-center whitespace-nowrap">Keterangan</th>
        <th class="text-center whitespace-nowrap">Nominal</th>
      </tr>
    </thead>
    <tbody>
         @forelse($bonkas as $index => $item)
      <tr>
       <td class="text-center whitespace-nowrap">   {{ $index +1 }}   </td>
      <td class="text-center whitespace-nowrap">   {{ \Carbon\Carbon::parse($item->tanggal)->format('d-M-Y')}}   </td>
      <td class="text-center whitespace-nowrap">   {{ $item->nama }}   </td>
      <td class="text-center whitespace-nowrap">   {{ $item->pegawai->nama }}   </td>
      <td class="text-center whitespace-nowrap">   {{ $item->pegawai->jabatan->nama }}   </td>
      <td class="text-center whitespace-nowrap">      {{ $item->keterangan }}</td>
     <td class="text-center whitespace-nowrap">      {{ "Rp " . number_format($item->nominal,0,',','.'); }} </td>
      </tr>
    @empty
      @endforelse
       <tr style="background-color: lightgray;">
        <td colspan="6"><b>TOTAL</b></td>
        <td><b> {{ "Rp " . number_format($total_bon,0,',','.'); }}</b></td>
    </tr>

    </tbody>
  </table>
  <table style="margin-top: 5em;" width="100%">

                   <tr   align="center" class="titlettd">

                    <td style="padding-bottom: 5em;">Diserahkan Oleh</td>

                    <td style="padding-bottom: 5em;">Diterima Oleh</td>
                </tr>

                <tr align="center"  class="ttd">

                    <td>Admin</td>

                    <td>{{ $adm_pegawai->nama }}</td>
                </tr>

  </table>
</body>
</html>