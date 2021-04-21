@extends('layout.app')

@if(session('id') == null || session('role') == 4)
  <script type="text/javascript">
    window.location = "{{ route('home') }}";
  </script>
@else

  @section('content')
    @include('layout.admin_header')

    <div class="container-fluid" style="margin-top: 60px;">
      <div class="row">
        @include('layout.admin_side')
        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
          <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h4 font-weight-bold">DASHBOARD</h1>
            <div class="btn-toolbar mb-2 mb-md-0">
            </div>
          </div>
          <div class="row">
            <div class="col-md-4 mt-3">
              <div class="card shadow-sm">
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-3 align-self-center text-center">
                      <i class="fa fa-calendar" style="font-size: 50px;"></i>
                    </div>
                    <div class="col-md-9 align-items-center">
                      <label class="h6 font-weight-bold">Jumlah Reservasi</label><br>
                      <label>1000 Reservasi</label>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-4 mt-3">
              <div class="card shadow-sm">
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-3 align-self-center text-center">
                      <i class="fa fa-rocket" style="font-size: 50px;"></i>
                    </div>
                    <div class="col-md-9 align-items-center">
                      <label class="h6 font-weight-bold">Reservasi Berjalan</label><br>
                      <label>37 Reservasi</label>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-4 mt-3">
              <div class="card shadow-sm">
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-3 align-self-center text-center">
                      <i class="fa fa-close" style="font-size: 50px;"></i>
                    </div>
                    <div class="col-md-9 align-items-center">
                      <label class="h6 font-weight-bold">Reservasi Ditolak</label><br>
                      <label>33 Reservasi</label>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-4 mt-3">
              <div class="card shadow-sm">
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-3 align-self-center text-center">
                      <i class="fa fa-check" style="font-size: 50px;"></i>
                    </div>
                    <div class="col-md-9 align-items-center">
                      <label class="h6 font-weight-bold">Reservasi Selesai</label><br>
                      <label>40 Reservasi</label>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-4 mt-3">
              <div class="card shadow-sm">
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-3 align-self-center text-center">
                      <i class="fa fa-dollar" style="font-size: 50px;"></i>
                    </div>
                    <div class="col-md-9 align-items-center">
                      <label class="h6 font-weight-bold">Pendapatan Bulan Maret</label><br>
                      <label>Rp. 12.000.000</label>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-12">
              <div class="row">
                <div class="col-md-6 mt-3">
                  <div class="card">
                    <div class="card-header text-center">
                      <label class="m-0">Reservasi Bulan Maret</label>
                    </div>
                    <div class="card-body">
                      <canvas id="myChart"></canvas>
                    </div>
                  </div>
                </div>
                <div class="col-md-6 mt-3">
                  <div class="card">
                    <div class="card-header text-center">
                      <label class="m-0">Reservasi Bulan Maret</label>
                    </div>
                    <div class="card-body">
                      <canvas id="myChart1"></canvas>
                    </div>
                  </div>
                </div>
                <div class="col-md-12 mt-3">
                  <div class="card">
                    <div class="card-header text-center">
                      <label class="m-0">Reservasi Bulan Maret</label>
                    </div>
                    <div class="card-body">
                      <canvas id="myChart2"></canvas>
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
          var MONTHS = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

          var ctx = document.getElementById('myChart');
          var ctx1 = document.getElementById('myChart1');
          var ctx2 = document.getElementById('myChart2');

          var myChart = new Chart(ctx, {
              type: 'doughnut',
              data: {
                  labels: ['Ditolak', 'Berjalan', 'Selesai'],
                  datasets: [{
                    label: '# of Votes',
                    data: [33, 37, 40],
                    backgroundColor: [
                        'rgba(255, 99, 132)',
                        'rgba(54, 162, 235)',
                        'rgba(255, 206, 86)',
                    ],
                    borderWidth: 2
                  }]
              },
          });

          var myChart1 = new Chart(ctx1, {
            type: 'bar',
            data: {
                labels: ['Ditolak', 'Berjalan', 'Selesai'],
                datasets: [{
                    label: 'Reservasi',
                    data: [33, 37, 40],
                    maxBarThickness: 50,
                    backgroundColor: [
                        'rgba(255, 99, 132)',
                        'rgba(54, 162, 235)',
                        'rgba(255, 206, 86)',
                    ],
                    borderWidth: 1
                }]
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

          var myChart2 = new Chart(ctx2, {
            type: 'line',
            data: {
                labels: ['Ditolak', 'Berjalan', 'Selesai'],
                datasets: [{
                    label: 'Ditolak',
                    backgroundColor : 'transparent',
                    borderColor : 'rgba(255, 99, 132)',
                    data: [
                        23, 17, 40
                    ],
                },
                {
                    label: 'Berjalan',
                    backgroundColor : 'transparent',
                    borderColor : 'rgba(54, 162, 235)',
                    data: [
                        33, 21, 10
                    ],
                },
                {
                    label: 'Selesai',
                    backgroundColor : 'transparent',
                    borderColor : 'rgba(255, 206, 86)',
                    data: [
                        23, 29, 21
                    ],
                }]
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
      </script>
  @endsection
@endif