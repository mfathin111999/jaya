<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body style="margin: 0; padding: 0;">
	<table align="center" cellpadding="0" cellspacing="0" width="600">
		<tr height="20px" bgcolor="#fdbe33">
			<td>
				<center>
					<h3>ServisRumah.com</h3>
				</center>
			</td>
		</tr>
		<tr>
			<td bgcolor="#ffffff" style="padding: 20px 30px 20px 30px; font-size: 16px; line-height: 2;">
				<table cellpadding="0" cellspacing="0" width="100%">
					<tr style="line-height: 25px;">
						<td style="text-align: center;"><strong>Hallo, {{ $engagement['customer'] }}</strong><br>
							Terima Kasih telah menggunakan ServisRumah.com, Pembayaran pekerjaan tahap {{ $engagement['step'] }} dengan jumlah Rp. {{ number_format($engagement['amount'], 2) }}, dengan kode booking <strong>{{ $engagement['code'] }}</strong>.
						</td>
					</tr>
					<tr>
						<td style="text-align: center;">
							<strong>Telah Selesai</strong><br><br>
							Dengan Status : <strong>
								@if($engagement['status'] == 'success' || $engagement['status'] == 'settlement')
									Berhasil
								@elseif($engagement['status'] == 'pending')
									Pending
								@elseif($engagement['status'] == 'deny')
									Ditolak
								@elseif($engagement['status'] == 'expire')
									Kadaluarsa
								@elseif($engagement['status'] == 'cancel')
									Dibatalkan
								@else
									Gagal
								@endif
							</strong> <br><br>
							{{ $engagement['status'] == 'success' || $engagement['status'] == 'settlement' ? 'Berikut kami kuitansi pembayaran anda.' : '' }}
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
			<td bgcolor="#030f27" height="50px" style="text-align: center; color: white; font-size: 12px;">
				© {{ date('Y') }} ServisRumah.com adalah merek dagang dari PT. Nurani Rejeki Unggul
			</td>
		</tr>
	</table>
</body>
</html>