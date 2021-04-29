<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body style="margin: 0; padding: 0;">
	<table align="center" cellpadding="0" cellspacing="0" width="600">
		<tr height="20px" bgcolor="#0fbdd2">
			<td>
				<center>
					<img src="{{ $message->embed('img/logo.png') }}" style="width: 30%; padding: 10px;">
				</center>
			</td>
		</tr>
		<tr>
			<td bgcolor="#ffffff" style="padding: 20px 30px 20px 30px; font-size: 16px; line-height: 2;">
				<table cellpadding="0" cellspacing="0" width="100%">
					<tr style="line-height: 25px;">
						<td style="text-align: center;"><strong>Hallo, {{ $report->engagement->name }}</strong><br>
							Terima Kasih telah menggunakan NRU, Pembayaran pekerjaan tahap {{ $report->name }} dengan jumlah Rp. {{ number_format($price, 2) }}, dengan kode booking <strong>{{ $report->engagement->code }}</strong> harap segera diselesaikan.
						</td>
					</tr>
					<tr height="30px">
						<td style="text-align: center;">
							<h3><strong style="color: #de2537;">Klik tombol dibawah untuk detail pembayaran</strong></h3>
						</td>
					</tr>
					<tr>
						<td style="text-align: center;">
							<a href="{{ $report->payment_url }}?_token={{ $report->payment_token }}" style="background-color: #555555; border-radius: 10px; color: #FFFFFF; padding: 1rem;"> 
								Detail Pembayaran
							</a>
						</td>
					</tr>
					<tr style="text-align: center;">
						<td>

						</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td bgcolor="#0fbdd2" height="50px" style="text-align: center; color: white; font-size: 12px;">
				© 2021 NRU.
			</td>
		</tr>
	</table>
</body>
</html>