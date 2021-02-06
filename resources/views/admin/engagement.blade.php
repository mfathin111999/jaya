@extends('layout.app')
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
            <h5 class="modal-title" id="exampleModalLabel">Konfirmasi Engagement</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form>
              <div class="row">
                <div class="col-12">
                  <div class="form-group">
                    <label for="name">Action</label>
                    <div class="row">
                      <div class="col-md-6">
                        <select class="form-control" v-model = 'action'>
                          <option value="">Pilih Aksi</option>
                          <option value="acc">Terima</option>
                          <option value="ignore">Tolak</option>
                        </select>
                      </div>
                      <div class="col-md-6">
                        <button type="button" class="btn btn-success btn-block" @click='actionEngagement(view.id)'>Kirim Aksi</button>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-6">
                  <div class="form-group">
                    <label for="name">Nama</label>
                    <input type="text" class="form-control" id="name" v-model="view.name" disabled="">
                  </div>
                </div>
                <div class="col-6">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="code">Booking Code</label>
                        <input type="text" class="form-control" id="book" v-model="view.code" disabled="">
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="phone_number">Phone Number</label>
                        <input type="text" class="form-control" id="phone_number" v-model="view.phone_number" disabled="">
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-6">
                  <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" v-model="view.email" disabled="">
                  </div>
                </div>
                <div class="col-6">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="date">Date</label>
                        <input type="text" class="form-control" id="date" v-model="view.date" disabled="">
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="time">Time</label>
                        <input type="text" class="form-control" id="time" v-model="view.time" disabled="">
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-12">
                  <div class="form-group">
                    <label for="service">Service</label>
                    <input type="text" class="form-control" id="service" v-model="view.service" disabled="">
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="address">Address</label>
                    <input type="text" class="form-control" id="address" :value="ucwords(view.address+' '+view.village+' '+view.district+' '+view.regency+' '+view.province)" disabled="">
                  </div>
                </div>
                <div class="col-12">
                  <div class="form-group">
                    <label for="email">Description</label>
                    <textarea type="text" class="form-control" id="description" rows="3" v-model="view.description" disabled=""></textarea>
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
            <h1 class="h2">Engagement</h1>
            <div class="btn-toolbar mb-2 mb-md-0">
              <button class="btn btn-sm btn-outline-secondary dropdown-toggle">
                <span data-feather="calendar"></span>
                This week
              </button>
            </div>
          </div>
          
          <div class="table">
            <table id="example" class="table table-striped table-bordered" style="width:100%">
              <thead>
                  <tr>
                      <th>Name</th>
                      <th>Service</th>
                      <th>Email</th>
                      <th>Date</th>
                      <th>Status</th>
                      <th>Action</th>
                  </tr>
              </thead>
              <tbody>
                  <tr v-for = "(item, index) in data">
                    <td>@{{ item.name }}</td>
                    <td>@{{ item.service }}</td>
                    <td>@{{ item.email }}</td>
                    <td>@{{ item.date }} @{{ item.time }}</td>
                    <td><span v-bind:class = 'item.status == "acc" ? "text-success" : "text-danger"' >@{{ item.status.toUpperCase() }}</span></td>
                    <td>
                      <a class="btn btn-info" href="#" type="button" data-toggle="modal" data-target="#actionModal" v-on:click='viewData(item.id)'><i class="fa fa-eye"></i></a>
                      <a class="btn btn-danger" href="#" type="button" v-on:click='deleteItem(item.id)'><i class="fa fa-trash"></i></a>
                      <a class="btn btn-success" href="#" type="button" v-on:click='addReport(item.id)' v-if='item.status != "pending || "'><i class="fa fa-pencil"></i></a>
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
          action: '',
      },
      created: function(){
        this.getData();
      },
      methods: {
         getData : function(){
          axios.get("{{ url('api/engagement') }}").then(function(response){
            this.data = response.data.data;
            console.log(this.data);
            this.$nextTick(() => {
               $("#example").DataTable();
            });
          }.bind(this));
        },
        viewData : function(id){
          axios.get("{{ url('api/engagement') }}/"+id).then(function(response){
            this.view = response.data.data;
          }.bind(this));
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
          if (this.action == '') {
            Swal.fire(
                'Warning!',
                'Harap isi Aksi.',
                'warning'
            );
          }else{
            let form = {
              'id' : id,
              'action' : this.action,
            };

            axios.post("{{ url('api/engagement/action') }}", form).then(function(response){
              app.$nextTick(() => {
                $('#example').DataTable().destroy();
                $('#actionModal').modal('hide');
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
  </script>
@endsection
