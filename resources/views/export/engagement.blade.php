<html>
<head>
    <meta charset="utf-8">
    
</head>

<body style="font-size: 14px; align-content: center;">
    <table style="line-height: 2rem; width: 600px; margin-left: auto; margin-right: auto;">
    	<tr>
    		<td colspan="3" align="center">SURAT PERSETUJUAN KERJA</td>
    	</tr>
    	<tr>
    		<td colspan="3" align="center">AKAD/{{ $code }}/1/{{ integerToRoman(date('n')) }}/{{date('Y')}}</td>
    	</tr>
    	<tr>
    		<td colspan="3">Yang bertanda tangan dibawah ini :</td>
    	</tr>
    	<tr>
    		<td style="padding-top: 15px;">Nama</td>
    		<td>:</td>
    		<td>{{ $name }}</td>
    	</tr>
    	<tr>
    		<td>Nama</td>
    		<td>:</td>
    		<td>{{ $address.', Ds. '.ucwords(strtolower($village['name'].', Kec. '.$district['name'].',  '.$regency['name'].' - '.$province['name'])) }}</td>
    	</tr>
    	<tr>
    		<td>Code Pesanan</td>
    		<td>:</td>
    		<td>{{ $code }}</td>
    	</tr>
    	<tr>
    		<td colspan="3" style="padding-top: 15px;">Dengan hal ini merupakan pemilik rumah yang sesuai dengan alamat diatas, dengan ini setuju untuk menunjuk</td>
    	</tr>
    	<tr>
    		<td style="padding-top: 15px;">Nama</td>
    		<td>:</td>
    		<td>{{ $vendor['name'] }}</td>
    	</tr>
    	<tr>
    		<td>Alamat</td>
    		<td>:</td>
    		<td>{{ $vendor['address'] }}</td>
    	</tr>
    	<tr>
    		<td colspan="3" style="padding-top: 15px;"><p style="text-align: justify;">Sebagai Pelaksana Renovasi Atap Pemilik Rumah. Adapun lingkup kerja renovasi, desain renovasi, syarat dan ketentuan, serta estimasi durasi pekerjaan renovasi, mengacu kepada penawaran harga yang menjadi lampiran Surat Persetujuan Kerja ini.</p></td>
    	</tr>
    	<tr>
    		<td colspan="3" style="padding-top: 15px;">Demikian surat persetujuan kerja ini dibuat sebagai tanda persetujuan.</td>
    	</tr>
    	<tr>
    		<td style="padding-top: 15px;" align="center" width="40%">Yang Menunjuk</td>
    		<td></td>
    		<td align="center" width="40%">Yang Ditunjuk</td>
    	</tr>
    	<tr>
    		<td colspan="3" height="30px"></td>
    	</tr>
    	<tr>
    		<td style="padding-top: 15px;" align="center" width="40%">{{ $name }}</td>
    		<td></td>
    		<td align="center" width="40%">{{ $vendor['name'] }}</td>
    	</tr>
    	<tr>
    		<td colspan="3" height="10px"></td>
    	</tr>
    	<tr>
    		<td style="padding-top: 15px;" align="center" colspan="3">Yang Mengetahui</td>
    	</tr>
    	<tr>
    		<td colspan="3" height="20px"></td>
    	</tr>
    	<tr>
    		<td style="padding-top: 15px;" align="center" colspan="3">Nurani Rejeki Unggul</td>
    	</tr>
    </table>
</body>
</html>