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
					<img src="{{ $message->embed('img/logo.png') }}" style="width: 15%; padding: 10px;">
				</center>
			</td>
		</tr>
		<tr>
			<td bgcolor="#ffffff" style="padding: 20px 30px 20px 30px; font-size: 16px; line-height: 2;">
				<table cellpadding="0" cellspacing="0" width="100%">
					<tr style="line-height: 25px;">
						<td style="text-align: center;"><strong>Hallo, {{ $engagement->name }}</strong><br>
							Mohon maaf reservasi anda dengan kode booking <strong>{{ $engagement->code }}</strong> tidak bisa kami proses dikarenankan <strong>{{ $engagement->reason->reason }}</strong>
						</td>
					</tr>
					<tr>
						<td style="text-align: center; padding-top:15px;">
							<img src="{{ $message->embed('img/ignore.png') }}" style="max-width: 100px;">
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
				© 2021 NRU.
			</td>
		</tr>
	</table>
</body>
</html>