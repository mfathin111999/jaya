<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    
</head>

<body style="font-size: 12px; align-content: center;">
    <div class="container">
        <center>
            <h4>SURAT PENAWARAN</h4>
            <h6>NRU/0/1/III/2021</h6>
        </center>

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
            <strong>{{ $datas->name }}</strong><br>
            <strong>{{ ucwords(strtolower($datas->address)) }}</strong><br>
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
                            <th width="20%" style="vertical-align: middle; text-align: center;">
                                Keterangan
                            </th>
                            <th width="15" style="vertical-align: middle; text-align: center;">
                                Vol
                            </th>
                            <th width="10" style="vertical-align: middle; text-align: center;">
                                Sat
                            </th>
                            <th width="10" style="vertical-align: middle; text-align: center;">
                                Mulai
                            </th>
                            <th width="10" style="vertical-align: middle; text-align: center;">
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
                    @endphp
                    @foreach($datas->report as $data)

                    @php
                        $j = 1;
                    @endphp
                    <tbody>
                        <tr>
                            <td colspan="8">{{'Tahapan '.$i++.' '.$data->name }}</td>
                        </tr>
                        @foreach($data->subreport as $detail)
                        <tr>
                            <td>{{ $j++ }}</td>
                            <td>{{ $detail->name }}</td>
                            <td>{{ $detail->volume }}</td>
                            <td>{{ $detail->unit }}</td>
                            <td>{{ $detail->date_work }}</td>
                            <td>{{ $detail->time }}</td>
                            <td>{{ round(($detail->price_dirt / $detail->volume), 0) }}</td>
                            <td>{{ $detail->price_dirt }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    @endforeach

                </table>
            </div> 
        </div> 
        <div>
            <label class="">
                Demikian rincian harga ini kami ajukan, atas perhatian dan kerjasamanya kami ucapkan terima kasih
            </label>
            <br>
            <label>
                Jakarta, {{ date('d M Y') }}
            </label>
            <br>
            <label class="mt-3">
                Jaedi<br>
                PT. Nurani Rejeki Unggul
            </label>
        </div>
    </div>

</body>
</html>

