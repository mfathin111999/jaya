@extends('layout.app')

@if(session('id') == null || session('role') == 4)
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
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header" style="background-color: #ffc3c3;">
              <h5 class="modal-title" id="exampleModalLabel">Edit Vendor</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form v-on:submit.prevent="onSubmitVendorEdit(view.id)" id="form-edit">
              <div class="modal-body">
                <div class="row align-items-center">
                  <div class="col-6">
                    <div class="form-group">
                      <label for="name">Name</label>
                      <input type="text" class="form-control" id="name" name="name" required v-model = 'view.name'>
                    </div>
                  </div>
                  <div class="col-6">
                    <div class="form-group">
                      <label for="email">Email</label>
                      <input type="text" class="form-control" id="email" name="email" required v-model = 'view.email'>
                    </div>
                  </div>
                  <div class="col-6">
                    <div class="form-group">
                      <label for="phone_number">No. Handphone</label>
                      <input type="text" class="form-control" id="phone_number" name="phone_number" required v-model = 'view.phone_number'>
                    </div>
                  </div>
                  <div class="col-6" v-if = 'view.vendor == "yes"'>
                    <div class="form-group">
                      <label for="tax_id">Tax ID</label>
                      <input type="text" class="form-control" id="tax_id" name="tax_id" required v-model = 'view.tax_id'>
                    </div>
                  </div>
                  <div class="col-6">
                    <div class="form-group">
                      <label for="customer">Customer</label>
                      <input type="text" class="form-control" id="customer" name="customer" required v-model = 'view.customer'>
                    </div>
                  </div>
                  <div class="col-6" v-if = 'view.vendor == "yes"'>
                    <div class="form-group">
                      <label for="vendor">Vendor</label>
                      <input type="text" class="form-control" id="vendor" name="vendor" required v-model = 'view.vendor'>
                    </div>
                  </div>
                  <div class="col-6" v-if = 'view.vendor == "yes"'>
                    <div class="form-group">
                      <label for="bank_name">Nama Bank</label>
                      <input type="text" class="form-control" id="bank_name" name="bank_name" required v-model = 'view.bank_name'>
                    </div>
                  </div>
                  <div class="col-6" v-if = 'view.vendor == "yes"'>
                    <div class="form-group">
                      <label for="bank_account_number">No Akun Bank</label>
                      <input type="text" class="form-control" id="bank_account_number" name="bank_account_number" required v-model = 'view.bank_account_number'>
                    </div>
                  </div>
                  <div class="col-6" v-if = 'view.vendor == "yes"'>
                    <div class="form-group">
                      <label for="bank_account_name">Atas Nama</label>
                      <input type="text" class="form-control" id="bank_account_name" name="bank_account_name" required v-model = 'view.bank_account_name'>
                    </div>
                  </div>
                  <div class="col-6" v-if = 'view.vendor == "yes"'>
                    <div class="form-group">
                      <label for="owner">Owner</label>
                      <input type="text" class="form-control" id="owner" name="owner" required v-model = 'view.owner'>
                    </div>
                  </div>
                  <div class="col-12">
                    <div class="form-group">
                      <label for="address">Address</label>
                      <textarea rows="2" type="text" class="form-control" id="address" name="address" required v-model = 'view.address'></textarea>
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
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header" style="background-color: #ffc3c3;">
              <h5 class="modal-title" id="exampleModalLabel">Tambah Vendor</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form v-on:submit.prevent="onSubmitVendorAdd()" id="form-add">
              <div class="modal-body">
                <div class="row align-items-center">
                  <div class="col-6">
                    <div class="form-group">
                      <label for="names">Name</label>
                      <input type="text" class="form-control" id="names" name="name" required>
                    </div>
                  </div>
                  <div class="col-6">
                    <div class="form-group">
                      <label for="emails">Email</label>
                      <input type="text" class="form-control" id="emails" name="email" required>
                    </div>
                  </div>
                  <div class="col-6">
                    <div class="form-group">
                      <label for="phone_numbers">No. Handphone</label>
                      <input type="text" class="form-control" id="phone_numbers" name="phone_number" required>
                    </div>
                  </div>
                  <div class="col-6">
                    <div class="form-group">
                      <label for="tax_ids">Tax ID</label>
                      <input type="text" class="form-control" id="tax_ids" name="tax_id" required>
                    </div>
                  </div>
                  <div class="col-6">
                    <div class="form-group">
                      <label for="customers">Customer</label>
                      <input type="text" class="form-control" id="customers" name="customer" required>
                    </div>
                  </div>
                  <div class="col-6">
                    <div class="form-group">
                      <label for="vendors">Vendor</label>
                      <input type="text" class="form-control" id="vendors" name="vendor" required>
                    </div>
                  </div>
                  <div class="col-6">
                    <div class="form-group">
                      <label for="bank_names">Nama Bank</label>
                      <input type="text" class="form-control" id="bank_names" name="bank_name" required>
                    </div>
                  </div>
                  <div class="col-6">
                    <div class="form-group">
                      <label for="bank_account_numbers">No Akun Bank</label>
                      <input type="text" class="form-control" id="bank_account_numbers" name="bank_account_number" required>
                    </div>
                  </div>
                  <div class="col-6">
                    <div class="form-group">
                      <label for="bank_account_names">Atas Nama</label>
                      <input type="text" class="form-control" id="bank_account_names" name="bank_account_name" required>
                    </div>
                  </div>
                  <div class="col-6">
                    <div class="form-group">
                      <label for="owners">Owner</label>
                      <input type="text" class="form-control" id="owners" name="owner" required>
                    </div>
                  </div>
                  <div class="col-12">
                    <div class="form-group">
                      <label for="addresss">Address</label>
                      <textarea rows="2" type="text" class="form-control" id="addresss" name="address" required></textarea>
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
          <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
              <h1 class="h2">Vendor</h1>
              <div class="btn-toolbar mb-2 mb-md-0">
                <div class="btn-group mr-2">
                  <button class="btn btn-sm btn-outline-secondary" data-toggle="modal" data-target="#addModal"><i class="fa fa-plus pr-2"></i>Tambah Vendor</button>
                </div>
              </div>
            </div>
            <div class="table">
              <table id="example" class="table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th>Tax ID</th>
                        <th>Search Key</th>
                        <th>Customer</th>
                        <th>Vendor</th>
                        <th>Name</th>
                        <th>Bank</th>
                        <th>Bank Account Number</th>
                        <th>Bank Account Name</th>
                        <th>Owner</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for = "(item, index) in data">
                      <td>@{{ item.tax_id }}</td>
                      <td>@{{ item.search_key }}</td>
                      <td>@{{ item.customer }}</td>
                      <td>@{{ item.vendor }}</td>
                      <td>@{{ item.name }}</td>
                      <td>@{{ item.bank_name }}</td>
                      <td>@{{ item.bank_account_number }}</td>
                      <td>@{{ item.bank_account_name }}</td>
                      <td>@{{ item.owner }}</td>
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
            view: {},
        },
        created: function(){
          this.getData();
        },
        methods: {
          getData : function(){
            axios.get("{{ url('api/vendor/allBusiness') }}").then(function(response){
              this.data = response.data.data;
              this.$nextTick(() => {
                 $("#example").DataTable();
              });
            }.bind(this));
          },
          viewData : function(id){
            axios.get("{{ url('api/vendor') }}/"+id).then(function(response){
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
                axios.post("{{ url('api/vendor/destroy') }}/"+id).then(function(response){
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
          onSubmitVendorEdit: function(id){
            let form = document.getElementById('form-edit');
            let forms = new FormData(form);

            axios.post(
              "{{ url('api/vendor/update-vendor') }}/"+id,
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
          onSubmitVendorAdd: function(){
            let form = document.getElementById('form-add');
            let forms = new FormData(form);

            axios.post(
              "{{ url('api/vendor/create-vendor') }}",
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

      function ucwords(str) {
          str = str.toLowerCase();
          str = str.toLowerCase().replace(/\b[a-z]/g, function(letter) {
              return letter.toUpperCase();
          });

          return str;
      }

      $(".select2").select2();
    </script>
  @endsection

@endif