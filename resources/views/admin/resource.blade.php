@extends('layout.app')

@if(auth()->user()->role != 1)
  <script type="text/javascript">
    window.location = "{{ route('home') }}";
  </script>
@else

  @section('sec-css')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/datatables.min.css') }}">
    <style type="text/css">
      .dataTables_filter input{
        max-width: 100px;
      }
    </style>
  @endsection

  @section('content')
    @include('layout.admin_header')
    <div id="app" v-cloak>

      <div class="modal fade" id="editModal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel" v-if = 'status == "edit" && type == "unit"'>Edit Unit</h5>
              <h5 class="modal-title" id="exampleModalLabel" v-if = 'status == "add" && type == "unit"'>Tambah Unit</h5>
              <h5 class="modal-title" id="exampleModalLabel" v-if = 'status == "edit" && type == "reason"'>Edit Alasan</h5>
              <h5 class="modal-title" id="exampleModalLabel" v-if = 'status == "add" && type == "reason"'>Tambah Alasan</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form>
                {{-- UNIT --}}

                <div class="row" v-if="type == 'unit'">
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

                {{-- REASON --}}
                <div class="row" v-if="type == 'reason'">
                  <div class="col-12">
                    <div class="form-group">
                      <label for="reason">Alasan</label>
                      <input type="text" class="form-control" id="reason" v-model="view.reason" v-if = 'status == "edit"'>
                      <input type="text" class="form-control" id="reason" v-if = 'status == "add"' v-model = 'form.reason'>
                    </div>
                  </div>
                </div>

              </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
              <button type="button" class="btn btn-primary" v-on:click = 'editData(view.id)' v-if = 'status == "edit"'>Simpan Perubahan</button>
              <button type="button" class="btn btn-primary" v-on:click = 'submitform()' v-if = 'status == "add"'>Tambah Data</button>
            </div>
          </div>
        </div>
      </div>

      <div class="container-fluid" style="margin-top: 60px;">
        <div class="row">
          @include('layout.admin_side')
          <main role="main" class="col-lg-10 px-4">
            <div class="row">
              <div class="col-12 col-md-6">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                  <h3 class="h3">Unit</h3>
                  <div class="btn-toolbar mb-2 mb-md-0">
                    <div class="btn-group mr-2">
                      <button class="btn btn-sm btn-outline-secondary" data-toggle="modal" data-target="#editModal" v-on:click='addForm("unit")'><i class="fa fa-plus pr-2"></i>Tambah</button>
                    </div>
                  </div>
                </div>
                <div class="table-responsive">
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
                        <tr v-for = "(item, index) in data" :id='"unit"+item.id'>
                          <td>@{{ item.name }}</td>
                          <td>@{{ item.data2 }}</td>
                          <td>@{{ item.data1 }}</td>
                          <td class="text-center">
                            <button class="btn btn-info" type="button" data-toggle="modal" data-target="#editModal" v-on:click='viewData(item.id, "unit")'><i class="fa fa-pencil"></i></button>
                            <button class="btn btn-danger" type="button" v-on:click='deleteItem(item.id, "unit")'><i class="fa fa-trash"></i></button>
                          </td>
                        </tr>
                    </tbody>
                  </table>
                </div>
              </div>
              <div class="col-12 col-md-6">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                  <h3 class="h3">Alasan</h3>
                  <div class="btn-toolbar mb-2 mb-md-0">
                    <div class="btn-group mr-2">
                      <button class="btn btn-sm btn-outline-secondary" data-toggle="modal" data-target="#editModal" v-on:click='addForm("reason")'><i class="fa fa-plus pr-2"></i>Tambah</button>
                    </div>
                  </div>
                </div>
                <div class="table-responsive">
                  <table id="reason-table" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Alasan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for = "(item, index) in reason" :id='"reason"+item.id'>
                          <td class="text-center" width="20">@{{ (index++)+1 }}</td>
                          <td>@{{ item.reason }}</td>
                          <td class="text-center">
                            <button class="btn btn-info" type="button" data-toggle="modal" data-target="#editModal" v-on:click='viewData(item.id, "reason")'><i class="fa fa-pencil"></i></button>
                            <button class="btn btn-danger" type="button" v-on:click='deleteItem(item.id, "reason")'><i class="fa fa-trash"></i></button>
                          </td>
                        </tr>
                    </tbody>
                  </table>
                </div>
              </div>
              <div class="col-12">
                <table id="example"></table>
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
      Vue.config.devtools = true;
      var app = new Vue({
        el: '#app',
        data: {
            data: [],
            reason: [],
            fake: [],
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
        mounted (){
          this.getData();
          this.getReason();
        },
        methods: {
          getData : function(){
            axios.get("{{ url('api/resource') }}").then(function(response){
              this.data = response.data.data;
              this.$nextTick(() => {
                 $("#unit-table").DataTable(); 
              });
            }.bind(this))
            .catch(function (error) {
              console.log(error);
            });
          },
          getReason : function(){
            axios.get("{{ url('api/getReason') }}").then(function(response){
              this.reason = response.data.data;
              this.$nextTick(() => {
                 $("#reason-table").DataTable();
              });
            }.bind(this));
          },
          addForm : function(type){
            this.status = 'add';
            this.type   = type;
          },
          viewData : function(id, type){
            if (type == 'unit') {
              axios.get("{{ url('api/resource') }}/"+id).then(function(response){
                this.status = 'edit';
                this.type   = type;
                this.view   = response.data.data;
              }.bind(this));
            }else if (type == 'reason') {
              axios.post("{{ url('api/viewReason') }}", {id : id, _method: 'GET'}).then(function(response){
              console.log(response);
                this.status = 'edit';
                this.type   = type;
                this.view   = response.data.data;
              }.bind(this));
            }
          },
          submitform : function(){
            if (this.type == 'unit') {
              axios.post("{{ url('api/resource/create-unit') }}", this.form).then(function(response){
                app.$nextTick(() => {
                  $("#editModal").modal('hide');
                  $("#unit-table").DataTable().destroy();
                });
                this.getData();
              }.bind(this));
            }else if (this.type == 'reason'){
              axios.post("{{ url('api/storeReason') }}", this.form).then(function(response){
                app.$nextTick(() => {
                  $("#editModal").modal('hide');
                  $("#reason-table").DataTable().destroy();
                });
                this.getReason();
              }.bind(this));
            }
          }, 
          deleteItem: function(id, type){
            Swal.fire({
              title: 'Apakah kamu yakin ?',
              text: "Kamu tidak dapat mengembalikan data yang telah terhapus",
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Iya',
              cancelButtonText: 'Batal'
            }).then((result) => {
              if (result.isConfirmed) {
                if (type == 'unit') {
                  axios.post("{{ url('api/resource/destroy') }}/"+id).then(function(response){
                    let index = this.data.findIndex((item) => item.id === id);
                    if (index !== -1) {
                      this.data.splice(index, 1);
                    }

                    app.$nextTick(()=>{
                      $('#unit-table').DataTable().row('#unit'+id).remove().draw(false);
                    });

                    Swal.fire(
                      'Terhapus !',
                      'Unit telah terhapus.',
                      'success'
                    )
                  }.bind(this))
                }else if (type == 'reason') {
                  axios.post("{{ url('api/destroyReason') }}", {'id' : id}).then(function(response){
                    let index = this.reason.findIndex((item) => item.id === id);
                    if (index !== -1) {
                      this.reason.splice(index, 1);
                    }

                    app.$nextTick(()=>{
                      $('#reason-table').DataTable().row('#reason'+id).remove().draw(false);
                    });

                    Swal.fire(
                      'Terhapus !',
                      'Alasan telah terhapus.',
                      'success'
                    )
                  }.bind(this));
                }
              }
              
            })
          },
          editData: function(id){

            const _this = this;
            if (_this.type == 'unit') {
              axios.post("{{ url('api/resource/update-unit') }}/"+id, this.view).then(function(response){
                const update = response.data.data;


                this.fake = this.data;
                let index = this.data.findIndex((item) => item.id === update.id);

                if (index !== -1) {
                  this.fake[index] = update;
                  app.$nextTick(() => {
                    $("#editModal").modal('hide');
                  });

                  this.data = [];
                  this.data = this.fake; 
                }else{
                  $("#editModal").modal('hide');
                }
              }.bind(this));
            }else if (_this.type == 'reason') {
              console.log(this.view);
              axios.post("{{ url('api/updateReason') }}", this.view).then(function(response){
                const update = response.data.data;

                this.fake = this.reason;
                let index = this.reason.findIndex((item) => item.id === update.id);

                if (index !== -1) {
                  this.fake[index] = update;
                  app.$nextTick(() => {
                    $("#editModal").modal('hide');
                  });

                  this.reason = [];
                  this.reason = this.fake; 
                }else{
                  $("#editModal").modal('hide');
                }
              }.bind(this));
            }
          },

        }
      });
    </script>
  @endsection

@endif