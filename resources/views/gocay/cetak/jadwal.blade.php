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
        <td><strong>Jadwal:</strong> {{$bulan}}</td>
    </tr>

  </table>

  <br/>

  <table width="100%" b>
    <thead style="background-color: lightgray;">
      <tr>
        <th class="text-center whitespace-nowrap">No</th>
        <th class="text-center whitespace-nowrap">Tanggal</th>
        <th class="text-center whitespace-nowrap">Shift</th>
        <th class="text-center whitespace-nowrap">Nama Pegawai</th>
      </tr>
    </thead>
    <tbody>
         @forelse($jadwal as $index => $item)
      <tr>
       <td class="text-center whitespace-nowrap">   {{ $index +1 }}   </td>
      <td class="text-center whitespace-nowrap">   {{ \Carbon\Carbon::parse($item->tanggal)->format('d-M-Y')}}   </td>
      <td class="text-center whitespace-nowrap">   {{ $item->pola->nama }}   </td>
      <td class="text-center whitespace-nowrap">   {{ $item->pegawai->nama }}   </td>
      </tr>
    @empty
      @endforelse
    </tbody>
  </table>

</body>
</html>