@extends('layout.app')

@if(session('id') == null || session('role') == 4)
  <script type="text/javascript">
    window.location = "{{ route('home') }}";
  </script>
@else

  @section('sec-css')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/datatables.min.css') }}">
    <style type="text/css">
      .shadow-cards{
        box-shadow: 0 1px 6px 0 rgba(49, 53, 59, 0.12); 
        border-radius: 8px;
      }
    </style>
  @endsection

  @section('content')
    @include('layout.admin_header')
    <div id="app" v-cloak>

      <div class="container-fluid" style="margin-top: 60px;">
        <div class="row">
          @include('layout.admin_side')
          <main role="main" class="col-lg-10 px-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2">
              <h1 class="h3 font-weight-bold">RESERVASI</h1>
            </div>
            
            <div class="card" style="border-radius: 8px;">
              <div class="card-body">
                <div class="row px-3">
                  <div class="col-12 col-md-12 mb-3 d-none d-lg-block">
                    <label class="mb-0 mr-2">filter :</label>
                    <button :class="filter == 'offer' ? active : normal " :disabled="filter == 'offer' ? true : false" @click="getData('offer')">Penawaran @{{ filter == 'offer' ? '('+count+')' : ''  }}</button>
                    <button :class="filter == 'deal' ? active : normal " :disabled="filter == 'deal' ? true : false" @click="getData('deal')">Proses Pekerjaan @{{ filter == 'deal' ? '('+count+')' : '' }}</button>
                    <button :class="filter == 'finish' ? active : normal " :disabled="filter == 'finish' ? true : false" @click="getData('finish')">Selesai @{{ filter == 'finish' ? '('+count+')' : '' }}</button>
                  </div>
                  <div class="col-12 col-md-12 mb-3 d-none d-lg-block">
                    <label class="mb-0 mr-2">Urutan :</label>
                    <button :class="order == 'desc' ? active : normal " :disabled="order == 'desc' ? true : false" @click="getData(filter, 'desc')">Terbaru</button>
                    <button :class="order == 'asc' ? active : normal " :disabled="order == 'asc' ? true : false" @click="getData(filter, 'asc')">Terlama</button>
                  </div>
                  <div class="col-12 col-md-12 mb-3 d-lg-none d-block">
                    <label class="mb-0 mr-2">filter :</label>
                    <select class="form-control font-12" v-model='filter' @change="getData(filter)">
                      <option value="offer">Penawaran</option>
                      <option value="deal">Proses Pekerjaan</option>
                      <option value="finish">Selesai</option>
                    </select>
                  </div>
                  <div class="col-12 col-md-12 mb-3 d-md-none d-block">
                    <label class="mb-0 mr-2">Urutan :</label>
                    <select class="form-control font-12" v-model='order' @change="getData(filter)">
                      <option value="desc">Terbaru</option>
                      <option value="asc">Terlama</option>
                    </select>
                  </div>
                  <div class="col-md-12 p-3 mb-3 shadow-cards text-center" v-if='data.length == 0'>
                    <label class="m-0 font-weight-bold">data tidak ditemukan</label>
                  </div>
                  <div class="col-md-12 p-3 mb-3 shadow-cards" v-if='data.length != 0' v-for='(engage, index) in data'>
                    <div class="row">
                      <div class="col-md-8 col-12 mb-3">
                        <h5 class="font-weight-bold font-14">@{{ engage.service }}</h5>
                        <div class="table-responsive">
                          <table class="table m-0" style="border : 0; line-height: 1.5rem;">
                            <tr>
                              <td class="p-0" width="20%" style="border : 0;">Pelanggan</td>
                              <td class="pt-0 pb-0" width="10%" style="border : 0;">:</td>
                              <td class="p-0" width="70%" style="border : 0;">@{{ engage.name }}</td>
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
                              <td class="p-0" style="border : 0;">@{{ moment(engage.date).format('LL') }}</td>
                            </tr>
                          </table>
                        </div>
                      </div>
                      <div class="col-12 col-md-4 text-right text-lg-left">
                        <label class="m-0">Status Pekerjaan</label>
                        <span class="font-14 mb-3 d-block">
                          <label class="m-0 font-weight-bold p-2 bg-warning mt-2 rounded" v-if='engage.locked == "offer" && engage.vendor_is == 0'>Proses Penawaran</label>
                          <label class="m-0 font-weight-bold p-2 bg-success text-white mt-2 rounded" v-if= 'engage.locked == "deal"'>Penawaran Telah Disetujui</label>
                          <label class="m-0 font-weight-bold p-2 bg-danger text-white mt-2 rounded" v-if= 'engage.vendor_is == 99'>Anda telah menolak penawaran</label>
                        </span>
                        <a :href="'{{ url('/report_vendor') }}'+'/'+engage.id" class="btn btn-info" style="font-size: 12px;" v-if= 'engage.locked == "offer"'>Lihat Detail</a>
                        <a :href="'{{ url('/report_vendor_action') }}'+'/'+engage.id" class="btn btn-info" style="font-size: 12px;" v-if= 'engage.locked == "deal"'>Update Pekerjaan</a>
                      </div>
                    </div>
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
            active: 'btn btn-success mx-2',
            normal: 'btn btn-outline-secondary mx-2',
            filter : 'offer',
            order : 'desc',
            count : 0,
            action: '',
            employee: [],
            thisEmployee: [],
        },
        mounted: function(){
          this.getData(this.filter);
        },
        methods: {
          getData : function(filter, order = 'desc'){
            this.filter = filter;
            this.order = order;
            axios.post("{{ url('api/engagementVendor') }}",{ 'id' : "{{ session('id') }}", 'filter': filter, 'order' : this.order}).then(function(response){
              this.data = response.data.data;
              this.count = response.data.message;
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