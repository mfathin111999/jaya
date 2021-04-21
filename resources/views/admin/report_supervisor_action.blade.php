@extends('layout.app')

@if(session('id') == null || session('role') != 1)
  <script type="text/javascript">
    window.location = "{{ route('home') }}";
  </script>
@else

  @section('content')
    @include('layout.admin_header')
    <div id="app" v-cloak>

      <div class="modal fade" id="info_engage" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header" style="background-color: #ffc3c3;">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-md-12 mb-4 mt-3 text-center">
                  <div class="pt-2 pb-2" style="background-color: #00000008; border: 1px solid #00000020;">
                    <label class="font-weight-bold m-0 h5">Informasi Reservasi</label>
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
                <div class="col-md-12">
                  <div class="form-group">
                      <label for="village">Alamat</label>
                      <input type="text" class="form-control" name="address" v-model='partner.address' disabled="">
                  </div>
                </div>
              </div>

              <div class="row mt-4">
                <div class="col-md-12 rounded text-center">
                  <div class="pt-2 pb-2" style="background-color: #00000008; border: 1px solid #00000020;">
                    <label class="font-weight-bold m-0 h5">Gambar Lapangan</label>
                  </div>
                </div>
                <div class="col-md-3 text-right mt-3" v-for = "(image, index2) in data.gallery" >
                  <div>
                    <img :src="'../storage/'+data.gallery[index2].image" class="img-fluid p-2" style="background-color: #00000008; border: 1px solid #00000020;">
                  </div>
                </div>
              </div>

            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
          </div>
        </div>
      </div>


      <div class="modal fade" id="addPayment" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header" style="background-color: #ffc3c3;">
              <h5 class="modal-title" id="exampleModalLabel">Lihat Detail</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form v-on:submit.prevent="sendPayment(view_report.id)" id="form-add-pay">
              <div class="modal-body">
                <div class="row align-items-center">
                  <div class="col-12 mb-2">
                    <label class="m-0">Total Pembayaran</label>
                  </div>
                  <div class="col-12 mb-2">
                    <label class="m-0 h5 font-weight-bold">Rp. @{{ priceCleanVendor }}</label>
                  </div>
                  <div class="col-12">
                    <div class="form-group">
                      <label for="price_clean1">Bayar Pekerjaan</label>
                      <input type="text" class="form-control" id="date_start" name="date" required>
                    </div>
                  </div>
                  <div class="col-12">
                    <div class="form-group">
                      <label for="price_clean1">Tanggal Laporan</label>
                      <input type="text" class="form-control" id="price_clean1" name="price_clean" @keyup = 'filter' @keypress = 'isNumber' v-model='view_report.updated_at' required disabled="">
                    </div>
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="submit" class="btn btn-success">Kirim Pembayaran</button>
              </div>
            </form>
          </div>
        </div>
      </div>

      <div class="modal fade" id="seePayment" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header" style="background-color: #ffc3c3;">
              <h5 class="modal-title" id="exampleModalLabel">Lihat Detail</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form v-on:submit.prevent="sendPayment(view_report.id)" id="form-add-pay">
              <div class="modal-body">
                <div class="row align-items-center">
                  <div class="col-12 mb-2">
                    <label class="m-0">Total Pembayaran</label>
                  </div>
                  <div class="col-12 mb-2">
                    <label class="m-0 h5 font-weight-bold">Rp. @{{ priceCleanVendor }}</label>
                  </div>
                  <div class="col-12">
                    <div class="form-group">
                      <label for="price_clean1">Tanggal Pembayaran Pekerjaan</label>
                      <input type="text" class="form-control" id="date_start" v-model='view_report.date_pay' name="date" required disabled="">
                    </div>
                  </div>
                  <div class="col-12">
                    <div class="form-group">
                      <label for="price_clean1">Tanggal Laporan</label>
                      <input type="text" class="form-control" id="price_clean1" name="price_clean" @keyup = 'filter' @keypress = 'isNumber' v-model='view_report.updated_at' required disabled="">
                    </div>
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
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
                <h3 class="text-center mb-4"><strong>KONFIRMASI LAPORAN PEKERJAAN</strong></h3>
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
                      <div class="col-12 mt-2">
                        <button class="btn btn-success font-12" data-toggle="modal" data-target="#info_engage">Detail Selengkapnya</button>
                      </div>
                    </div>
                  </div>
                </div>

              </div>
              <div class="card-body">

                <!-- PEKERJAAN VENDOR -->

                <div class="row">
                  <div class="col-md-12 mb-4 mt-3 rounded text-center">
                    <div class="pt-3 pb-3 pl-2 pr-2" style="background-color: #00000008; border: 1px solid #00000020;">
                      <label class="font-weight-bold m-0 h3">Progres Pekerjaan</label>
                      <i class="btn btn-success fa fa-plus pull-right" data-toggle="modal" data-target="#addStep" v-if='data.locked == "offer"' @click='addDetail(report.id)'></i>
                    </div>
                  </div>
                  <div class="col-12 table-responsive">
                    <table class="table table-bordered" width="100%">
                      <thead>
                        <tr>
                          <th align="center" class="text-center"><strong>No</strong></th>
                          <th align="center" class="text-center" scope="col"><strong>Nama</strong></th>
                          <th align="center" class="text-center" scope="col"><strong>Harga Vendor</strong></th>
                          <th align="center" class="text-center" scope="col"><strong>Harga Customer</strong></th>
                          <th align="center" class="text-center" scope="col"><strong>Status</strong></th>
                          <th align="center" class="text-center" scope="col"><strong>Aksi</strong></th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr v-for='(report, index) in data.report'>
                          <td align="center" style="vertical-align: middle;">@{{ index+1 }}</td>
                          <td align="center" style="vertical-align: middle;">@{{ report.name }}</td>
                          <td align="center" style="vertical-align: middle;"><strong>@{{ formatPrice(report.all_price[0]) }}</strong></td>
                          <td align="center" style="vertical-align: middle;"><strong>@{{ formatPrice(report.all_price[1]) }}</strong></td>
                          <td align="center" style="vertical-align: middle;">
                            <div v-if='report.status != "donePayed"'>
                              <label class="m-0" v-if='report.status != "done"'>Progress</label>
                              <label class="m-0" v-if='report.status == "doneMandor"'>Telah Diverivikasi Mandor</label>
                            </div>
                            <label class="m-0" v-if='report.status == "donePayed"'>Telah Lunas</label>
                          </td>
                          <td align="center" class="text-center" style="vertical-align: middle;">
                            <span v-if='report.status != "donePayed"'>
                              <label class="font-weight-bold m-0" v-if='report.status != "doneMandor"'>-</label>
                              <label class="font-weight-bold m-0" v-if='report.status == "doneMandor"'>-</label>
                            </span>
                              <a href="" class="btn btn-info font-12" data-toggle="modal" data-target="#seePayment" v-if='report.status == "donePayed"' @click='addPayment(report.id, formatPrice(report.all_price[0]))'>Detail</a>
                          </td>
                        </tr>
                      </tbody>
                    </table>
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
            thisProvince: '',
            regency: {},
            thisRegency: '',
            district: {},
            thisDistrict: '',
            village: {},
            thisVillage: '',
            priceCleanVendor: ''
        },
        mounted: function(){
          this.getData(this.id);
          this.allUnit();
          this.loadProvince();
          this.$nextTick(()=>{
            let data = moment().format('YYYY-MM-DD');
            let data7 = moment().add(-7, 'days').format('YYYY-MM-DD');
            $('#date_start').daterangepicker({
                singleDatePicker: true,
                autoApply: true,
                minDate: data7,
                disableTouchKeyboard: true,
                startDate: data,
                locale: {
                  format: 'YYYY-MM-DD'
                },
            });
          });
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
          addPayment : function(id, price){
            this.getReport(id);
            this.priceCleanVendor = price;
          },
          sendPayment : function(id){
            let form = document.getElementById('form-add-pay');
            let forms = new FormData(form);

            // console.log(forms.get('date'));

            axios.post("{{ url('api/supervisor/addPay') }}/"+id, { date : forms.get('date') }).then(function(response){
              Swal.fire('Success', 'Konfirmasi Pembayaran Berhasil', 'success');
              report.$nextTick(()=>{
                $('#addPayment').modal('hide');
              });
            }.bind(this)).then(()=>{
              this.getData(this.id);
            });
          },
          formatPrice(value) {
            let val = (value/1).toFixed(0).replace(',', ',')
            return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
          },
          addDetail : function(id){
            this.id_step = id;
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