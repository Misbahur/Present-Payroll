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
			color: #777;
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
			height: 450px;
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
			padding-bottom:5px;
		}

		.invoice-box table tr.top table td.title {
			font-size: 25px;
			line-height: 25px;
			color: #333;
		}

		.invoice-box table tr.information table td {
			padding-bottom: 10px;
		}

		.invoice-box table tr.heading td {
			background: #eee;
			border-bottom: 1px solid #ddd;
			
			font-weight: bold;
		}

		.invoice-box table tr.details td {
			padding-bottom: 2px;
		}

		.invoice-box table tr.item td {
			border-bottom: 1px solid #eee;
		}

		.invoice-box table tr.item.last td {
			border-bottom: none;
		}

		.invoice-box table tr.total td:nth-child(2) {
			border-top: 0px solid #eee;
			font-weight: bold;
		}

		.invoice-box table tr.titlettd td {
			font-weight: bold;
			text-align: center;
			padding-top: 5px;
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
	


	<table width="100%">

		<?php $count = 0;?>

		@foreach($data_id as $n => $dt)

		//write for 1st counter
		@if($count == 0)
		<tr>
			@endif   




			<td class="bg-grey" style="width:25%;height:25%;line-height:0;">
				<div class="invoice-box">
					<table>
						<tr class="top">
							<td colspan="2">
								<table>
									<tr>
										<td class="title">
											<img  src="dist/images/logo.png" alt="Company logo" style="width: 80px;" />
										</td>

										<td>
											Cetak #<br />
											
											Periode: {{ $pegawai[$n]->periode->tanggal_awal }} - {{ $pegawai[$n]->periode->tanggal_akhir }}
											

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
											{{ $pegawai[$n]->pegawai->nama }}<br />
											{{ $pegawai[$n]->jabatan->nama }}
										</td>
									</tr>
								</table>
							</td>
						</tr>

						<tr class="heading">
							<td>Pemasukan +</td>
							
							<td>Nominal #</td>
						</tr>

						@foreach ($gaji as $key => $item)
						<tr class="details">
							@if($item->penggajian_id == $dt)

							<td>{{ $item->keterangan }} </td>
							<td>Rp. {{ number_format($item->nominal) }}</td>
							@endif

						</tr>
						@endforeach

						<tr class="heading">
							<td>Pengeluaran -</td>

							<td>Nominal</td>
						</tr>

						@foreach ($potongan as $key => $item)
						<tr class="details">
							@if($item->penggajian_id == $dt)

							<td>{{ $item->keterangan }}</td>

							<td>Rp. {{ number_format($item->nominal) }}</td>
							@endif
						</tr>

						@endforeach

						<tr class="heading">
							<td>Subtotal</td>

							<td>Nominal #</td>
						</tr>

						
						

						<tr class="item">

							
							<td>Total Pemasukan</td>
							<td>Rp. {{ number_format($in[$n]) }}</td>

						</tr>
						

						
						<tr class="item">
							
							<td>Total Potongan</td>
							<td>Rp. {{ number_format($out[$n]) }}</td>			

						</tr>



						<tr class="total">
							
							<td></td>
							<td>Total: Rp.  {{ number_format($in[$n] - $out[$n]) }} </td>
							<td>  </td>

						</tr>

						<tr class="titlettd">
							<td>Diserahkan Oleh</td>

							<td>Diterima Oleh</td>
						</tr>
						<tr class="ttd">
							<td>Admin</td>
							<td>{{ $pegawai[$n]->pegawai->nama }}</td>
						</tr>
						<tr>
							<td colspan="2" style="padding-bottom: 2px; text-align: center; color:#A9A9A9">Tgl Cetak : {{ now() }}</td>
						</tr>
					</table>
				</div>
				
			</td>


			//write for 3rd counter
			@if($count == 2)
			//reset counter
			<?php $count = 0;?>
		</tr>
		@else
		//add +1 to counter
		<?php $count++;?>
		@endif
		@endforeach
	</table>
</body>
</html>