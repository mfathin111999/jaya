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
						<td style="text-align: center;"><strong>Hallo, {{ $engagement->name }}</strong><br>
							 Pekerjaan dengan kode booking <strong>{{ $engagement->code }}</strong> telah kami terima, berikut kami tawarkan harga per detail pekerjaan
						</td>
					</tr>
					<tr height="30px">
						<td style="text-align: center;">
							<h3><strong style="color: #de2537;">Klik disini bila Sdr/i Setuju</strong></h3>
						</td>
					</tr>
					<tr style="text-align: center;">
						<td>
							<a href="{{ url('/engagement/accCustomer') }}/{{ $engagement->id }}" style="background-color: #fdbe33; border-radius: 10px; color: #FFFFFF; padding: 10px 20px;"> 
								Setuju
							</a>
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