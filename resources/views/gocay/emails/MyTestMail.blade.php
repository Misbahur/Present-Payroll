<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Slip Gaji Gocay</title>
		<meta charset="utf-8">
    	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<!-- Invoice styling -->
		<style>
			body {
				/* font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; */
				text-align: center;
				color: #000;
				/*color: #777;*/
				font-weight: 900;
			}

			body h1 {
				font-weight: 150;
				margin-bottom: 0px;
				padding-bottom: 0px;
				color: #000;
			}

			body h3 {
				font-weight: 150;
				margin-top: 5px;
				margin-bottom: 10px;
				font-style: italic;
				color: #555;
			}

			body a {
				color: #06f;
			}

			.invoice-box {
				max-width: 400px;
				margin: auto;
				padding: 15px;
				border: 1px solid #eee;
				box-shadow: 0 0 5px rgba(0, 0, 0, 0.15);
				font-size: 8px;
				line-height: 12px;
				/* font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; */
				color: #555;
			}

			.invoice-box table {
				width: 100%;
				line-height: inherit;
				text-align: left;
				border-collapse: collapse;
			}

			.invoice-box table td {
				padding: 3px;
				vertical-align: top;
			}

			.invoice-box table tr td:nth-child(2) {
				text-align: right;
			}

			.invoice-box table tr.top table td {
				padding-bottom: 10px;
			}

			.invoice-box table tr.top table td.title {
				font-size: 25px;
				line-height: 25px;
				color: #333;
			}

			.invoice-box table tr.information table td {
				padding-bottom: 20px;
			}

			.invoice-box table tr.heading td {
				background: #eee;
				border-bottom: 1px solid #ddd;
				font-weight: bold;
			}

			.invoice-box table tr.details td {
				padding-bottom: 10px;
			}

			.invoice-box table tr.item td {
				border-bottom: 1px solid #eee;
			}

			.invoice-box table tr.item.last td {
				border-bottom: none;
			}

			.invoice-box table tr.total td:nth-child(2) {
				border-top: 2px solid #eee;
				font-weight: bold;
			}

			.invoice-box table tr.titlettd td {
				font-weight: bold;
				text-align: center;
				padding-top: 30px;
			}

			.invoice-box table tr.ttd td {
				font-weight: bold;
				text-align: center;
				padding-top: 60px;
			}

			@media only screen and (max-width: 300px) {
				.invoice-box table tr.top table td {
					width: 100%;
					display: block;
					text-align: center;
				}

				.invoice-box table tr.information table td {
					width: 100%;
					display: block;
					text-align: center;
				}
			}
		</style>
	</head>

	<body>
		<div class="invoice-box">
			<table>
				<tr class="top">
					<td colspan="2">
						<table>
							<tr>
								<td class="title">
									{{-- <img src="{{ asset('dist/images/logo.png') }}" alt="Company logo" style="width: 100%; max-width: 300px" /> --}}
                                    <h5>Gocay Cafe Resto & Supermarket</h5>
                                </td>

								<td>
									Email #<br />
									Periode: {{ $pegawai->periode->tanggal_awal }} - {{ $pegawai->periode->tanggal_akhir }} 
								</td>
							</tr>
						</table>
					</td>
				</tr>

				<tr class="information">
					<td colspan="2">
						<table>
							<tr>
								<td>
                                    <b>Perusahaan</b><br/>
									{{ $setting[2]->value }}<br />
									{{ $setting[6]->value }}
								</td>

								<td>
									<b>Pegawai</b><br/>
									{{ $pegawai->pegawai->nama }}<br />
									{{ $pegawai->jabatan->nama }}
								</td>
							</tr>
						</table>
					</td>
				</tr>

				<tr class="heading">
					<td>Pemasukan +</td>
                    
					<td>Nominal #</td>
				</tr>

				@foreach ($gaji as $item)
				<tr class="details">
					<td>{{ $item->keterangan }}</td>
					<td>Rp. {{ number_format($item->nominal) }}</td>
				</tr>
				@endforeach

				<tr class="heading">
					<td>Pengeluaran -</td>

					<td>Nominal</td>
				</tr>

				@foreach ($potongan as $item)
				<tr class="details">
					<td>{{ $item->keterangan }}</td>

					<td>Rp. {{ number_format($item->nominal) }}</td>
				</tr>
				@endforeach

				<tr class="heading">
					<td>Subtotal</td>

					<td>Nominal #</td>
				</tr>

                <tr class="item">
                    <td>Total Pemasukan</td>

					<td>Rp. {{ number_format($in) }}</td>
                </tr>

				<tr class="item last">
					<td>Total Potongan</td>

					<td>Rp. {{ number_format($out) }}</td>
				</tr>

				<tr class="total">
					<td></td>

					<td>Total: Rp. {{ number_format($in-$out) }}</td>
				</tr>

                {{-- <tr class="titlettd">
                    <td>Diserahkan Oleh</td>

                    <td>Diterima Oleh</td>
                </tr>
				<tr class="ttd">
                    <td>Admin</td>

                    <td>{{ $pegawai->pegawai->nama }}</td>
                </tr> --}}
                <tr style="padding-top: 120px;">
                    <td style="text-align: center" colspan="2">Gunakan Uang Sebaik - baik nya</td>
                </tr>
			</table>
		</div>
	</body>
</html>