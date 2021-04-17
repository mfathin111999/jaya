@extends('layout.app')

@if(session('id') == null || session('role') == 4)
  <script type="text/javascript">
    window.location = "{{ route('home') }}";
  </script>
@else

  @section('content')
  	@include('layout.admin_header')
    <div id="app" v-cloak>

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
                      <div class="col-md-3">Vendor</div>
                      <div class="col-md-1 text-center">:</div>
                      <div class="col-md-8"><strong>@{{ data.vendor ? data.vendor.name : '-' }}</strong></div>
                      <div class="col-md-3">Tanggal Mulai</div>
                      <div class="col-md-1 text-center">:</div>
                      <div class="col-md-8" v-if= 'data.date_work != null' >
                        <strong>@{{ data.date_work }},</strong>
                      </div>
                      <div class="col-md-8" v-if= 'data.date_work == null' >
                        <strong>Belum Ditentukan</strong>
                      </div>
                    </div>
                  </div>
                </div>

      				</div>
    					<div class="card-body">

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
                    </div>
                  </div>
                  <div class="col-12 table-responsive" v-for='(report, index) in data.report'>
                    <table class="table table-bordered" width="100%">
                      <thead>
                        <tr>
                          <th colspan="8" style="vertical-align: middle;"><strong>Tahapan @{{ index+1 }} @{{ report.name }}</strong></th>
                        </tr>
                        <tr>
                          <td align="center"><strong>No</strong></td>
                          <td align="center" scope="col"><strong>Nama</strong></td>
                          <td align="center" scope="col"><strong>keterangan</strong></td>
                          <td align="center" scope="col"><strong>Volume</strong></td>
                          <td align="center" scope="col"><strong>Unit</strong></td>
                          <td align="center" scope="col"><strong>Waktu</strong></td>
                          <td align="center" scope="col"><strong>Harga</strong></td>
                        </tr>
                      </thead>
                      <tbody>
                        <tr v-for='(detail, index3) in data.report[index].detail'>
                          <td align="center" style="vertical-align: middle;">@{{ index3+1 }}</td>
                          <td align="center" style="vertical-align: middle;">@{{ detail.name }}</td>
                          <td align="center" style="vertical-align: middle;">@{{ detail.description }}</td>
                          <td align="center" style="vertical-align: middle;">@{{ detail.volume }}</td>
                          <td align="center" style="vertical-align: middle;">@{{ detail.unit }}</td>
                          <td align="center" style="vertical-align: middle;">@{{ detail.time }}</td>
                          <td align="center" style="vertical-align: middle;">
                            @{{ formatPrice(detail.price_clean) }}
                          </td>
                        </tr>
                        <tr>
                          <td colspan="6" align="center"><strong>Total Harga</strong></td>
                          <td align="center"><strong>@{{ formatPrice(report.all_price[0]) }}</strong></td>
                        </tr>
                      </tbody>
                    </table>
      						</div>
                </div>

                <!-- GAMBAR LAPANGAN
                 -->
                <div class="row mt-4">
                  <div class="col-md-12 rounded text-center">
                    <div class="pt-3 pb-3" style="background-color: #00000008; border: 1px solid #00000020;">
                      <label class="font-weight-bold m-0 h3">Gambar Lapangan</label>
                    </div>
                  </div>
                  <div class="col-md-3 text-right mt-3" v-for = "(image, index2) in data.gallery" >
                    <div>
                      <img :src="'../storage/'+data.gallery[index2].image" class="img-fluid p-2" style="background-color: #00000008; border: 1px solid #00000020;">
                    </div>
                  </div>
                </div>

                <!-- VENDOR LOCK-->

                <div v-if='data.customer_is == 1'>
                  <div class="row mt-4">
                    <div class="col-md-6 align-self-center text-center" v-if='data.vendor_is == 0'>
                      <div class="rounded pt-3 pb-3" style="background-color: #00000008; border: 1px solid #00000020;">
                        <label class="font-weight-bold h3">Penawaran</label><br>
                        <label class="font-weight-bold">Terima Semua Penawaran diatas ?</label>
                        <br>
                        <button class="btn btn-warning" @click='accAccept'><strong>Terima Penawaran</strong></button>
                        <button class="btn btn-danger" @click='notAccept'><strong>Tolak Penawaran</strong></button>
                      </div>
                    </div>
                    <div class="col-md-6 rounded text-center" v-if='data.vendor_is == 1'>
                      <div class="rounded pt-3 pb-3" style="background-color: #00000008; border: 1px solid #00000020;">
                        <label class="font-weight-bold h3">Vendor</label><br>
                        <label class="font-weight-bold">Penawaran Telah Terkunci</label>
                      </div>
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
            id : '{{ $id }}',
            id_step : '',
            partner: {},
            view_report : {},
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
            thisProvince: '',
            regency: {},
            thisRegency: '',
            district: {},
            thisDistrict: '',
            village: {},
            thisVillage: '',
        },
        mounted: function(){
          this.getData(this.id);
          this.allUnit();
          this.loadProvince();
        },
        methods: {
          getData : function(id){
            axios.get("{{ url('api/report/getByIdEngagement') }}/"+id).then(function(response){
              this.data = response.data.data;
              this.partner = response.data.data.customer;

              console.log(this.data);

              let termin = 0;
              for (var i = 0; i < this.data.report.length; i++) {
                if (this.data.report[i].termin > termin){
                  termin = this.data.report[i].termin
                }
              }

              if (termin != 0) {
                this.termin = [];
                for (var j = 0; j < termin; j++) {
                  this.termin.push({
                    step      : [],
                    vendor    : 0,
                    customer  : 0,
                  });
                  for (var k = 0; k < this.data.report.length; k++) {
                    if (this.data.report[k].termin-1 == j){
                      this.termin[j].step.push({
                        id    : this.data.report[k].id,
                        name  : this.data.report[k].name,
                        clean : this.data.report[k].all_price[0],
                        dirt  : this.data.report[k].all_price[1],
                      });
                    }
                  }
                }
              }

              for (var l = 0; l < this.termin.length; l++) {
                let total_clean = 0;
                let total_dirt  = 0;
                for (var m = 0; m < this.termin[l].step.length; m++) {
                  total_clean += this.termin[l].step[m].clean;
                  total_dirt += this.termin[l].step[m].dirt;

                  this.termin[l].vendor   = this.formatPrice(total_clean);
                  this.termin[l].customer = this.formatPrice(total_dirt);
                }
              }
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
          formatPrice(value) {
            let val = (value/1).toFixed(0).replace(',', ',')
            return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
          },
          addDetail : function(id){
            this.id_step = id;
          },
          addTermin : function(){

            this.termin.push({
              step      : [],
              vendor    : 0,
              customer  : 0,
            });
            // console.log(this.termin);
          },
          accAccept: function(){
            Swal.fire({
              title: 'Apakah kamu yakin ?',
              text: "Kamu tidak bisa mengubah keputusan setelah Penawaran diterima",
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Yes'
            }).then((result) => {
              if (result.isConfirmed) {
                let  forms = new FormData();
                forms.append('type', 'acc');

                axios.post("{{ url('api/engagement/accVendor') }}/"+this.id, forms).then(function(response){
                }).then(() => {
                  this.getData(this.id);
                });
              }
            })
          },
          notAccept: function(){
            Swal.fire({
              title: 'Apakah kamu yakin ?',
              text: "Kamu tidak bisa mengubah keputusan setelah Penawaran diterima",
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Yes'
            }).then((result) => {
              if (result.isConfirmed) {
                let forms = new FormData();
                forms.append('type', 'not');

                axios.post("{{ url('api/engagement/accVendor') }}/"+this.id, forms).then(function(response){
                }).then(() => {
                  this.getData(this.id);
                });
              }
            })
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