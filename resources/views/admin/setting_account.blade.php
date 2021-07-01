@extends('layout.app')

@section('content')
  @include('layout.admin_header')
    <div id="app" v-cloak>
      <div class="container-fluid" style="margin-top: 60px;">
        <div class="row">
          @include('layout.admin_side')
          <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
              <h1 class="h4 font-weight-bold">PENGATURAN AKUN</h1>
            </div>
            <div class="row align-self-center">
              <div class="col-md-8 mx-auto">
                <div class="card">
                  <form v-on:submit.prevent="onSubmitEdit(view.id)" id="form-edit">
                    <div class="card-body">
                      <div class="row align-items-center">
                        <div class="col-12">
                          <div class="form-group">
                            <label for="name">Nama Lengkap</label>
                            <input type="text" class="form-control" id="name" v-model ='data.name' name="name" required>
                          </div>
                        </div>
                        <div class="col-6">
                          <div class="form-group">
                            <label for="ktp">Email</label>
                            <input type="email" class="form-control" id="email" name="email" v-model ='data.email' disabled="">
                          </div>
                        </div>
                        <div class="col-6">
                          <div class="form-group">
                            <label for="phone">No. Handphone</label>
                            <input type="text" class="form-control" id="phone" name="phone" v-model ='data.phone' required>
                          </div>
                        </div>
                        <div class="col-12 mb-3 mt-2" style="border-top: 1px #ced4da solid;">
                        </div>
                        <div class="col-6">
                          <div class="form-group">
                            <label for="province">Provinsi</label>
                            <select class="form-control" id="province" style="width: 100%;" v-model = 'thisProvince' v-on:change="getRegency()" name="province_id" required>
                              <option value="">Pilih</option>
                              <option v-for = '(province, index) in province' :value="province.id">@{{ ucwords(province.name) }}</option>
                            </select>
                          </div>
                        </div>
                        <div class="col-6">
                          <div class="form-group">
                            <label for="regency">Kota / Kabupaten</label>
                            <select class="form-control" id="regency" style="width: 100%;" v-model = 'thisRegency' @change="getDistrict()" name="regency_id" required>
                              <option value="">Pilih</option>
                              <option v-for = '(regency, index) in regency' :value="regency.id">@{{ ucwords(regency.name) }}</option>
                            </select>
                          </div>
                        </div>
                        <div class="col-6">
                          <div class="form-group">
                            <label for="district">Kecamatan</label>
                            <select class="form-control" id="district" style="width: 100%;" v-model = 'thisDistrict' @change="getVillage()" name="district_id" required>
                              <option value="">Pilih</option>
                              <option v-for = '(district, index) in district' :value="district.id">@{{ ucwords(district.name) }}</option>
                            </select>
                          </div>
                        </div>
                        <div class="col-6">
                          <div class="form-group">
                            <label for="village">Desa</label>
                            <select class="form-control" id="village" style="width: 100%;" v-model = 'thisVillage' name="village_id" required>
                              <option value="">Pilih</option>
                              <option v-for = '(village, index) in village' :value="village.id">@{{ ucwords(village.name) }}</option>
                            </select>
                          </div>
                        </div>
                        <div class="col-12">
                          <div class="form-group">
                            <label for="address">Alamat</label>
                            <input type="text" class="form-control" id="address" v-model ='data.address' name="address" required>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="card-footer text-right">
                      <button type="submit" class="btn btn-success"><span style="font-size: 12px;">Simpan</span></button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </main>
        </div>
      </div>
    </div>

@endsection
@section('sec-js')
  <script type="text/javascript">
    var app = new Vue({
      el: '#app',
      data: {
          data: [],
          view: {},
          province: {},
          thisProvince: '',
          regency: {},
          thisRegency: '',
          district: {},
          thisDistrict: '',
          village: {},
          thisVillage: '',
      },
      created: function(){
        this.loadProvince();
        this.getData();
      },
      methods: {
        getData : function(){
          axios.post("{{ url('api/user/getMe') }}", {id : '{{ session("id") }}'}).then(function(response){
            this.data = response.data.data;
            this.thisProvince = response.data.data.province_id;
            this.thisRegency = response.data.data.regency_id;
            this.thisDistrict = response.data.data.district_id;
            this.thisVillage = response.data.data.village_id;
          }.bind(this)).then(() => {
            this.getAllAddress();
          });
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
          if (this.data.village_id) {

            let str = (this.data.village_id).toString();
            let Province = str.substr(0, 2);
            let Regency  = str.substr(0, 4);
            let District = str.substr(0, 7);

            axios.post("{{ url('api/regency') }}", {'id': Province}).then(function(response){
              this.regency = response.data.data;
            }.bind(this));
            axios.post("{{ url('api/village') }}", {'id': District}).then(function(response){
              this.village = response.data.data;
            }.bind(this));
            axios.post("{{ url('api/district') }}", {'id': Regency}).then(function(response){
              this.district = response.data.data;
            }.bind(this));
          }
        },
        onSubmitEdit: function(id){
          let form = document.getElementById('form-edit');
          let forms = new FormData(form);

          Swal.fire({
              text: "Apakah Anda yakin akan menyimpan perubahan ?",
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Yes'
            }).then((result) => {
              if (result.isConfirmed) {
                axios.post(
                  "{{ url('api/user/updateWorker') }}/"+"{{ session('id') }}",
                  forms,
                  {
                    headers: {
                      'Content-Type': 'multipart/form-data',
                    }
                  }
                )
                .then(function (response) {
                }).then(() => {
                  this.getData();
                  Swal.fire('Success', 'Update Successfully .. !', 'success');
                }).catch(error => {
                  var errors = error.response.data.error.email[0];
                  Swal.fire('Opss', errors, 'warning');
                });
              }
            });
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
