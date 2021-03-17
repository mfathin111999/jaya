@extends('layout.app')

@if(session('id') == null || session('role') != 1)
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

    <div class="modal fade" id="editModal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel" v-if = 'status == "edit" && type == "unit"'>Edit Unit</h5>
              <h5 class="modal-title" id="exampleModalLabel" v-if = 'status == "add" && type == "unit"'>Tambah Unit</h5>
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
                      <input type="text" class="form-control" id="name" v-model="view.name" v-if = 'status == "edit"'>
                      <input type="text" class="form-control" id="name" v-if = 'status == "add"' v-model = 'form.name'>
                    </div>
                  </div>
                  <div class="col-6">
                    <div class="form-group">
                      <label for="code">Singkatan</label>
                      <input type="text" class="form-control" id="type" v-model="view.data2" v-if = 'status == "edit"'>
                      <input type="text" class="form-control" id="type" v-if = 'status == "add"' v-model = 'form.data2'>
                    </div>
                  </div>
                  <div class="col-12">
                    <div class="form-group">
                      <label for="email">Deskripsi</label>
                      <textarea type="text" class="form-control" id="description" rows="3" v-model="view.data1" v-if = 'status == "edit"'></textarea>
                      <textarea type="text" class="form-control" id="description" rows="3" v-if = 'status == "add"' v-model = 'form.data1'></textarea>
                    </div>
                  </div>
                </div>
              </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary" v-on:click = 'editData(view.id)' v-if = 'status == "edit"'>Simpan Perubahan</button>
              <button type="button" class="btn btn-primary" v-on:click = 'submitform()' v-if = 'status == "add"'>Tambah Data</button>
            </div>
          </div>
        </div>
      </div>

      <div class="container-fluid" style="margin-top: 60px;">
        <div class="row">
          @include('layout.admin_side')
          <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
            <div class="row">
              <div class="col-6">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                  <h3 class="h3">UNIT</h3>
                  <div class="btn-toolbar mb-2 mb-md-0">
                    <div class="btn-group mr-2">
                      <button class="btn btn-sm btn-outline-secondary" data-toggle="modal" data-target="#editModal" v-on:click='addForm("unit")'><i class="fa fa-plus pr-2"></i>Tambah</button>
                    </div>
                  </div>
                </div>
                <div class="table">
                  <table id="unit-table" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th>Satuan</th>
                            <th>Singkatan</th>
                            <th>Deskripsi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for = "(item, index) in data.unit">
                          <td>@{{ item.name }}</td>
                          <td>@{{ item.data2 }}</td>
                          <td>@{{ item.data1 }}</td>
                          <td>
                            <a class="btn btn-info" href="#" type="button" data-toggle="modal" data-target="#editModal" v-on:click='viewData(item.id, "unit")'><i class="fa fa-pencil"></i></a>
                            <a class="btn btn-danger" href="#" type="button" v-on:click='deleteItem(item.id, index)'><i class="fa fa-trash"></i></a>
                          </td>
                        </tr>
                    </tbody>
                  </table>
                </div>
              </div>
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
            view: {},
            status: '',
            type: '',
            form:{
              name: '',
              type: '',
              description: '',
              price: '',
              unit: '',
            }
        },
        created: function(){
          this.getData();
        },
        methods: {
          getData : function(){
            axios.get("{{ url('api/resource') }}").then(function(response){
              this.data = response.data.data;
              console.log(this.data);
              this.$nextTick(() => {
                 $("#unit-table").DataTable();
              });
            }.bind(this));
          },
          addForm : function(type){
            this.status = 'add';
            this.type   = type;
          },
          viewData : function(id, type){
            axios.get("{{ url('api/resource') }}/"+id).then(function(response){
              this.status = 'edit';
              this.type   = type;
              this.view = response.data.data;
            }.bind(this));
          },
          submitform : function(){
            axios.post("{{ url('api/resource/create-unit') }}", this.form).then(function(response){
              app.$nextTick(() => {
                $("#editModal").modal('hide');
                $("#unit-table").DataTable().destroy();
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
                axios.post("{{ url('api/resource/destroy') }}/"+id).then(function(response){
                  app.$nextTick(() => {
                    $('#unit-table').DataTable().destroy();
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
            axios.post("{{ url('api/resource/update-unit') }}/"+id, this.view).then(function(response){
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

@endif