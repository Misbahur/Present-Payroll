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
        <td><strong>Bank:</strong> {{$bank_id->nama}}</td>
    </tr>

  </table>

  <br/>

  <table width="100%" b>
    <thead style="background-color: lightgray;">
      <tr>
        <th class="whitespace-nowrap">No</th>
        <th class="text-center whitespace-nowrap">Nama Pegawai</th>
        <th class="text-center whitespace-nowrap">Bank</th>
        <th class="text-center whitespace-nowrap">Nomor Rekekning</th>
        <th class="text-center whitespace-nowrap">Atas Nama</th>
        <th class="text-center whitespace-nowrap">Total</th>
      </tr>
    </thead>
    <tbody>
         @forelse($pegawai as $index => $item)
      <tr>
       <td class="text-center whitespace-nowrap">   {{ $index +1 }}   </td>
      <td class="text-center whitespace-nowrap">   {{ $item->nama }}   </td>
      <td class="text-center whitespace-nowrap">   {{ $item->bank_id != null ? preg_replace('/[^A-Za-z0-9\-]/', '', $nama_bank[$item->bank_id]) : ''  }}   </td>
      <td class="text-center whitespace-nowrap">   {{  $item->no_rek }}   </td>
      <td class="text-center whitespace-nowrap">   {{ $item->atas_nama }}   </td>
      <td class="text-center whitespace-nowrap">      {{ "Rp. " . number_format($gaji_total[$item->id],0,',','.') }}</td>
      </tr>
    @empty
      @endforelse
       <tr style="background-color: lightgray;">
        <td colspan="5"><b>TOTAL</b></td>
        <td><b> {{ "Rp " . number_format($bank_total,0,',','.'); }}</b></td>
    </tr>

    </tbody>
  </table>

</body>
</html>