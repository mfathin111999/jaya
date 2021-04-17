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

      <!-- EDIT FORM -->

      <div class="modal fade" id="editModal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header" style="background-color: #ffc3c3;">
              <h5 class="modal-title" id="exampleModalLabel">Edit Worker</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form v-on:submit.prevent="submitEditForm(view.id)" id="form-edit">
              <div class="modal-body">
                <div class="row align-items-center">
                  <div class="col-6">
                    <div class="form-group">
                      <label for="name">Name</label>
                      <input type="text" class="form-control" id="name" v-model="view.name" name="name" required>
                    </div>
                  </div>
                  <div class="col-6">
                    <div class="form-group">
                      <label for="ktp">Email</label>
                      <input type="email" class="form-control" id="email" v-model="view.email" name="email" required>
                    </div>
                  </div>
                  <div class="col-6">
                    <div class="form-group">
                      <label for="phone">Phone Number</label>
                      <input type="text" class="form-control" id="phone" v-model="view.phone" name="phone" required>
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

      <!-- ADD FORM -->

      <div class="modal fade" id="addModal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header" style="background-color: #ffc3c3;">
              <h5 class="modal-title" id="exampleModalLabel">Add Worker</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form v-on:submit.prevent="submitAddForm()" id="form-add">
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
                      <label for="names">Username</label>
                      <input type="text" class="form-control" id="names" name="username" required>
                    </div>
                  </div>
                  <div class="col-6">
                    <div class="form-group">
                      <label for="emails">Email</label>
                      <input type="email" class="form-control" id="emails" name="email" required>
                    </div>
                  </div>
                  <div class="col-6">
                    <div class="form-group">
                      <label for="phones">Phone Number</label>
                      <input type="text" class="form-control" id="phones" name="phone" required>
                    </div>
                  </div>
                  <div class="col-6">
                    <div class="form-group">
                      <label for="passwords">Password</label>
                      <input type="text" class="form-control" id="passwords" name="password" required>
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
              <h1 class="h4 font-weight-bold">SURVEYER</h1>
              <div class="btn-toolbar mb-2 mb-md-0">
                <div class="btn-group mr-2">
                  <button class="btn btn-sm btn-outline-secondary" data-toggle="modal" data-target="#addModal" @click="addForm()"><i class="fa fa-plus pr-2"></i>Add</button>
                </div>
              </div>
            </div>

            <div class="table">
              <table id="example" class="table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Address</th>
                        <th>Phone Number</th>
                        <th>email</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for = "(item, index) in data">
                      <td>@{{ item.name }}</td>
                      <td>@{{ item.address }}</td>
                      <td>@{{ item.phone }}</td>
                      <td>@{{ item.email }}</td>
                      <td>@{{ item.status }}</td>
                      <td>
                        <a class="btn btn-info text-light" type="button" v-on:click='viewData(item.id)'><i class="fa fa-pencil"></i></a>
                        <a class="btn btn-danger text-light" type="button" v-on:click='deleteItem(item.id, index, 1)' v-if="item.status == 'active'"><i class="fa fa-trash"></i></a>
                        <a class="btn btn-warning text-light" type="button" v-on:click='deleteItem(item.id, index, 1)' v-if="item.status == 'deactive'"><i class="fa fa-trash"></i></a>
                      </td>
                    </tr>
                </tbody>
              </table>
            </div>

            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
              <h1 class="h4 font-weight-bold">MANDOR</h1>
              <div class="btn-toolbar mb-2 mb-md-0">
                <div class="btn-group mr-2">
                  <button class="btn btn-sm btn-outline-secondary" data-toggle="modal" data-target="#addModal" @click="addForm()"><i class="fa fa-plus pr-2"></i>Add</button>
                </div>
              </div>
            </div>

            <div class="table">
              <table id="example2" class="table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Address</th>
                        <th>Phone Number</th>
                        <th>email</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for = "(item, index) in dataMandor">
                      <td>@{{ item.name }}</td>
                      <td>@{{ item.address }}</td>
                      <td>@{{ item.phone }}</td>
                      <td>@{{ item.email }}</td>
                      <td>@{{ item.status }}</td>
                      <td>
                        <a class="btn btn-info text-light" type="button" v-on:click='viewData(item.id)'><i class="fa fa-pencil"></i></a>
                        <a class="btn btn-danger text-light" type="button" v-on:click='deleteItem(item.id, index, 1)' v-if="item.status == 'active'"><i class="fa fa-trash"></i></a>
                        <a class="btn btn-warning text-light" type="button" v-on:click='deleteItem(item.id, index, 1)' v-if="item.status == 'deactive'"><i class="fa fa-trash"></i></a>
                      </td>
                    </tr>
                </tbody>
              </table>
            </div>

            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
              <h1 class="h4 font-weight-bold">VENDOR</h1>
              <div class="btn-toolbar mb-2 mb-md-0">
                <div class="btn-group mr-2">
                  <button class="btn btn-sm btn-outline-secondary" data-toggle="modal" data-target="#addModal" @click="addForm()"><i class="fa fa-plus pr-2"></i>Add</button>
                </div>
              </div>
            </div>

            <div class="table">
              <table id="example3" class="table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Address</th>
                        <th>Phone Number</th>
                        <th>email</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for = "(item, index) in dataVendor">
                      <td>@{{ item.name }}</td>
                      <td>@{{ item.address }}</td>
                      <td>@{{ item.phone }}</td>
                      <td>@{{ item.email }}</td>
                      <td>@{{ item.status }}</td>
                      <td>
                        <a class="btn btn-info text-light" type="button" v-on:click='viewData(item.id)'><i class="fa fa-pencil"></i></a>
                        <a class="btn btn-danger text-light" type="button" v-on:click='deleteItem(item.id, index, 1)' v-if="item.status == 'active'"><i class="fa fa-trash"></i></a>
                        <a class="btn btn-warning text-light" type="button" v-on:click='deleteItem(item.id, index, 1)' v-if="item.status == 'deactive'"><i class="fa fa-trash"></i></a>
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
            dataVendor: [],
            dataMandor: [],
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
          this.getDataMandor();
          this.getDataVendor();
          this.loadProvince();
        },
        methods: {
          getData : function(){
            axios.get("{{ url('api/user/getSurveyer') }}").then(function(response){
              this.data = response.data.data;
              this.$nextTick(() => {
                 $("#example").DataTable();
              });
            }.bind(this));
          },
          getDataMandor : function(){
            axios.get("{{ url('api/user/getMandor') }}").then(function(response){
              this.dataMandor = response.data.data;
              this.$nextTick(() => {
                 $("#example2").DataTable();
              });
            }.bind(this));
          },
          getDataVendor : function(){
            axios.get("{{ url('api/user/getVendor') }}").then(function(response){
              this.dataVendor = response.data.data;
              this.$nextTick(() => {
                 $("#example3").DataTable();
              });
            }.bind(this));
          },
          viewData : function(id){
            axios.get("{{ url('api/user/getSurveyerById') }}/"+id).then(function(response){
              this.view = response.data.data;
              console.log(response.data.data);
              $("#editModal").modal('show');
            }.bind(this)).then(() => { 
              this.getAllAddress();
            });
          },
          submitAddForm : function(){
            let form = document.getElementById('form-add');
            let forms = new FormData(form);

            axios.post("{{ url('api/user/createWorker') }}", forms).then(function(response){
              app.$nextTick(() => {
                $("#addModal").modal('hide');
                $("#example").DataTable().destroy();
              });
            }).then(() => {
              this.getData();
              Swal.fire('Success', 'Update Successfully .. !', 'success');
            });
          },
          submitEditForm: function(id){
            let form = document.getElementById('form-edit');
            let forms = new FormData(form);

            axios.post(
              "{{ url('api/user/updateWorker') }}/"+id,
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
          deleteItem: function(id, index, type){
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
                axios.post("{{ url('api/user/actionSurveyer') }}/"+id, {action : type == 1 ? 'active' : 'deactive'}).then(function(response){
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
          ucwords(str){
            str = str.toLowerCase();
            str = str.toLowerCase().replace(/\b[a-z]/g, function(letter) {
                return letter.toUpperCase();
            });

            return str;
          },
        }
      });

      $(".select2").select2();
    </script>
  @endsection
  
@endif