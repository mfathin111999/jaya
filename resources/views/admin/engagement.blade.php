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

      <div class="container-fluid" style="margin-top: 60px;">
        <div class="row">
          @include('layout.admin_side')
          <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
              <h1 class="h3 font-weight-bold">RESERVASI</h1>
              <div class="btn-toolbar mb-2 mb-md-0">
                
              </div>
            </div>
            
            <div class="table table-responsive">
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

                      <td v-if='item.status == "acc" && item.count == 0 && item.locked == "offer"'>Diterima</td>
                      <td v-if='item.status == "ignore"'>Ditolak</td>
                      <td v-if='item.status == "acc" && item.count > 0 && item.locked == "offer"'>Telah Disurvei</td>
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
            </div>
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
            employee: [],
            thisEmployee: [],
            thisReason: '',
        },
        created: function(){
          this.getData();
          this.getEmployee();
          this.getReason();
          this.valid();
        },
        methods: {
          getData : function(){
            if ('{{ session("role") }}' == 1) {
              axios.get("{{ url('api/engagement') }}").then(function(response){
                this.data = response.data.data;
                // console.log(this.data);
                this.$nextTick(() => {
                   $("#example").DataTable();
                });
              }.bind(this));
            }else if ('{{ session("role") }}' == 2) {
              let id = "{{ session('id') }}";
              let form = {
                'id' : id
              };
              axios.post("{{ url('api/engagementSurveyer') }}", form).then(function(response){
                this.data = response.data.data;
                // console.log(this.data);
                this.$nextTick(() => {
                   $("#example").DataTable();
                });
              }.bind(this));
            }else{
              let id = "{{ session('id') }}";
              let form = {
                'id' : id
              };
              axios.post("{{ url('api/engagementMandor') }}", form).then(function(response){
                this.data = response.data.data;
                // console.log(this.data);
                this.$nextTick(() => {
                   $("#example").DataTable();
                });
              }.bind(this));
            }
          },
          getReason : function(){
            axios.get("{{ url('api/getReason') }}").then(function(response){
              this.reason = response.data.data;
            }.bind(this));
          },
          viewData : function(id){
            axios.get("{{ url('api/engagement') }}/"+id).then(function(response){
              this.view = response.data.data;
            }.bind(this));
          },
          getEmployee : function(){
            axios.get("{{ url('api/user/getSurveyer') }}").then(function(response){
              this.employee = response.data.data;
            }.bind(this));
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
                }).then(()=>{
                  this.getData();
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