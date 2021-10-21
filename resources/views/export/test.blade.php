<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style type="text/css">
        body {
            font-weight: 400;
            max-width: 768px;
            display: block;
            margin-right: auto;
            margin-left: auto;
            width: 100%;
        }

        .cards{
            border: 2px solid #cccccc;
            border-radius: 10px;
            padding: 30px;
        }

        td{
            vertical-align: middle;
        }

        table{
            width: 100%;
            border: 0;
        }

    </style>
</head>

<body>
    <div class="cards" style="margin-bottom: 20px;">

        <table>
            <tbody>
                <tr>
                    <td style="width: 30%; text-align: center;">
                        <img src="{{ asset('/img/logo/logo-complete.png') }}" style="width: 120px; height: auto;">
                    </td>
                    <td style="width: 70%;">
                        <div class="pl-4">
                            <h4><strong><u>PT. NURANI REJEKI UNGGUL</u></strong></h4>
                            <p>Jl. Bintara XI No. 104 RT/RW : 001/013, Bintara, Bekasi Barat</p>
                            <p>SK KUMHAM NO. AHU-37198.AH.01.01.Tahun 2013</p>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <table style="width: 60%;">
                            <tbody>
                                <tr>
                                    <td style="width: 30%;"><strong>Tanggal</strong></td>
                                    <td style="width: 70%;">22 September 2021</td>
                                </tr>
                                <tr>
                                    <td style="width: 30%;"><strong>Pembayaran</strong></td>
                                    <td style="width: 70%;">Mandiri</td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="text-align: center;">
                        <h1 style="font-weight: 700;">KUITANSI</h1>
                        <p>Nomor : SFNKSN-1/NR/FJKJDN/VIII/2021</p>
                    </td>
                </tr>
            </tbody>
        </table>

    </div>
    <div class="cards" style="margin-bottom: 20px;">
        <table>
            <tbody>
                <tr>
                    <td style="width: 30%; padding-top: 15px; padding-bottom: 15px;">
                        <strong>Sudah Terima Dari</strong>
                    </td>
                    <td style="width: 70%; padding-top: 15px; padding-bottom: 15px;">
                        Sdr/I. Fathin Muhammad
                    </td>
                </tr>
                <tr>
                    <td style="width: 30%; padding-top: 15px; padding-bottom: 15px;">
                        <strong>Banyaknya Uang</strong>
                    </td>
                    <td style="width: 70%; padding-top: 15px; padding-bottom: 15px;">
                        Rp. 15.000.000
                    </td>
                </tr>
                <tr>
                    <td style="width: 30%; padding-top: 15px;">
                        <strong>Untuk Pembayaran</strong>
                    </td>
                    <td style="width: 70%; padding-top: 15px;">
                        Perbaikan Atap, Perbaikan Dapur dan Perbaikan Listrik
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="cards">
        <table>
            <tbody> 
                <tr>
                    <td style="vertical-align: top;">
                        <table style="width: 100%;">
                            <tbody>
                                <tr>
                                    <td style="width: 40%; border-bottom: 2px solid #cccccc; border-top: 2px solid #cccccc; padding-top: 15px; padding-bottom: 15px;">
                                        <strong>Jumlah</strong>
                                    </td>
                                    <td style="width: 60%; border-bottom: 2px solid #cccccc; border-top: 2px solid #cccccc; padding-top: 15px; padding-bottom: 15px;">
                                        Rp. 15.000.000
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                    <td style="text-align: center;">
                        Jakarta, {{ date('d M Y') }}
                        <br>
                        <br>
                        <br>
                        <br>
                        <strong><u>Andi Suwandi</u></strong>
                        <br>
                        <p>Finance</p>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</body>
</html>