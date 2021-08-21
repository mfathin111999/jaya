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
      @if(auth()->user()->role == 1)
      <div class="modal fade" id="actionModal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Konfirmasi Reservasi</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form id="actionForm">
                <div class="row">
                  <div class="col-12 col-md-12">
                    <div class="form-group">
                      <div class="row">
                        <div class="col-12 col-md-6 mb-3">
                          <label for="action">Action</label>
                          <select class="form-control" v-model = 'action' id="action" name="action" @change="valid()">
                            <option value="">Pilih Aksi</option>
                            <option value="acc">Terima</option>
                            <option value="ignore">Tolak</option>
                          </select>
                        </div>
                        <div class="col-12 col-md-6 mb-3">
                          <label for="employee">Surveyer</label>
                          <select class="form-control select2" v-model="thisEmployee" multiple="multiple" name="employee[]" id="employee" style="width: 100%;">
                            <option v-for='(employee, index) in employee' :value='employee.id'>@{{ employee.name }}</option>
                          </select>
                        </div>
                        <div class="col-12 mb-3" v-if = 'action == "ignore"'>
                          <label for="reason">Alasan</label>
                          <select class="form-control" v-model="thisReason" name="reason" id="reason" style="width: 100%;">
                            <option value="">Pilih Alasan</option>
                            <option v-for='(item, index) in reason' :value='item.id'>@{{ item.reason }}</option>
                          </select>
                        </div>
                        <div class="col-12 col-md-12">
                          <button type="button" class="btn btn-success btn-block" @click='actionEngagement()'>Kirim Aksi</button>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-12 col-md-6">
                    <div class="form-group">
                      <label for="name">Nama</label>
                      <input type="hidden" class="form-control" id="id" name="id" v-model ='view.id'>
                      <input type="text" class="form-control" id="name" name="name" disabled="" v-model ='view.name'>
                    </div>
                  </div>
                  <div class="col-12 col-md-6">
                    <div class="row">
                      <div class="col-12 col-md-6">
                        <div class="form-group">
                          <label for="code">Booking Code</label>
                          <input type="text" class="form-control" id="code" name="code" disabled="" v-model ='view.code'>
                        </div>
                      </div>
                      <div class="col-12 col-md-6">
                        <div class="form-group">
                          <label for="phone_number">Phone Number</label>
                          <input type="text" class="form-control" id="phone_number" name="phone_number" disabled="" v-model ='view.phone_number'>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-12 col-md-6">
                    <div class="form-group">
                      <label for="email">Email</label>
                      <input type="email" class="form-control" id="email" name="email" disabled="" v-model ='view.email'>
                    </div>
                  </div>
                  <div class="col-6 col-md-3">
                    <div class="form-group">
                      <label for="date">Date</label>
                      <input type="text" class="form-control" id="date" name="date" disabled="" v-model ='view.date'>
                    </div>
                  </div>
                  <div class="col-6 col-md-3">
                    <div class="form-group">
                      <label for="time">Time</label>
                      <input type="text" class="form-control" id="time" name="time" disabled="" v-model ='view.time'>
                    </div>
                  </div>
                  <div class="col-md-6 col-12">
                    <div class="form-group">
                      <label for="address">Address</label>
                      <textarea type="text" class="form-control" id="address" name="address" disabled="" :value='ucwords(view.address+ ", " + view.village+ ", " + view.district+ ", " + view.regency+ ", " + view.province)'></textarea>
                    </div>
                  </div>
                  <div class="col-md-6 col-12">
                    <div class="form-group">
                      <label for="service">Service</label>
                      <textarea type="text" class="form-control" id="service" name="service" disabled="" v-model ='view.service'></textarea>
                    </div>
                  </div>
                  <div class="col-12">
                    <div class="form-group">
                      <label for="description">Description</label>
                      <textarea type="text" class="form-control" id="description" name="description" rows="3" disabled="" v-model ='view.description'></textarea>
                    </div>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      @endif
      <div class="container-fluid" style="margin-top: 60px;">
        <div class="row">
          @include('layout.admin_side')
          <main role="main" class="col-lg-10 px-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
              <h1 class="h3 font-weight-bold">RESERVASI</h1>
              <div class="btn-toolbar mb-2 mb-md-0">
                
              </div>
            </div>

            <div class="card" style="border-radius: 8px;">
              <div class="card-body">
                <div class="row px-3">
                  @if(auth()->user()->role == 1)
                  <div class="col-12 col-md-12 mb-3 d-none d-lg-block">
                    <label class="mb-0 mr-2">filter :</label>
                    <button :class="filter == 'pending' ? active : normal " :disabled="filter == 'pending' ? true : false" @click="getData('pending')">Pending @{{ filter == 'pending' ? '('+count+')' : '' }}</button>
                    <button :class="filter == 'offer' ? active : normal " :disabled="filter == 'offer' ? true : false" @click="getData('offer')">Diterima @{{ filter == 'offer' ? '('+count+')' : ''  }}</button>
                    <button :class="filter == 'post_offer' ? active : normal " :disabled="filter == 'post_offer' ? true : false" @click="getData('post_offer')">Telah Disurvei @{{ filter == 'post_offer' ? '('+count+')' : '' }}</button>
                    <button :class="filter == 'deal' ? active : normal " :disabled="filter == 'deal' ? true : false" @click="getData('deal')">Proses Pekerjaan @{{ filter == 'deal' ? '('+count+')' : '' }}</button>
                    <button :class="filter == 'ignore' ? active : normal " :disabled="filter == 'ignore' ? true : false" @click="getData('ignore')">Ditolak @{{ filter == 'ignore' ? '('+count+')' : '' }}</button>
                    <button :class="filter == 'finish' ? active : normal " :disabled="filter == 'finish' ? true : false" @click="getData('finish')">Selesai @{{ filter == 'finish' ? '('+count+')' : '' }}</button>
                  </div>
                  @endif

                  @if(auth()->user()->role == 2)
                  <div class="col-12 col-md-12 mb-3 d-none d-md-block">
                    <label class="mb-0 mr-2">filter :</label>
                    <button :class="filter == 'offer' ? active : normal " :disabled="filter == 'offer' ? true : false" @click="getData('offer')">Proses Survei @{{ filter == 'offer' ? '('+count+')' : ''  }}</button>
                    <button :class="filter == 'post_offer' ? active : normal " :disabled="filter == 'post_offer' ? true : false" @click="getData('post_offer')">Telah Disurvei @{{ filter == 'post_offer' ? '('+count+')' : '' }}</button>
                  </div>
                  @endif

                  @if(auth()->user()->role == 3)
                  <div class="col-12 col-md-12 mb-3 d-none d-md-block">
                    <label class="mb-0 mr-2">filter :</label>
                    <button :class="filter == 'deal' ? active : normal " :disabled="filter == 'deal' ? true : false" @click="getData('deal')">Proses Pekerjaan @{{ filter == 'deal' ? '('+count+')' : '' }}</button>
                  </div>
                  @endif

                  <div class="col-12 col-md-12 mb-3 d-none d-md-block">
                    <label class="mb-0 mr-2">Urutan :</label>
                    <button :class="order == 'desc' ? active : normal " :disabled="order == 'desc' ? true : false" @click="getData(filter, 'desc')">Terbaru</button>
                    <button :class="order == 'asc' ? active : normal " :disabled="order == 'asc' ? true : false" @click="getData(filter, 'asc')">Terlama</button>
                  </div>

                  @if(auth()->user()->role == 1)
                  <div class="col-12 col-md-12 mb-3 d-lg-none d-block">
                    <label class="mb-0 mr-2">filter :</label>
                    <select class="form-control font-12" v-model='filter' @change="getData(filter)">
                      <option value="pending">Pending</option>
                      <option value="offer">Diterima</option>
                      <option value="post_offer">Telah Disurvei</option>
                      <option value="deal">Telah Deal</option>
                      <option value="finish">Finish</option>
                      <option value="ignore">Ditolak</option>
                    </select>
                  </div>
                  @endif

                  @if(auth()->user()->role == 2)
                  <div class="col-12 col-md-12 mb-3 d-md-none d-block">
                    <label class="mb-0 mr-2">filter :</label>
                    <select class="form-control font-12" v-model='filter' @change="getData(filter)">
                      <option value="offer">Diterima</option>
                      <option value="post_offer">Telah Disurvei</option>
                    </select>
                  </div>
                  @endif

                  @if(auth()->user()->role == 3)
                  <div class="col-12 col-md-12 mb-3 d-md-none d-block">
                    <label class="mb-0 mr-2">filter :</label>
                    <select class="form-control font-12" v-model='filter' @change="getData(filter)">
                      <option value="deal">Telah Deal</option>
                    </select>
                  </div>
                  @endif

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
                        <h5 class="font-weight-bold font-14">@{{engage.code}} ( @{{ engage.service }} )</h5>
                        <div class="table-responsive">
                          <table class="table m-0" style="border : 0; line-height: 1.3rem;">
                            <tr>
                              <td class="p-0" width="20%" style="border : 0;">Pelanggan</td>
                              <td class="pt-0 pb-0" width="10%" style="border : 0;">:</td>
                              <td class="p-0" width="70%" style="border : 0;">@{{ engage.name }}</td>
                            </tr>
                            <tr>
                              <td class="p-0" width="20%" style="border : 0;">Email</td>
                              <td class="pt-0 pb-0" width="10%" style="border : 0;">:</td>
                              <td class="p-0" width="70%" style="border : 0;">@{{ engage.email }}</td>
                            </tr>
                            <tr>
                              <td class="p-0" style="border : 0;">Lokasi</td>
                              <td class="pt-0 pb-0" style="border : 0;">:</td>
                              <td class="p-0" style="border : 0;">@{{ engage.regency }}, @{{ engage.district }}</td>
                            </tr>
                            <tr>
                              <td class="p-0" style="border : 0;">Tanggal</td>
                              <td class="pt-0 pb-0" style="border : 0;">:</td>
                              <td class="p-0" style="border : 0;">@{{ moment(engage.date).format('LL') }}</td>
                            </tr>
                          </table>
                        </div>
                      </div>
                      <div class="col-12 col-md-4 text-center text-lg-left">
                        <div class="d-flex justify-content-between align-items-center">
                          <label class="m-0">Status Pekerjaan </label>
                          <span class="font-14 mb-2">
                            <label class="text-center m-0 font-weight-bold px-2 py-1 bg-warning mt-2 rounded" v-if='filter == "pending"'>Pending</label>
                            <label class="text-center m-0 font-weight-bold px-2 py-1 bg-danger text-white mt-2 rounded" v-if= 'filter == "ignore"'>Ditolak</label>
                            <label class="text-center m-0 font-weight-bold px-2 py-1 bg-success text-white mt-2 rounded" v-if= 'filter == "offer"'>Diterima</label>
                            <label class="text-center m-0 font-weight-bold px-2 py-1 bg-primary text-white mt-2 rounded" v-if= 'filter == "post_offer"'>Telah Disurvey</label>
                            <label class="text-center m-0 font-weight-bold px-2 py-1 bg-dark text-white mt-2 rounded" v-if= 'filter == "deal"'>Telah Deal</label>
                            <label class="text-center m-0 font-weight-bold px-2 py-1 bg-info text-white mt-2 rounded" v-if= 'filter == "finish"'>Finish</label>
                          </span>
                        </div>
                        <span class="d-block">
                          @if(auth()->user()->role == 1)
                            <button class="btn-block btn btn-info font-14" href="#" type="button" data-toggle="modal" data-target="#actionModal" v-on:click='viewData(engage.id)' v-if = 'engage.status == "pending" && filter == "pending"'>
                              Detail
                            </button>
                            <button class="btn-block btn btn-info font-14" href="#" type="button" v-on:click='addReport(engage.id)' v-if='engage.status == "acc" && engage.locked != "deal" && filter == "offer"'>
                              Detail
                            </button>
                            <button class="btn-block btn btn-info font-14" href="#" type="button" v-on:click='seeReport(engage.id)' v-if='engage.status == "acc" && engage.locked == "offer" && filter == "post_offer"'>
                              Detail
                            </button>
                            <button class="btn-block btn btn-info font-14" href="#" type="button" v-on:click='seeWork(engage.id)' v-if='engage.status == "acc" && engage.locked == "deal" && filter == "deal"'>
                              Detail
                            </button>
                          @elseif(auth()->user()->role == 2)
                            <button class="btn-block btn btn-info font-14" href="#" type="button" v-on:click='addReport(engage.id)' v-if='engage.customer_is != 1  && filter == "offer" || filter == "post_offer"'>
                              Detail
                            </button>
                          @elseif(auth()->user()->role == 3)
                            <button class="btn-block btn btn-info font-14" href="#" type="button" v-on:click='seeReportMandor(engage.id)' v-if='engage.status == "acc" && filter == "deal"'>
                              Detail
                            </button>
                          @endif
                        </span>
                       {{--  <a :href="'{{ url('/report_vendor') }}'+'/'+engage.id" class="btn btn-info" style="font-size: 12px;" v-if= 'engage.locked == "offer"'>Lihat Detail</a>
                        <a :href="'{{ url('/report_vendor_action') }}'+'/'+engage.id" class="btn btn-info" style="font-size: 12px;" v-if= 'engage.locked == "deal"'>Update Pekerjaan</a> --}}
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            
            {{-- <div class="table table-responsive">
              <table id="example" class="table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Code</th>
                        <th>Nama</th>
                        <th>Servis</th>
                        <th>Email</th>
                        <th>Kota</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for = "(item, index) in data" v-bind:class = 'item.status == "acc" ? "table-success" : (item.status == "pending" ? "table-warning" : "table-danger")'>
                      <td>@{{ item.date }} @{{ item.time }}</td>
                      <td>@{{ item.code }} </td>
                      <td>@{{ item.name }} </td>
                      <td>@{{ item.service }}</td>
                      <td>@{{ item.email }}</td>
                      <td>@{{ item.regency }}</td>

                      <td v-if='item.status == "acc" && item.count == 0 && item.locked == "offer"'>Reservasi Diterima</td>
                      <td v-if='item.status == "ignore"'>Ditolak</td>
                      <td v-if='item.status == "acc" && item.count > 0 && item.locked == "offer"'>
                        <span v-if='item.customer_is != 1 && item.vendor_is != 1'>Telah Disurvei</span>
                        <span v-if='item.customer_is == 1 && item.vendor_is != 1'>Customer Setuju</span>
                        <span v-if='item.customer_is == 1 && item.vendor_is == 1'>Customer & Vendor Setuju</span>
                      </td>
                      <td v-if='item.status == "acc" && item.locked == "deal"'>Telah Disepakati</td>
                      <td v-if='item.status == "pending"'>Belum Dikonfirmasi</td>

                      <td>
                        @if(auth()->user()->role == 1)
                        <a class="btn btn-info" href="#" type="button" data-toggle="modal" data-target="#actionModal" v-on:click='viewData(item.id)' v-if = 'item.status == "pending"'><i class="fa fa-eye"></i></a>
                        <!-- <a class="btn btn-danger" href="#" type="button" v-on:click='deleteItem(item.id)' v-if='item-status'><i class="fa fa-trash"></i></a> -->
                        <a class="btn btn-success" href="#" type="button" v-on:click='addReport(item.id)' v-if='item.status == "acc" && item.locked != "deal" && item.count == 0'><i class="fa fa-pencil"></i></a>
                        <a class="btn btn-primary" href="#" type="button" v-on:click='seeReport(item.id)' v-if='item.status == "acc" && item.locked != "deal" &&  item.count > 0'><i class="fa fa-list-alt"></i></a>
                        <a class="btn btn-info" href="#" type="button" v-on:click='seeWork(item.id)' v-if='item.status == "acc" && item.locked == "deal"'><i class="fa fa-cog"></i></a>
                        <!-- <a class="btn btn-success" href="#" type="button" v-on:click='addReport(item.id)' v-if='item.status != "acc"'><i class="fa fa-pencil"></i></a> -->
                        @elseif(auth()->user()->role == 2)
                        <a class="btn btn-success" href="#" type="button" v-on:click='addReport(item.id)' v-if='item.customer_is != 1'><i class="fa fa-pencil"></i></a>
                        @elseif(auth()->user()->role == 3)
                        <a class="btn btn-primary" href="#" type="button" v-on:click='seeReportMandor(item.id)' v-if='item.status == "acc" && item.count > 0'><i class="fa fa-list-alt"></i></a>
                        @endif
                      </td>
                    </tr>
                </tbody>
              </table>
            </div> --}}
          </main>
        </div>
      </div> 
    </div>
    

  @endsection
  @section('sec-js')
    <script type="text/javascript" src="{{ asset('js/datatables.min.js') }}"></script>
    <script type="text/javascript">
      var app = new Vue({
        el: '#app',
        data: {
            data: [],
            view: [],
            form: {},
            reason: {},
            action: '',
            active: 'btn btn-success m-2',
            normal: 'btn btn-outline-secondary m-2',
            @if(auth()->user()->role == 1)
            filter : 'pending',
            @elseif(auth()->user()->role == 2)
            filter : 'offer',
            @else
            filter : 'deal',
            @endif
            order : 'desc',
            count : 0,
            employee: [],
            thisEmployee: [],
            thisReason: '',
        },
        created: function(){
          this.getData(this.filter);
          this.getEmployee();
          this.getReason();
          this.valid();
        },
        methods: {
          getData : function(filter = this.filter, order = 'desc'){
            this.filter = filter;
            this.order = order;
            axios.post("{{ url('api/engagement') }}", {'filter' : this.filter, 'order' : this.order, _method : 'GET'}).then(function(response){
              this.data = response.data.data.data;
              this.count = response.data.data.count;
            }.bind(this))
            .catch(error => {
              Swal.fire('Opss', 'Terjadi Kesalahan <br> Harap hubungi team Developer', 'warning');
            });
          },
          getReason : function(){
            axios.get("{{ url('api/getReason') }}").then(function(response){
              this.reason = response.data.data;
            }.bind(this));
          },
          viewData : function(id){
            axios.get("{{ url('api/engagement') }}/"+id).then(function(response){
              this.view = response.data.data;
            }.bind(this))
            .catch(error => {
              Swal.fire('Opss', 'Terjadi Kesalahan <br> Harap hubungi team Developer', 'warning');
            });
          },
          getEmployee : function(){
            axios.get("{{ url('api/user/getSurveyer') }}").then(function(response){
              this.employee = response.data.data;
            }.bind(this))
            .catch(error => {
              Swal.fire('Opss', 'Terjadi Kesalahan <br> Harap hubungi team Developer', 'warning');
            });
          },
          valid: function() {
            if (this.action == 'acc') {
              document.getElementById('employee').disabled = false;
            }else{
              document.getElementById('employee').disabled = true;
            }
          },
          ucwords(str) {
              str = str.toLowerCase();
              str = str.toLowerCase().replace(/\b[a-z]/g, function(letter) {
                  return letter.toUpperCase();
              });

              return str;
          },
          seeReport : function(id){
            window.location ="{{ url('report_view') }}/"+id;
          },
          seeReportMandor : function(id){
            window.location ="{{ url('/report_mandor') }}/"+id;
          },
          seeWork : function(id){
            window.location ="{{ url('/report_supervisor_action') }}/"+id;
          },
          addReport : function(id){
            // axios.get("{{ url('api/report') }}/"+id).then(function(response){
            //   if (response != 0) {
            //     window.location ="{{ url('report_survey') }}/"+id;
            //   }else{

            //   }
            // }.bind(this));

            window.location ="{{ url('report_survey') }}/"+id;

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
              if (this.action == 'ignore' && (this.thisReason == null || this.thisReason == '' )) {
                Swal.fire(
                  'Warning!',
                  'Harap isi alasan penolakan.',
                  'warning'
                );
              }else{
                axios.post("{{ url('api/engagement/action') }}", data).then(function(response){
                  app.$nextTick(() => {
                    $('#actionModal').modal('hide');
                    $("#example").DataTable();
                  });
                  if (this.action == 'ignore') {
                    Swal.fire(
                        'Success!',
                        'OK! Reservasi Ditolak.',
                        'success'
                    );
                  }else{
                    Swal.fire(
                        'Success!',
                        'Survey diterima.',
                        'success'
                    );
                  }
                })
                .then(()=>{
                  this.getData();
                })
                .catch(error => {
                  Swal.fire('Opss', 'Terjadi Kesalahan <br> Harap hubungi team Developer', 'warning');
                });
              }
            }
          },
          deleteItem: function(id){
            Swal.fire({
              title: 'Are you sure?',
              text: "You won't be able to revert this!",
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Yes'
            }).then((result) => {
              if (result.isConfirmed) {
                axios.post("{{ url('api/engagement/destroy') }}/"+id).then(function(response){
                  app.$nextTick(() => {
                    $('#example').DataTable().destroy();
                  });
                }).then(() => {
                    Swal.fire(
                      'Deleted!',
                      'Your file has been deleted.',
                      'success'
                  )
                })
                .catch(error => {
                  Swal.fire('Opss', 'Terjadi Kesalahan <br> Harap hubungi team Developer', 'warning');
                });
                this.getData();
              }
            })
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