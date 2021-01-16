@extends('layout.app')
@section('sec-css')
  <link rel="stylesheet" type="text/css" href="{{ asset('css/datatables.min.css') }}">
@endsection

@section('content')
  @include('layout.admin_header')
  <div id="app" v-cloak>
    <div class="modal fade" id="editModal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                <div class="col-6">
                  <div class="form-group">
                    <label for="name">Nama</label>
                    <input type="text" class="form-control" id="name" v-model="view.name">
                  </div>
                </div>
                <div class="col-6">
                  <div class="form-group">
                    <label for="code">Booking Code</label>
                    <input type="text" class="form-control" id="book" v-model="view.code">
                  </div>
                </div>
                <div class="col-6">
                  <div class="form-group">
                    <label for="phone_number">Phone Number</label>
                    <input type="text" class="form-control" id="phone_number" v-model="view.phone_number">
                  </div>
                </div>
                <div class="col-6">
                  <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" v-model="view.email">
                  </div>
                </div>
                <div class="col-6">
                  <div class="form-group">
                    <label for="date">Date</label>
                    <input type="text" class="form-control" id="date" v-model="view.date">
                  </div>
                </div>
                <div class="col-6">
                  <div class="form-group">
                    <label for="time">Time</label>
                    <input type="text" class="form-control" id="time" v-model="view.time">
                  </div>
                </div>
                <div class="col-12">
                  <div class="form-group">
                    <label for="email">Description</label>
                    <textarea type="text" class="form-control" id="description" rows="3" v-model="view.description"></textarea>
                  </div>
                </div>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary">Save changes</button>
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
              <div class="btn-group mr-2">
                <button class="btn btn-sm btn-outline-secondary" data-toggle="modal" data-target="#editModal"><i class="fa fa-plus pr-2"></i>add</button>
              </div>
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
                      <th>Address</th>
                      <th>Date</th>
                      <th>Status</th>
                      <th>Description</th>
                      <th>Action</th>
                  </tr>
              </thead>
              <tbody>
                  <tr v-for = "(item, index) in data">
                    <td>@{{ item.name }}</td>
                    <td>@{{ item.service_id }}</td>
                    <td>@{{ item.email }}</td>
                    <td>@{{ item.province.name }} @{{ item.regency }} @{{ item.district_id }} @{{ item.village_id }}</td>
                    <td>@{{ item.date }} @{{ item.time }}</td>
                    <td>@{{ item.description }}</td>
                    <td>@{{ item.status }}</td>
                    <td>
                      <a class="btn btn-info" href="#" type="button" data-toggle="modal" data-target="#editModal" v-on:click='viewData(item.id)'><i class="fa fa-pencil"></i></a>
                      <a class="btn btn-danger" href="#" type="button" v-on:click='deleteItem(item.id, index)'><i class="fa fa-trash"></i></a>
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
            this.status = true;
            this.view = response.data.data;
          }.bind(this));
        },
        addForm : function(){
          this.status = false;
        },
        submitform : function(){
          axios.post("{{ url('api/engagement/create-engagement') }}", this.form).then(function(response){
            app.$nextTick(() => {
              $("#editModal").modal('hide');
              $("#example").DataTable().destroy();
            });
          }).then(() => {
            this.form = {};
            this.getData();
          });
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
        editData: function(id){
          axios.post("{{ url('api/engagement/update-engagement') }}/"+id, this.view).then(function(response){
            app.$nextTick(() => {
              $("#editModal").modal('hide');
              $("#example").DataTable().destroy();
            });
          }).then(() => {
            this.getData();
          });
        }
      }
    });
  </script>
@endsection
