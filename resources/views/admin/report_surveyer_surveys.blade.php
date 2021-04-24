@extends('layout.app')

@if(session('id') == null || session('role') == 4)
  <script type="text/javascript">
    window.location = "{{ route('home') }}";
  </script>
@else

  @section('content')
  	@include('layout.admin_header')
    <div id="app" v-cloak>

      <!-- MODAL EDIT DETAIL -->
      <div class="modal fade" id="editModal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header" style="background-color: #ffc3c3;">
              <h5 class="modal-title" id="exampleModalLabel">Edit Detail Report</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form v-on:submit.prevent="saveReport()" id="form-edit">
              <div class="modal-body">
                <div class="row align-items-center">
                  <div class="col-12">
                    <div class="form-group">
                      <label for="name">Name</label>
                      <input type="hidden" class="form-control" id="id" v-model="view_report.id" name="id" required>
                      <input type="text" class="form-control" id="name" v-model="view_report.name" name="name" required>
                    </div>
                  </div>
                  <div class="col-12">
                    <div class="form-group">
                      <label for="description">Keterangan</label>
                      <input type="text" class="form-control" id="description" v-model="view_report.description" name="description" required>
                    </div>
                  </div>
                  <div class="col-4">
                    <div class="form-group">
                      <label for="volume">Volume</label>
                      <input type="text" class="form-control" id="volume" v-model="view_report.volume" name="volume" @keyup = 'filter' @keypress = 'isNumber' required>
                    </div>
                  </div>
                  <div class="col-4">
                    <div class="form-group">
                      <label for="unit">Unit</label>
                      <select class="form-control" required="" name= 'unit' id="unit" v-model='view_report.unit'>
                          <option value=''>Pilih Unit</option>
                          <option v-for='(units, index) in allunit' :value="units.data2">@{{ units.data2 }}</option>
                        </select>
                    </div>
                  </div>
                  <div class="col-4">
                    <div class="form-group">
                      <label for="time">Waktu Pengerjaan</label>
                      <input type="text" class="form-control" id="time" v-model="view_report.time" name="time" @keyup = 'filter' @keypress = 'isNumber' required>
                    </div>
                  </div>
                  <div class="col-6">
                    <div class="form-group">
                      <label for="price_clean">Harga Vendor</label>
                      <input type="text" class="form-control" id="price_clean" v-model="view_report.price_clean" name="price_clean" @keyup = 'filter' @keypress = 'isNumber' required>
                    </div>
                  </div>
                  <div class="col-6">
                    <div class="form-group">
                      <label for="price_dirt">Harga Customer</label>
                      <input type="text" class="form-control" id="price_dirt" v-model="view_report.price_dirt" name="price_dirt" @keyup = 'filter' @keypress = 'isNumber' required>
                    </div>
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
              </div>
            </form>
          </div>
        </div>
      </div>

      <!-- MODAL TAMBAH DETAIL -->

      <div class="modal fade" id="addModal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header" style="background-color: #ffc3c3;">
              <h5 class="modal-title" id="exampleModalLabel">Tambah Detail</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form v-on:submit.prevent="saveAddReport()" id="form-add">
              <div class="modal-body">
                <div class="row align-items-center">
                  <div class="col-12">
                    <div class="form-group">
                      <label for="name1">Name</label>
                      <input type="hidden" class="form-control" id="id1" v-model='id' name="reservation_id" required>
                      <input type="hidden" class="form-control" id="id2" v-model='id_step' name="step_id" required>
                      <input type="text" class="form-control" id="name1" name="name" required>
                    </div>
                  </div>
                  <div class="col-12">
                    <div class="form-group">
                      <label for="description1">Keterangan</label>
                      <input type="text" class="form-control" id="description1" name="description" required>
                    </div>
                  </div>
                  <div class="col-4">
                    <div class="form-group">
                      <label for="volume1">Volume</label>
                      <input type="text" class="form-control" id="volume1" name="volume" @keyup = 'filter' @keypress = 'isNumber' required>
                    </div>
                  </div>
                  <div class="col-4">
                    <div class="form-group">
                      <label for="unit1">Unit</label>
                      <select class="form-control" required="" name="unit" id="unit1">
                          <option value=''>Pilih Unit</option>
                          <option v-for='(units, index) in allunit' :value="units.data2">@{{ units.data2 }}</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-4">
                    <div class="form-group">
                      <label for="time1">Waktu Pengerjaan</label>
                      <input type="text" class="form-control" id="time1" name="time" @keyup = 'filter' @keypress = 'isNumber' required>
                    </div>
                  </div>
                  <div class="col-6">
                    <div class="form-group">
                      <label for="price_clean1">Harga Vendor</label>
                      <input type="text" class="form-control" id="price_clean1" name="price_clean" @keyup = 'filter' @keypress = 'isNumber' required>
                    </div>
                  </div>
                  <div class="col-6">
                    <div class="form-group">
                      <label for="price_dirt1">Harga Customer</label>
                      <input type="text" class="form-control" id="price_dirt1" name="price_dirt" @keyup = 'filter' @keypress = 'isNumber' required>
                    </div>
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
              </div>
            </form>
          </div>
        </div>
      </div>

      <!-- MODAL TAMBAH TANGGAL -->

      <div class="modal fade" id="addDate" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header" style="background-color: #ffc3c3;">
              <h5 class="modal-title" id="exampleModalLabel">Tambah Tanggal Pekerjaan</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form v-on:submit.prevent="addDate()" id="form-add-date">
              <div class="modal-body">
                <div class="row align-items-center">
                  <div class="col-12">
                    <div class="form-group">
                      <label for="date">Tanggal</label>
                      <input type="text" class="form-control" v-model='data.date_work' id="date_start" name="date" required>
                    </div>
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
              </div>
            </form>
          </div>
        </div>
      </div>

      <!-- MODAL TAMBAH TAHAPAN -->

      <div class="modal fade" id="addStep" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header" style="background-color: #ffc3c3;">
              <h5 class="modal-title" id="exampleModalLabel">Tambah Tahapan Pekerjaan</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form v-on:submit.prevent="saveStep()" id="form-add-step">
              <div class="modal-body">
                <div class="row align-items-center">
                  <div class="col-12">
                    <div class="form-group">
                      <label for="name_step">Nama Tahapan</label>
                      <input type="text" id="name_step" class="form-control" v-model='add_step.name' name="name" required>
                    </div>
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
              </div>
            </form>
          </div>
        </div>
      </div>

      <!-- Content -->
      <div class="container-fluid" style="margin-top: 60px;">
        <div class="row">
          @include('layout.admin_side')
          <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4 mt-4">
            <div class="card">
      				<div class="card-header">
      					<h3 class="text-center mb-4"><strong>KONFIRMASI LAPORAN SURVEYER</strong></h3>
                <div class="row">
                  <div class="col-md-6">
                    <div class="row">
                      <div class="col-md-3">Kode Booking</div>
                      <div class="col-md-1 text-center">:</div>
                      <div class="col-md-8"><strong>@{{ data.code }}</strong></div>
                      <div class="col-md-3">Nama Pelanggan</div>
                      <div class="col-md-1 text-center">:</div>
                      <div class="col-md-8"><strong>@{{ data.name }}</strong></div>
                      <div class="col-md-3">Tanggal Survey</div>
                      <div class="col-md-1 text-center">:</div>
                      <div class="col-md-8"><strong>@{{ data.date }} @{{ data.time }}</strong></div>
                    </div>
                  </div>
                </div>

      				</div>

              <div class="card-body" v-if = 'check > 0'>
                <div class="text-center">
                  <h4 class="font-weight-bold">LAPORAN TELAH TERKIRIM</h4>
                </div>
              </div>
    					<div class="card-body" v-if = 'check == 0'>

                <!-- INFORMASI RESERVASI -->

                <div class="row">
                  <div class="col-md-12 mb-4 mt-3 text-center">
                    <div class="pt-3 pb-3" style="background-color: #00000008; border: 1px solid #00000020;">
                      <label class="font-weight-bold m-0 h3">Informasi Reservasi</label>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="name">Nama Customer</label>
                      <input type="text" class="form-control" id="name" v-model='partner.name' disabled>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="phone_number">No. Handphone</label>
                      <input type="text" class="form-control" id="phone_number" v-model='partner.phone_number' disabled>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="email">Email</label>
                      <input type="email" class="form-control" id="email" v-model='partner.email' disabled>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="ktp">No Identitas</label>
                      <input type="text" class="form-control" id="ktp" v-model='partner.ktp' disabled>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                        <label for="province">Provinsi</label>
                        <select type="text" class="form-control" id="province" name="province_id" v-model='thisProvince' @change='getRegency()' required="">
                          <option value="">Choose</option>
                          <option v-for = '(province, index) in province' :value = 'province.id'>@{{ ucwords(province.name) }}</option>
                        </select>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                        <label for="regency">Kota/Kabupaten</label>
                        <select type="text" class="form-control" id="regency" name="regency_id" v-model='thisRegency' @change='getDistrict()' required="">
                          <option value="">Choose</option>
                                <option v-for = '(regency, index) in regency' :value="regency.id">@{{ ucwords(regency.name) }}</option>
                        </select>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                        <label for="district">Kecamatan</label>
                        <select type="text" class="form-control" id="district" name="district_id" v-model='thisDistrict' @change='getVillage()' required="">
                          <option value="">Choose</option>
                          <option v-for = '(district, index) in district' :value = 'district.id'>@{{ ucwords(district.name) }}</option>
                        </select>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                        <label for="village">Kelurahan</label>
                        <select type="text" class="form-control" id="village" name="village_id" v-model='thisVillage' required="">
                          <option value="">Choose</option>
                          <option v-for = '(village, index) in village' :value = 'village.id'>@{{ ucwords(village.name) }}</option>
                        </select>
                    </div>
                  </div>
                </div>

                <!-- TAHAPAN PEKERJAAN -->

    						<div class="row">
                  <div class="col-md-12 mb-4 mt-3 rounded text-center">
                    <div class="pt-3 pb-3 pl-2 pr-2" style="background-color: #00000008; border: 1px solid #00000020;">
                      <label class="font-weight-bold m-0 h3">Tahapan Pekerjaan</label>
                      <i class="btn btn-success fa fa-plus pull-right" data-toggle="modal" data-target="#addStep" v-if='data.locked == "offer"' @click='addDetail(report.id)'></i>
                    </div>
                  </div>
                  <div class="col-12 table-responsive" v-for='(report, index) in data.report'>
                    <table class="table table-bordered" width="100%">
                      <thead>
                        <tr>
                          <th colspan="8" style="vertical-align: middle;"><strong>Tahapan @{{ index+1 }} @{{ report.name }}</strong></th>
                          <th class="text-center">
                            <i class="btn btn-info fa fa-plus" data-toggle="modal" data-target="#addModal" v-if='data.locked == "offer"' @click='addDetail(report.id)'></i>
                          </th>
                        </tr>
                        <tr>
                          <td align="center"><strong>No</strong></td>
                          <td align="center" scope="col"><strong>Nama</strong></td>
                          <td align="center" scope="col"><strong>Volume</strong></td>
                          <td align="center" scope="col"><strong>Unit</strong></td>
                          <td align="center" scope="col"><strong>Waktu</strong></td>
                          <td align="center" scope="col"><strong>Aksi</strong></td>
                        </tr>
                      </thead>
                      <tbody>
                        <tr v-for='(detail, index3) in data.report[index].detail'>
                          <td align="center" style="vertical-align: middle;">@{{ index3+1 }}</td>
                          <td align="center" style="vertical-align: middle;">@{{ detail.name }}</td>
                          <td align="center" style="vertical-align: middle;">@{{ detail.volume }}</td>
                          <td align="center" style="vertical-align: middle;">@{{ detail.unit }}</td>
                          <td align="center" style="vertical-align: middle;">@{{ detail.time }}</td>
                          <td align="center" style="vertical-align: middle;">
                            <i class="btn btn-info fa fa-pencil" data-toggle="modal" data-target="#editModal" v-if='data.locked == "offer"' @click="getReport(detail.id)"></i>
                            <i class="btn btn-danger fa fa-trash" v-if='data.locked == "offer"' @click="delReport(detail.id)"></i>
                            <i class="btn btn-warning fa fa-check" v-if='data.locked == "deal"'></i>
                          </td>
                        </tr>
                      </tbody>
                    </table>
      						</div>
                </div>

                <!-- GAMBAR LAPANGAN
                 -->
                <div class="row mt-4">
                  <div class="col-md-12 pt-3 pb-3 rounded" style="background-color: #00000008; border: 1px solid #00000020;">
                    <label for="image_report" class="btn btn-sm btn-outline-secondary font-weight-bold m-0"><i class="fa fa-plus pr-2"></i>Tambah Gambar Report</label>
                    <input type="file" name="gambar" id="image_report" class="form-control" multiple="" @change="onFileChange" style="display: none;">
                  </div>
                  <div class="col-md-12 text-center" v-if= 'view_image.length == 0'>
                    <h4 class="font-weight-bold mt-4">GAMBAR KOSONG</h4>
                  </div>
                  <div class="col-md-3 text-right mt-3" v-for = "(image, index3) in view_image" >
                    <div>
                      <i class="fa fa-minus-circle btn btn-warning" @click='deleteItem(index3, 1)' style="position: absolute; top: 5%; right: 10%;"></i>
                      <img :src="image" class="img-fluid p-2" style="background-color: #00000008; border: 1px solid #00000020;">
                    </div>
                  </div>
                </div>

    					</div>
    					<div class="card-footer text-center">
    						<label class="m-0 font-weight-bold">Isi dengan hati - hati</label>
    					</div>
  			    </div>		
          </main>
        </div>
      </div> 
    </div>
    

  @endsection
  @section('sec-js')
    <script type="text/javascript" src="{{ asset('js/datatables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/v-mask.min.js') }}"></script>
    </script>
    <script type="text/javascript">
      Vue.use(VueMask.VueMaskPlugin);
      var report = new Vue({
        el: '#app',
        data: {
            check : 0,
            today : moment().format('YYYY-MM-DD'),
            id : '{{ $id }}',
            id_step : '',
            partner: {},
            view_report : {},
            add_report : {},
            add_form : {},
            add_date : {},
            add_step : {},
            data: {},
            vone: '',
            report: {},
            step: [],
            image: [],
            view: [],
            view_image: [],
            termin: [],
            vendor: [],
            allunit : [],
            province: {},
            allPlace: '',
            thisProvince: '',
            regency: {},
            thisRegency: '',
            district: {},
            thisDistrict: '',
            village: {},
            thisVillage: '',
        },
        mounted: function(){
          this.loadProvince();
          this.getData(this.id);
          this.allUnit();
        },
        methods: {
          getData : function(id){
            axios.get("{{ url('api/report/getByIdEngagement') }}/"+id).then(function(response){
              this.data = response.data.data;
              this.partner = response.data.data.partner;

            }.bind(this));
          },
          allUnit: function(){
            axios.get("{{ url('api/resource/all-unit') }}").then(function(response){
              this.allunit = response.data.data;
            }.bind(this));
          },
          getReport : function(id){
            axios.get("{{ url('api/report/getByIdReport') }}/"+id).then(function(response){
              this.view_report = response.data.data;
            }.bind(this));
          },
          delReport : function(id){
            Swal.fire({
              title: 'Apakah kamu yakin ?',
              text: 'Data yang dihapus tidak dapat dikembalikan !',
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Yes'
            }).then((result) => {
              if (result.isConfirmed) {
                axios.post("{{ url('api/report/destroy') }}/"+id).then(function(response){
                  this.getData(this.id);
                  Swal.fire('Success', 'Store Successfully .. !', 'success');
                }.bind(this));
              }
            });
          },
          saveStep : function(){
            let form = document.getElementById('form-add-step');
            let forms = new FormData(form);

            forms.append('type', 'step');
            forms.append('reservation_id', this.id);

            axios.post(
              "{{ url('api/report/store') }}",
              forms,
              {
                headers: {
                  'Content-Type': 'multipart/form-data',
                }
              }
            )
            .then(function (response) {
              report.$nextTick(() => {
                $("#addStep").modal('hide');
              });
            }).then(() => {
              this.getData(this.id);
              Swal.fire('Success', 'Update Successfully .. !', 'success');
            });
          },
          saveReport : function(){
            let form = document.getElementById('form-edit');
            let forms = new FormData(form);

            let price_dirt = forms.get('price_dirt');
            let price_clean = forms.get('price_clean');

            if (price_clean == 0 || price_dirt == 0 || price_clean == '' || price_dirt == '') {
              Swal.fire(
                'Oppss',
                'Harga Customer dan Harga Vendor harus di isi .. !',
                'warning'
                );
            }else if (parseInt(price_clean) >= parseInt(price_dirt) ) {
              Swal.fire(
                'Oppss',
                'Harga Customer harus lebih tinggi dari Harga Vendor',
                'warning'
                );
            }else{
              axios.post(
                "{{ url('api/report/update') }}",
                forms,
                {
                  headers: {
                    'Content-Type': 'multipart/form-data',
                  }
                }
              )
              .then(function (response) {
                report.$nextTick(() => {
                  $("#editModal").modal('hide');
                });
              }).then(() => {
                this.getData(this.id);
                Swal.fire('Success', 'Update Successfully .. !', 'success');
              });
            }
          },
          saveAddReport : function(id){
            let form = document.getElementById('form-add');
            let forms = new FormData(form);

            forms.append('type', 'detail');

            let price_dirt = forms.get('price_dirt');
            let price_clean = forms.get('price_clean');

            if (price_clean == 0 || price_dirt == 0 || price_clean == '' || price_dirt == '') {
              Swal.fire(
                'Oppss',
                'Harga Customer dan Harga Vendor harus di isi .. !',
                'warning'
                );
            }else if (parseInt(price_clean) >= parseInt(price_dirt) ) {
              Swal.fire(
                'Oppss',
                'Harga Customer harus lebih tinggi dari Harga Vendor',
                'warning'
                );
            }else{
              axios.post(
                "{{ url('api/report/store') }}",
                forms,
                {
                  headers: {
                    'Content-Type': 'multipart/form-data',
                  }
                }
              )
              .then(function (response) {
                report.$nextTick(() => {
                  form.reset();
                  $("#addModal").modal('hide');
                });
              }).then(() => {
                this.getData(this.id);
                Swal.fire('Success', 'Store Successfully .. !', 'success');
              });
            }
          },
          formatPrice(value) {
            let val = (value/1).toFixed(0).replace(',', ',')
            return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
          },
          addDetail : function(id){
            this.id_step = id;
          },
          submitform : function(){
            var form = new FormData();

            form.append('id', this.id);
            for( var i = 0; i < this.image.length; i++ ){
              let file = this.image[i];
              form.append('image[' + i + ']', file);
            }
            for( var i = 0; i < this.data.length; i++ ){
              let data = this.data[i];
              form.append('data[' + i + ']', data);
            }

            axios.post("{{ url('api/report/create') }}", form).then(function(response){
              // window.location = "{{ route('engagement') }}";
              console.log(response.data.data);
            });
          },
          addDate: function(){
            let form = document.getElementById('form-add-date');
            let forms = new FormData(form);

            forms.append('id', this.id);

            axios.post("{{ url('api/report/addDate') }}", 
              forms)
            .then(function(response){
              if (response.data.message == "Success") {
                Swal.fire(
                  'Berhasil',
                  'Tanggal sudah ditetapkan .. !',
                  'success'
                  )
              }else{
                Swal.fire(
                  'Ada yang salah',
                  'Harap Perhatikan Isian atau Hubungi Team Develover bila error terus muncul',
                  'warning'
                  )
              }
            }).then(()=>{
                report.$nextTick(() => {
                  $("#addDate").modal('hide');
                });
                this.getData(this.id);
            }); 
          },
          addPrice: function(item, index, index2){
            let price_clean = this.data.report[index].detail[index2].price_clean;
            let price_dirt = this.data.report[index].detail[index2].price_dirt;
            if(price_clean == 0 || price_dirt == 0)
            {
              Swal.fire(
                'Oppss',
                'Harga Customer dan Harga Vendor harus di isi .. !',
                'warning'
                );
            }else if(parseInt(price_clean) >= parseInt(price_dirt)){
              Swal.fire(
                'Oppss',
                'Harga Customer harus lebih tinggi dari Harga Vendor',
                'warning'
                );
            }else{
              Swal.fire({
                title: 'Apakah kamu yakin ?',
                text: "Kamu tidak bisa mengubah harga setelah harga ditetapkan",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes'
              }).then((result) => {
                if (result.isConfirmed) {
                  axios.post("{{ url('api/report/addPrice') }}", 
                    { 'id' : item, 'price_clean' : price_clean, 'price_dirt' : price_dirt })
                  .then(function(response){
                    if (response.data.message == "Success") {
                      Swal.fire(
                        'Berhasil',
                        'Harga sudah ditetapkan .. !',
                        'success'
                        )
                    }else{
                      Swal.fire(
                        'Ada yang salah',
                        'Harap Perhatikan Isian atau Hubungi Team Develover bila error terus muncul',
                        'warning'
                        )
                    }
                  }).then(()=>{
                      this.getData(this.id);
                  }); 
                }
              });
            }
          },
          editData: function(id){
            axios.post("{{ url('api/resource/update-resource') }}/"+id, this.view).then(function(response){
              app.$nextTick(() => {
                $("#editModal").modal('hide');
                $("#example").DataTable().destroy();
              });
            }).then(() => {
              this.getData();
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
          formatRupiah: function(e){
            var number_string = e.target.value.replace(/[^,\d]/g, '').toString(),
            split         = number_string.split(','),
            sisa          = split[0].length % 3,
            rupiah        = split[0].substr(0, sisa),
            ribuan        = split[0].substr(sisa).match(/\d{3}/gi);

            if(ribuan){
              separator = sisa ? '.' : '';
              rupiah += separator + ribuan.join('.');
            }
           
            rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
            
            e.target.value = rupiah;
          },
          isNumber: function(evt) {
            evt = (evt) ? evt : window.event;
            var charCode = (evt.which) ? evt.which : evt.keyCode;
            if ((charCode > 31 && (charCode < 48 || charCode > 57)) && charCode !== 46) {
              evt.preventDefault();;
            } else {
              return true;
            }
          },
          filter:function(e){
            e.target.value = e.target.value.replace(/[^0-9]+/g, '');
          },
        }
      });
      
    </script>
  @endsection

@endif