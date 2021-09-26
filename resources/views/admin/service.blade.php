@extends('layout.app')

@if(auth()->user()->role != 1)
  <script type="text/javascript">
    window.location = "{{ route('home') }}";
  </script>
@else

  @section('sec-css')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/datatables.min.css') }}">
    <style type="text/css">
      .select2-selection{
        height: 37px !important;
      }
    </style>
  @endsection

  @section('content')
    @include('layout.admin_header')
    <div id="app" v-cloak>

      <div class="modal fade" id="editModal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header" style="background-color: #ffc3c3;">
              <h5 class="modal-title" id="exampleModalLabel">Edit Service</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form v-on:submit.prevent="onSubmitServiceEdit(view.id)" id="form-edit">
              <div class="modal-body">
                <div class="row align-items-center">
                  <div class="col-12">
                    <div class="form-group">
                      <label for="name">Name</label>
                      <input type="text" class="form-control" id="name" v-model="view.name" name="name" required>
                    </div>
                  </div>
                  <div class="col-12">
                    <div class="form-group">
                      <label for="description">Description</label>
                      <textarea type="text" class="form-control" id="description" name="description" v-model="view.description" v:text = 'view.description' required></textarea>
                    </div>
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
              </div>
            </form>
          </div>
        </div>
      </div>

      <div class="modal fade" id="addModal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header" style="background-color: #ffc3c3;">
              <h5 class="modal-title" id="exampleModalLabel">Add Service</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form v-on:submit.prevent="onSubmitServiceAdd()" id="form-add">
              <div class="modal-body">
                <div class="row align-items-center">
                  <div class="col-12">
                    <div class="form-group">
                      <label for="names">Name</label>
                      <input type="text" class="form-control" id="names" name="name" v-model = 'form.name' required>
                    </div>
                  </div>
                  <div class="col-12">
                    <div class="form-group">
                      <label for="descriptions">Description</label>
                      <textarea type="text" class="form-control" id="descriptions" name="description" v-model = 'form.description' required></textarea>
                    </div>
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
              </div>
            </form>
          </div>
        </div>
      </div>

      <div class="container-fluid" style="margin-top: 60px;">
        <div class="row">
          @include('layout.admin_side')
          <main role="main" class="col-lg-10 px-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
              <h1 class="h2">Worker</h1>
              <div class="btn-toolbar mb-2 mb-md-0">
                <div class="btn-group mr-2">
                  <button class="btn btn-sm btn-outline-secondary" data-toggle="modal" data-target="#addModal" @click="addForm()"><i class="fa fa-plus pr-2"></i>Add</button>
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
                        <th>Description</th>
                        <th>Steps</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for = "(item, index) in data">
                      <td>@{{ item.name }}</td>
                      <td>@{{ item.description }}</td>
                      <td>@{{ item.name }}</td>
                      <td>
                        <a class="btn btn-info text-light" type="button" v-on:click='viewData(item.id)'><i class="fa fa-pencil"></i></a>
                        <a class="btn btn-danger text-light" type="button" v-on:click='deleteItem(item.id, index)'><i class="fa fa-trash"></i></a>
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
            defaultImg : '{{ asset('img/default.png') }}',
            view: {},
            form: {},
        },
        created: function(){
          this.getData();
        },
        methods: {
          addForm : function(){
            this.view = {};
            this.form = {};
          },
          getData : function(){
            axios.get("{{ url('api/service') }}").then(function(response){
              this.data = response.data.data;
              this.$nextTick(() => {
                 $("#example").DataTable();
              });
            }.bind(this));
          },
          viewData : function(id){
            axios.get("{{ url('api/service') }}/"+id).then(function(response){
              this.view = response.data.data;
              $("#editModal").modal('show');
            }.bind(this));
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
                axios.post("{{ url('api/service/destroy') }}/"+id).then(function(response){
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
          onSubmitServiceEdit: function(id){
            let form = document.getElementById('form-edit');
            let forms = new FormData(form);

            axios.post(
              "{{ url('api/service/update-service') }}/"+id,
              forms,
              {
                headers: {
                  'Content-Type': 'multipart/form-data',
                }
              }
            )
            .then(function (response) {
              app.$nextTick(() => {
                $("#editModal").modal('hide');
                $("#example").DataTable().destroy();
              });
            }).then(() => {
              this.getData();
              Swal.fire('Success', 'Update Successfully .. !', 'success');
            });
          },
          onSubmitServiceAdd: function(){
            let form = document.getElementById('form-add');
            let forms = new FormData(form);

            axios.post(
              "{{ url('api/service/create-service') }}",
              forms,
              {
                headers: {
                  'Content-Type': 'multipart/form-data',
                }
              }
            )
            .then(function (response) {
              app.$nextTick(() => {
                $("#addModal").modal('hide');
                $("#example").DataTable().destroy();
              });
            }).then(() => {
              this.getData();
              Swal.fire('Success', 'Create Successfully .. !', 'success');
            });
          }
        }
      });
    </script>
  @endsection
  
@endif