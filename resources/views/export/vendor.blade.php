<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    
</head>

<body style="font-size: 12px; align-content: center;">
    <div class="container">
        <table style="width: 100%;">
            <tbody>
                <tr>
                    <td style="width: 30%;">
                        <img src="{{ public_path().'/img/logo/logo-complete.png' }}" style="width: 100px; height: auto;">
                    </td>
                    <td style="width: 70%">
                        <h4>SURAT PENUNJUKAN REKANAN</h4>
                        <h6>SPK/{{ $datas->code }}/{{ integerToRoman(date('n')) }}/{{date('Y')}}</h6>
                    </td>
                </tr>
            </tbody>
        </table>

        <div class="mt-4">
            Hal : Penawaran Harga <br>
            <span class="pl-4">
                @php

                    $service = [];

                    foreach ($datas->service as $key) {
                        $service[] = $key->name;
                    }

                    $services = implode(', ', $service);
                @endphp

                {{ $services }}
                
            </span>
        </div>

        <div class="ml-4 mb-4 mt-4">
            Kepada Yth:<br>
            <strong>{{ $datas->vendor->name }}</strong><br>
            <strong>Di {{ ucwords(strtolower(($datas->vendor->district->name ?? '-').', '.($datas->vendor->regency->name ?? '-'))) }}</strong><br>
        </div>

        <div class="ml-4 mb-3">
            Dengan hormat,
        </div>

        <div class="mb-4 text-justify">
            Bedasarkan pesanan dengan Code Booking <strong>{{ $datas->code }}</strong> mengenai Pekerjaan {{ $services }} yang beralamatkan di : {{ ucwords(strtolower($datas->address.', '.$datas->village->name.', '.$datas->district->name.', '.$datas->regency->name.', '.$datas->province->name )) }} <br>Adapun rinciannya adalah sebagai berikut :
        </div>
        <div class="row">
            <div class="col-10 mx-auto">    
                <table class="table table-bordered" style="font-size: 10px !important;">
                    <thead style="vertical-align: middle;">
                        <tr>
                            <th width="5%" style="vertical-align: middle; text-align: center;">
                                No
                            </th>
                            <th width="15%" style="vertical-align: middle; text-align: center;">
                                Keterangan
                            </th>
                            <th width="10" style="vertical-align: middle; text-align: center;">
                                Vol
                            </th>
                            <th width="10" style="vertical-align: middle; text-align: center;">
                                Sat
                            </th>
                            <th width="15" style="vertical-align: middle; text-align: center;">
                                Mulai
                            </th>
                            <th width="15" style="vertical-align: middle; text-align: center;">
                                Selesai
                            </th>
                            <th width="15" style="vertical-align: middle; text-align: center;">
                                Harga Satuan
                            </th>
                            <th width="15" style="vertical-align: middle; text-align: center;">
                                Jumlah Harga
                            </th>
                        </tr>
                    </thead>
                    @php
                        $i = 1;
                        $all_price = 0;
                        $date_after = $datas->date_work;
                        $date_before = $datas->date_work;
                    @endphp
                    <tbody>
                    @foreach($datas->report as $data)

                    @php
                        $j = 1;
                        $k = 1;
                        $price = 0;
                    @endphp
                        <tr>
                            <td colspan="8">{{'Tahapan '.$i++.' '.$data->name }}</td>
                        </tr>
                        @foreach($data->subreport as $detail)
                        @php
                            $price += $detail->price_clean*$detail->volume;
                            $all_price += $detail->price_clean*$detail->volume;
                            $date_before = date('Y/m/d', strtotime($date_after));
                            $date_after = date('Y/m/d', strtotime($date_before.' +'.$detail->time.' day'));
                        @endphp
                        <tr>
                            <td>{{ $j++ }}</td>
                            <td>{{ $detail->name }}</td>
                            <td>{{ $detail->volume }}</td>
                            <td>{{ $detail->unit }}</td>
                            <td>{{ $date_before }}</td>
                            <td>{{ $date_after }}</td>
                            <td>{{ number_format($detail->price_clean,0,",",".") }}</td>
                            <td>{{ number_format(($detail->price_clean * $detail->volume),0,",",".") }}</td>
                        </tr>
                        @endforeach
                        <tr>
                            <td colspan="7">Total</td>
                            <td>
                                {{ number_format($price,0,",",".") }}
                            </td>
                        </tr>
                    @endforeach
                        <tr>
                            <td colspan="7">Total Keseluruhan</td>
                            <td>{{ number_format($all_price,0,",",".") }}</td>
                        </tr>
                    </tbody>

                </table>
            </div> 
        </div> 
        <div>
            <label class="">
                Demikian rincian harga ini kami ajukan, atas perhatian dan kerjasamanya kami ucapkan terima kasih.
            </label>
            <br>
            <br>
            <label>
                Jakarta, {{ date('d M Y') }}
            </label>
            <br>
            <label class="mt-3">
                <br>
                ServisRumah.com
            </label>
            <br>
            <br>
            <h5>Syarat dan Ketentuan</h5>
            <label class="text-justify">
                1.Selama berlangsungnya pekerjaan, VENDOR wajib mematuhi dan mentaati segala peraturan baik ketentuan keamanan, keselamatan maupun peraturan lain  yang berlaku di tempat bekerja. <br>

                2.VENDOR wajib menjaga dan meningkatkan hubungan baik dengan costumer. <br>

                3.VENDOR wajib menjalankan semua pekerjaan sesuai yang tertuang dalam Surat Perjanjian Kerja (SPK) yang telah disepakti bersama. <br>

                4.Apabila VENDOR tidak melaksanakan atau lalai dalam menjalankan ketentuan pekerjaan yang telah disepakati, maka perusahaan dalam hal ini (SERVISRUMAH.COM), berhak untuk tidak melakukan pembayaran dan berhak untuk meminta ganti rugi dari Pihak Vendor. <br>

                5.Bila terjadi perselisihan antar pihak, maka pada dasarnya akan diselesaikan secara musyawarah, bila musyawarah sebagaimana dimaksud belum dapat diatasi, maka perselisihan akan diselesaikan melalui Pengadilan Negeri. <br>
            </label>

            <br>

                © {{ date('Y') }} ServisRumah.com adalah merek dagang dari PT. Nurani Rezeki Unggul
        </div>
    </div>

</body>
</html>

