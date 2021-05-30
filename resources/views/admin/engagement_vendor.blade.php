@extends('layout.app')

@if(session('id') == null || session('role') == 4)
  <script type="text/javascript">
    window.location = "{{ route('home') }}";
  </script>
@else

  @section('sec-css')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/datatables.min.css') }}">
  @endsection

  @section('content')
    @include('layout.admin_header')
    <div id="app" v-cloak>

      <div class="container-fluid" style="margin-top: 60px;">
        <div class="row">
          @include('layout.admin_side')
          <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
              <h1 class="h3 font-weight-bold">RESERVASI</h1>
              <div class="btn-toolbar mb-2 mb-md-0">
                
              </div>
            </div>
            
            <div class="row">
              <div class="col-md-12 text-center rounded" v-if='data.length == 0'>
                <div class="card">
                  <div class="card-body bg-info p-2">
                    <label class="m-0 font-weight-bold text-white">belum ada penawaran pekerjaan</label>
                  </div>
                </div>
              </div>
              <div class="col-md-4" v-if='data.length != 0' v-for='(engage, index) in data'>
                <div class="card">
                  <div class="card-header text-center">
                    <label class="m-0 font-weight-bold">PEKERJAAN</label><br>
                    <label class="m-0 font-weight-bold p-2 bg-warning mt-2 rounded" v-if= 'engage.locked == "offer" && engage.vendor_is == 0'>Proses Penawaran</label>
                    <label class="m-0 font-weight-bold p-2 bg-success text-white mt-2 rounded" v-if= 'engage.locked == "deal"'>Penawaran Telah Disetujui</label>
                    <label class="m-0 font-weight-bold p-2 bg-danger text-white mt-2 rounded" v-if= 'engage.vendor_is == 99'>Anda telah menolak penawaran</label>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table class="table m-0" style="border : 0;">
                        <tr>
                          <td class="p-0" style="border : 0;">Pelanggan</td>
                          <td class="pt-0 pb-0" style="border : 0;">:</td>
                          <td class="p-0" style="border : 0;">@{{ engage.name }}</td>
                        </tr>
                        <tr>
                          <td class="p-0" style="border : 0;">Service</td>
                          <td class="pt-0 pb-0" style="border : 0;">:</td>
                          <td class="p-0" style="border : 0;">@{{ engage.service }}</td>
                        </tr>
                        <tr>
                          <td class="p-0" style="border : 0;">Penawaran</td>
                          <td class="pt-0 pb-0" style="border : 0;">:</td>
                          <td class="p-0" style="border : 0;">Rp. @{{ formatPrice(engage.price) }}</td>
                        </tr>
                        <tr>
                          <td class="p-0" style="border : 0;">Lokasi</td>
                          <td class="pt-0 pb-0" style="border : 0;">:</td>
                          <td class="p-0" style="border : 0;">@{{ engage.regency }}</td>
                        </tr>
                        <tr>
                          <td class="p-0" style="border : 0;">Tanggal</td>
                          <td class="pt-0 pb-0" style="border : 0;">:</td>
                          <td class="p-0" style="border : 0;">2 April 2021 - 7 April 2021</td>
                        </tr>
                      </table>
                    </div>  
                  </div>
                  <div class="card-footer text-center">
                    <a href="#" @click='seeReport(engage.id)' class="btn btn-info" style="font-size: 12px;" v-if= 'engage.locked == "offer"'>Lihat Detail</a>
                    <a :href="'{{ url('/report_vendor_action') }}'+'/'+engage.id" class="btn btn-info" style="font-size: 12px;" v-if= 'engage.locked == "deal"'>Update Pekerjaan</a>
                  </div>
                </div>
              </div>
            </div>
          </main>
        </div>
      </div> 
    </div>
    

  @endsection
  @section('sec-js')
    <script type="text/javascript">
      var app = new Vue({
        el: '#app',
        data: {
            data: [],
            view: [],
            form: {},
            action: '',
            employee: [],
            thisEmployee: [],
        },
        mounted: function(){
          this.getData();
        },
        methods: {
          getData : function(){
            axios.post("{{ url('api/engagementVendor') }}",{ 'id' : "{{ session('id') }}", 'type': 'non'}).then(function(response){
              this.data = response.data.data;
            }.bind(this));
          },
          ucwords(str) {
              str = str.toLowerCase();
              str = str.toLowerCase().replace(/\b[a-z]/g, function(letter) {
                  return letter.toUpperCase();
              });

              return str;
          },
          seeReport : function(id){
            window.location ="{{ url('report_vendor') }}/"+id;
          },
          formatPrice(value) {
            let val = (value/1).toFixed(0).replace(',', ',')
            return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
          },
          actionEngagement : function(id){
            let forms = document.getElementById('actionForm');

            let data = new FormData(forms);

            if (this.action == '' || (this.action == 'acc' && data.get('employee[]') == null)) {
              Swal.fire(
                  'Warning!',
                  'Harap isi Aksi dan Surveyer.',
                  'warning'
              );
            }else{
              axios.post("{{ url('api/engagement/action') }}", data).then(function(response){
                app.$nextTick(() => {
                  $('#actionModal').modal('hide');
                  $("#example").DataTable();
                });
                Swal.fire(
                    'Success!',
                    'Survey diterima.',
                    'success'
                );
              }).then(()=>{
                this.getData();
              });
            }
          },
        }
      });

      $('.select2').select2({
        maximumSelectionLength: 3,
        allowClear: true,
        placeholder: 'Pilih Surveyer',
      });
    </script>
  @endsection
  
@endif