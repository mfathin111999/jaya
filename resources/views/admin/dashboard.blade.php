@extends('layout.app')

@if(session('id') == null || session('role') == 4)
  <script type="text/javascript">
    window.location = "{{ route('home') }}";
  </script>
@else

  @section('content')
    @include('layout.admin_header')

    <div class="container-fluid" style="margin-top: 60px;" id="dashboard_id" v-cloak>
      <div class="row">
        @include('layout.admin_side')
        <main role="main" class="col-lg-10 px-4">
          <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h4 font-weight-bold">DASHBOARD</h1>
            <div class="btn-toolbar mb-2 mb-md-0">
            </div>
          </div>
          <div class="row align-items-center">
            <div class="col-md-6 col-12 mb-3 mb-md-0">
              <h1 class="h5 font-weight-bold mb-0">STATISTIK BULAN @{{ umonth }}</h1>
            </div>
            <div class="col-md-3 col-6">
              <select class="form-control" v-model='month' v-on:change='getData'>
                <option value="01">Januari</option>
                <option value="02">Februari</option>
                <option value="03">Maret</option>
                <option value="04">April</option>
                <option value="05">Mei</option>
                <option value="06">Juni</option>
                <option value="07">Juli</option>
                <option value="08">Agustus</option>
                <option value="09">September</option>
                <option value="10">Oktober</option>
                <option value="11">November</option>
                <option value="12">Desember</option>
              </select>
            </div>
            <div class="col-md-3 col-6">
              <select class="form-control" v-model='year' v-on:change='getData'>
                @foreach(range(2020, date('Y')+1) as $data)
                <option value="{{ $data }}">{{ $data }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-md-4 mt-3">
              <div class="card shadow-sm">
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-3 col-4 align-self-center text-center">
                      <i class="fa fa-calendar" style="font-size: 50px;"></i>
                    </div>
                    <div class="col-md-9 col-8 align-items-center">
                      <label class="h6 font-weight-bold">Jumlah Reservasi</label><br>
                      <label>@{{ data.all }} Reservasi</label>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-4 mt-3">
              <div class="card shadow-sm">
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-3 col-4 align-self-center text-center">
                      <i class="fa fa-rocket" style="font-size: 50px;"></i>
                    </div>
                    <div class="col-md-9 col-8 align-items-center">
                      <label class="h6 font-weight-bold">Reservasi Berjalan</label><br>
                      <label>@{{ data.do }} Reservasi</label>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            @if(auth()->user()->role == 1)
            <div class="col-md-4 mt-3">
              <div class="card shadow-sm">
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-3 col-4 align-self-center text-center">
                      <i class="fa fa-close" style="font-size: 50px;"></i>
                    </div>
                    <div class="col-md-9 col-8 align-items-center">
                      <label class="h6 font-weight-bold">Reservasi Ditolak</label><br>
                      <label>@{{ data.ignore }} Reservasi</label>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            @endif

            <div class="col-md-4 mt-3">
              <div class="card shadow-sm">
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-3 col-4 align-self-center text-center">
                      <i class="fa fa-check" style="font-size: 50px;"></i>
                    </div>
                    <div class="col-md-9 col-8 align-items-center">
                      <label class="h6 font-weight-bold">Reservasi Selesai</label><br>
                      <label>@{{ data.finish == 0 ? 'Belum ada' : data.finish+' Reservasi' }}</label>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            @if(auth()->user()->role == 1 || auth()->user()->role == 5)
            <div class="col-md-4 mt-3">
              <div class="card shadow-sm">
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-3 col-4 align-self-center text-center">
                      <i class="fa fa-dollar" style="font-size: 50px;"></i>
                    </div>
                    <div class="col-md-9 col-8 align-items-center">
                      <label class="h6 font-weight-bold">Prediksi Pendapatan</label><br>
                      <label>Rp. @{{ formatPrice(data.all_benefit) }}</label>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-4 mt-3">
              <div class="card shadow-sm">
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-3 col-4 align-self-center text-center">
                      <i class="fa fa-dollar" style="font-size: 50px;"></i>
                    </div>
                    <div class="col-md-9 col-8 align-items-center">
                      <label class="h6 font-weight-bold">Pendapatan</label><br>
                      <label>Rp. @{{ formatPrice(data.benefit) }}</label>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            @endif
            <div class="col-md-12">
              <div class="row">
                <div class="col-md-6 mt-3">
                  <div class="card">
                    <div class="card-header text-center">
                      <label class="m-0">Reservasi Bulan @{{ lmonth }}</label>
                    </div>
                    <div class="card-body">
                      <canvas id="myChart"></canvas>
                    </div>
                  </div>
                </div>
                <div class="col-md-6 mt-3">
                  <div class="card">
                    <div class="card-header text-center">
                      <label class="m-0">Reservasi Bulan @{{ lmonth }}</label>
                    </div>
                    <div class="card-body">
                      <canvas id="myChart1"></canvas>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </main>
      </div>
    </div>

  @endsection
  @section('sec-js')
      <script type="text/javascript" src="{{asset('js/chart.min.js')}}"></script>
      <script type="text/javascript">
          var dashboard = new Vue({
            el : '#dashboard_id',
            data : {
              data : [],
              umonth : '',
              lmonth : '',
              month  : moment().format('MM'),
              year   : moment().format('YYYY'),
            },
            mounted: function () {
              this.getData();
              this.monthName(this.month);
            },
            methods: {
              async getData (){
                await axios.post('api/resource/getMaterialDashboard',{ 'year' : this.year, 'month' : this.month, _method: 'get'}).then(response => {
                  this.data = response.data.data;
                });

                this.graph();
                this.monthName(this.month);
              },
              formatPrice(value) {
                let val = (value/1).toFixed(0).replace(',', ',')
                return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
              },
              monthName: function (vmn) {
                var month = '';

                if (vmn == '01') {
                  month = 'Januari';
                }else if (vmn == '02') {
                  month = 'Februari';
                }else if (vmn == '03') {
                  month = 'Maret';
                }else if (vmn == '04') {
                  month = 'April';
                }else if (vmn == '05') {
                  month = 'Mei';
                }else if (vmn == '06') {
                  month = 'Juni';
                }else if (vmn == '07') {
                  month = 'Juli';
                }else if (vmn == '08') {
                  month = 'Agustus';
                }else if (vmn == '09') {
                  month = 'September';
                }else if (vmn == '10') {
                  month = 'Oktober';
                }else if (vmn == '11') {
                  month = 'November';
                }else if (vmn == '12') {
                  month = 'Desember';
                }
                this.lmonth = month;
                this.umonth = month.toUpperCase();
              },
              graph: function(){
                var ctx   = document.getElementById('myChart');
                var ctx1  = document.getElementById('myChart1');
                var ctx2  = document.getElementById('myChart2');
                var myChart = new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        labels: this.data.chart['label'],
                        datasets: [{
                          label: '# of Votes',
                          data: this.data.chart['data'],
                          backgroundColor: this.data.chart['color'],
                          borderWidth: 2
                        }]
                    },
                });

                var myChart1 = new Chart(ctx1, {
                  type: 'bar',
                  data: {
                      labels: ['Reservasi'],
                      datasets: JSON.parse(this.data.chart1)
                  },
                  options: {
                      scales: {
                          yAxes: [{
                              ticks: {
                                  beginAtZero: true
                              }
                          }]
                      }
                  }
                });

              }
            }
          });
      </script>
  @endsection
@endif