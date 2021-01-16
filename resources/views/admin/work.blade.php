@extends('layout.app')
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
            <h5 class="modal-title" id="exampleModalLabel">Edit Worker</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form v-on:submit.prevent="onSubmitEmployyeEdit(view.id)" id="form-edit">
            <div class="modal-body">
              <div class="row align-items-center">
                <div class="col-6 text-center">
                  <div class="form-group">
                    <img :src="view.picture" alt="foto_profil" class="img-fluid"/>
                  </div>
                </div>
                <div class="col-6 text-center">
                  <div class="form-group">
                    <label for="picture" class="p-5" style="cursor: pointer; background-color: #d6ffca; border-radius: 10px;">Click hire to change picture</label>
                    <input type="file" class="form-control" id="picture" v-model="viewImage" style="display: none;" name="picture" v-on:change="onFileChange">
                  </div>
                </div>
                <div class="col-6">
                  <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" id="name" v-model="view.name" name="name" required>
                  </div>
                </div>
                <div class="col-6">
                  <div class="form-group">
                    <label for="ktp">ID Number</label>
                    <input type="text" class="form-control" id="ktp" v-model="view.ktp" name="ktp" required>
                  </div>
                </div>
                <div class="col-6">
                  <div class="form-group">
                    <label for="phone">Phone Number</label>
                    <input type="text" class="form-control" id="phone" v-model="view.phone_number" name="phone_number" required>
                  </div>
                </div>
                <div class="col-6">
                  <div class="form-group">
                    <label for="statuss">Status</label>
                    <select name="status" id="statuss" class="form-control" v-model="view.status" required>
                      <option value="">Choose</option>
                      <option value="active">Active</option>
                      <option value="deactive">Deactive</option>
                    </select>
                  </div>
                </div>
                <div class="col-12">
                  <div class="form-group">
                    <label for="address">Address</label>
                    <input type="text" class="form-control" id="address" v-model="view.address" name="address" required>
                  </div>
                </div>
                <div class="col-3">
                  <div class="form-group">
                    <label for="province">Province</label>
                    <select class="form-control" id="province" style="width: 100%;" v-model='thisProvince' v-on:change="getRegency()" name="province_id" required>
                      <option value="">Choose</option>
                      <option v-for = '(province, index) in province' :value="province.id">@{{ ucwords(province.name) }}</option>
                    </select>
                  </div>
                </div>
                <div class="col-3">
                  <div class="form-group">
                    <label for="regency">Regency</label>
                    <select class="form-control" id="regency" style="width: 100%;" v-model='thisRegency' @change="getDistrict()" name="regency_id" required>
                      <option value="">Choose</option>
                      <option v-for = '(regency, index) in regency' :value="regency.id">@{{ ucwords(regency.name) }}</option>
                    </select>
                  </div>
                </div>
                <div class="col-3">
                  <div class="form-group">
                    <label for="district">District</label>
                    <select class="form-control" id="district" style="width: 100%;" v-model='thisDistrict' @change="getVillage()" name="district_id" required>
                      <option value="">Choose</option>
                      <option v-for = '(district, index) in district' :value="district.id">@{{ ucwords(district.name) }}</option>
                    </select>
                  </div>
                </div>
                <div class="col-3">
                  <div class="form-group">
                    <label for="village">Village</label>
                    <select class="form-control" id="village" style="width: 100%;" v-model='thisVillage' name="village_id" required>
                      <option value="">Choose</option>
                      <option v-for = '(village, index) in village' :value="village.id">@{{ ucwords(village.name) }}</option>
                    </select>
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
            <h5 class="modal-title" id="exampleModalLabel">Add Worker</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form v-on:submit.prevent="onSubmitEmployyeAdd()" id="form-add">
            <div class="modal-body">
              <div class="row align-items-center">
                <div class="col-6 text-center">
                  <div class="form-group">
                    <img :src="newImg" alt="foto_profil" class="img-fluid"/ id="preview">
                    <label class="p-5 d-none" id="validation" style="cursor: pointer; background-color: #ffc3c3; border-radius: 10px;">Picture must be filled</label>
                  </div>
                </div>
                <div class="col-6 text-center">
                  <div class="form-group">
                    <label for="pictures" class="p-5" style="cursor: pointer; background-color: #d6ffca; border-radius: 10px;">Click hire to change picture</label>
                    <input type="file" class="form-control" id="pictures" style="display: none;" data = "1" name="picture" v-on:change="onFileChangeAdd">
                  </div>
                </div>
                <div class="col-6">
                  <div class="form-group">
                    <label for="names">Name</label>
                    <input type="text" class="form-control" id="names" name="name" required>
                  </div>
                </div>
                <div class="col-6">
                  <div class="form-group">
                    <label for="ktps">ID Number</label>
                    <input type="text" class="form-control" id="ktps" name="ktp" required>
                  </div>
                </div>
                <div class="col-6">
                  <div class="form-group">
                    <label for="phones">Phone Number</label>
                    <input type="text" class="form-control" id="phones" name="phone_number" required>
                  </div>
                </div>
                <div class="col-6">
                  <div class="form-group">
                    <label for="statuss">Status</label>
                    <select name="status" id="statuss" class="form-control" required>
                      <option value="">Choose</option>
                      <option value="active">Active</option>
                      <option value="deactive">Deactive</option>
                    </select>
                  </div>
                </div>
                <div class="col-12">
                  <div class="form-group">
                    <label for="addresss">Address</label>
                    <input type="text" class="form-control" id="addresss" name="address" required>
                  </div>
                </div>
                <div class="col-3">
                  <div class="form-group">
                    <label for="provinces">Province</label>
                    <select class="form-control" id="provinces" style="width: 100%;" v-model='thisProvince' v-on:change="getRegency()" name="province_id" required>
                      <option value="">Choose</option>
                      <option v-for = '(province, index) in province' :value="province.id">@{{ ucwords(province.name) }}</option>
                    </select>
                  </div>
                </div>
                <div class="col-3">
                  <div class="form-group">
                    <label for="regencys">Regency</label>
                    <select class="form-control" id="regencys" style="width: 100%;" v-model='thisRegency' @change="getDistrict()" name="regency_id" required>
                      <option value="">Choose</option>
                      <option v-for = '(regency, index) in regency' :value="regency.id">@{{ ucwords(regency.name) }}</option>
                    </select>
                  </div>
                </div>
                <div class="col-3">
                  <div class="form-group">
                    <label for="districts">District</label>
                    <select class="form-control" id="districts" style="width: 100%;" v-model='thisDistrict' @change="getVillage()" name="district_id" required>
                      <option value="">Choose</option>
                      <option v-for = '(district, index) in district' :value="district.id">@{{ ucwords(district.name) }}</option>
                    </select>
                  </div>
                </div>
                <div class="col-3">
                  <div class="form-group">
                    <label for="villages">Village</label>
                    <select class="form-control" id="villages" style="width: 100%;" v-model='thisVillage' name="village_id" required>
                      <option value="">Choose</option>
                      <option v-for = '(village, index) in village' :value="village.id">@{{ ucwords(village.name) }}</option>
                    </select>
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
                      <th>ID Number</th>
                      <th>Address</th>
                      <th>Phone Number</th>
                      <th>Picture</th>
                      <th>Status</th>
                      <th>Action</th>
                  </tr>
              </thead>
              <tbody>
                  <tr v-for = "(item, index) in data">
                    <td>@{{ item.name }}</td>
                    <td>@{{ item.ktp }}</td>
                    <td>@{{ item.address }}</td>
                    <td>@{{ item.phone_number }}</td>
                    <td>@{{ item.picture }}</td>
                    <td>@{{ item.status }}</td>
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
          newImg: '',
          viewImage: '',
          addViewImage: '',
          province: {},
          thisProvince: '',
          regency: {},
          thisRegency: '',
          district: {},
          thisDistrict: '',
          village: {},
          thisVillage: '',
          form:{
            name: '',
            type: '',
            description: '',
            price: '',
            unit: '',
          },
      },
      created: function(){
        this.getData();
        this.loadProvince();
      },
      methods: {
        getData : function(){
          axios.get("{{ url('api/employee') }}").then(function(response){
            this.data = response.data.data;
            this.$nextTick(() => {
               $("#example").DataTable();
            });
          }.bind(this));
        },
        viewData : function(id){
          axios.get("{{ url('api/employee') }}/"+id).then(function(response){
            this.view = response.data.data;
            $("#editModal").modal('show');
          }.bind(this)).then(() => { 
            this.getAllAddress();
          });
        },
        submitform : function(){
          axios.post("{{ url('api/employee/create-employee') }}", this.form).then(function(response){
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
              axios.post("{{ url('api/employee/destroy') }}/"+id).then(function(response){
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
        onFileChange(e) {
          const file = e.target.files[0];
          this.view.picture = URL.createObjectURL(file);
        },
        onFileChangeAdd(e, method = 0) {
          const file = e.target.files[0];
          this.newImg = URL.createObjectURL(file);
          
          let preview = document.getElementById('preview');
          let validation = document.getElementById('validation');
          preview.classList.remove('d-none');
          validation.classList.add('d-none');
        },
        addForm: function(){
            this.thisProvince = '';
            this.regency = {};
            this.thisRegency = '';
            this.district = {};
            this.thisDistrict = '';
            this.village = {};
            this.thisVillage = '';        
        },
        loadProvince(){
          axios.get("{{ url('api/province') }}").then(function(response){
            this.province = response.data.data;
            this.regency = {};
            this.thisRegency = '';
            this.district = {};
            this.thisDistrict = '';
            this.village = {};
            this.thisVillage = '';
          }.bind(this));
        },
        getRegency: function(){
          if (this.thisProvince != '') {
              axios.post("{{ url('api/regency') }}", {id: this.thisProvince}).then(function(response){
              this.regency = response.data.data;
              this.district = {};
              this.thisDistrict = '';
              this.village = {};
              this.thisVillage = '';
            }.bind(this));
          }
        },
        getDistrict: function(){
          if (this.thisRegency != '') {
            axios.post("{{ url('api/district') }}", {id: this.thisRegency}).then(function(response){
              this.district = response.data.data;
              this.village = {};
              this.thisVillage = '';
            }.bind(this));
          }
        },
        getVillage: function(){
          if (this.thisDistrict != '') {
            axios.post("{{ url('api/village') }}", {id: this.thisDistrict}).then(function(response){
              this.village = response.data.data;
            }.bind(this));
          }
        },
        getAllAddress: function(){
          if (this.view.village_id) {
            let str = (this.view.village_id).toString();
            this.thisProvince = str.substr(0, 2);
            this.thisRegency  = str.substr(0, 4);
            this.thisDistrict = str.substr(0, 7);
            this.thisVillage  = str;

            axios.post("{{ url('api/regency') }}", {id: this.thisProvince}).then(function(response){
              this.regency = response.data.data;
            }.bind(this)).then(() => {
              axios.post("{{ url('api/district') }}", {id: this.thisRegency}).then(function(response){
                this.district = response.data.data;
              }.bind(this));
            }).then(()=>{
              axios.post("{{ url('api/village') }}", {id: this.thisDistrict}).then(function(response){
                this.village = response.data.data;
              }.bind(this));
            });
          }
        },
        onSubmitEmployyeEdit: function(id){
          let form = document.getElementById('form-edit');
          let forms = new FormData(form);

          axios.post(
            "{{ url('api/employee/update-employee') }}/"+id,
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
        onSubmitEmployyeAdd: function(){
          let valid = document.getElementById('pictures').value;
          let preview = document.getElementById('preview');
          let validation = document.getElementById('validation');
          if (valid == '') {
            preview.classList.add('d-none');
            validation.classList.remove('d-none');
          }else{
            preview.classList.remove('d-none');
            validation.classList.add('d-none');
            let form = document.getElementById('form-add');
            let forms = new FormData(form);

            axios.post(
              "{{ url('api/employee/create-employee') }}",
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
