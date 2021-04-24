@extends('layout.app')

@if(session('id') == null || session('role') != 5)
  <script type="text/javascript">
    window.location = "{{ route('home') }}";
  </script>
@else

  @section('content')
    @include('layout.admin_header')
    <div id="app" v-cloak>

      <!-- MODAL INFORMASI RESERVASI -->

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
                      <textarea class="form-control" name="address" v-model='allPlace' disabled="">
                        </textarea>
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

      <!-- TAMBAH LAPORAN LAPANGAN -->

      <div class="modal fade" id="addModal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header" style="background-color: #ffc3c3;">
              <h5 class="modal-title" id="exampleModalLabel">Tambah Detail</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form v-on:submit.prevent="addWorkUpdate()" id="form-add">
              <div class="modal-body">
                <div class="row align-items-center">
                  <div class="col-12">
                    <div class="form-group">
                      <label for="price_clean1">Tanggal Laporan</label>
                      <input type="text" name="date" class="form-control" id="date_start">
                    </div>
                  </div>
                  <div class="col-12">
                    <div class="form-group">
                      <label for="image_report" class="btn btn-sm btn-outline-secondary font-weight-bold m-0"><i class="fa fa-plus pr-2"></i>Tambah Gambar</label>
                      <input type="file" name="gambar" id="image_report" class="form-control" multiple="" @change="onFileChange" style="display: none;">
                    </div>
                  </div>
                  <div class="col-6" v-for="(img, index) in view_image">
                    <div class="form-group">
                      <i class="fa fa-minus-circle btn btn-warning" @click='deleteItem(index)' style="position: absolute; top: 5%; right: 10%;"></i>
                      <img :src="img" class="img-fluid">
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

      <!-- LIHAT & EDIT LAPORAN LAPANGAN -->

      <div class="modal fade" id="editModal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header" style="background-color: #ffc3c3;">
              <h5 class="modal-title" id="exampleModalLabel">Lihat Detail</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form v-on:submit.prevent="saveAddReport()" id="form-add">
              <div class="modal-body">
                <div class="row align-items-center">
                  <div class="col-12">
                    <div class="form-group">
                      <label for="price_clean1">Tanggal Laporan</label>
                      <input type="text" class="form-control" id="price_clean1" name="price_clean" @keyup = 'filter' @keypress = 'isNumber' v-model='view_report.updated_at' required disabled="">
                    </div>
                  </div>
                  <div class="col-12">
                    <label class="">Gambar Lapangan</label>
                  </div>
                  <div class="col-12" v-for="(img, index) in view_report.gallery">
                    <div class="form-group">
                      <img :src="'../storage/'+img.image" class="img-fluid">
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
                <h3 class="text-center mb-4"><strong>KONFIRMASI LAPORAN SURVEYER</strong></h3>
                <div class="row">
                  <div class="col-md-6">
                    <div class="row">
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
                          <td align="center" scope="col"><strong>Aksi</strong></td>
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
                          <td align="center" style="vertical-align: middle;">
                            <button class="btn btn-success" v-if='(report.status == "offer" || report.status == "deal") && (detail.status == "deal" || detail.status == "offer")' @click='setWorkUpdate(detail.id)'><i class="fa fa-check-square-o"></i></button>
                            <label class="m-0 text-success" v-if='report.status == "done"'>Selesai</label>
                            <label class="m-0 text-success" v-if='report.status == "doneMandor"'>Disetujui</label>
                            <label class="m-0 text-success" v-if='report.status == "donePayed"'>Lunas</label>
                          </td>
                        </tr>
                        <tr>
                          <td colspan="6" align="center" style="vertical-align: middle;"><strong>Total Harga</strong></td>
                          <td align="center" style="vertical-align: middle;"><strong>@{{ formatPrice(report.all_price[0]) }}</strong></td>
                          <td align="center" style="vertical-align: middle;">
                            <button class="btn btn-info" data-toggle="modal" data-target="#addModal" @click='addDetail(report.id)' v-if='report.status == "offer" || report.status == "deal"'><i class="fa fa-check-square-o"></i></button>
                            <button class="btn btn-info font-12" data-toggle="modal" data-target="#editModal" @click='getReport(report.id)' v-if='report.status == "done" || report.status = "doneMandor"'><i class="fa fa-pencil mr-2"></i><span>Lihat</span></button>
                            <button class="btn btn-info font-12" @click='infoCard' v-if='report.status == "doneMandor" || report.status == "donePayed"'><i class="fa fa-info-circle"></i></button>
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
            id : '{{ $id }}',
            id_step : '',
            id_detail : '',
            partner: {},
            view_report : {},
            data: {},
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
            allPlace: ''
        },
        mounted: function(){
          this.getData(this.id);
          this.allUnit();
          this.loadProvince();
          this.$nextTick(()=>{
            let today = moment().format('YYYY-MM-DD');
            let today7 = moment().add(-7, 'days').format('YYYY-MM-DD');
            $('#date_start').daterangepicker({
                singleDatePicker: true,
                autoApply: true,
                minDate: today7,
                disableTouchKeyboard: true,
                startDate: today,
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
              this.partner = response.data.data.partner
              this.allPlace = response.data.data.partner.village.name+', '+response.data.data.partner.district.name+', '+response.data.data.partner.regency.name+', '+response.data.data.partner.province.name;

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
            axios.get("{{ url('api/report/getByIdReportStep') }}/"+id).then(function(response){
              this.view_report = response.data.data;
            }.bind(this));
          },
          infoCard : function(){
            // Swal.fire('Informasi', 'Check kartu hutang pada menu history untuk melihat pendapatan anda pada pekerjaan ini', 'info');
            Swal.fire('Informasi', 'Lihat pada status pekerjaan, jika terdapat keterangan Lunas (Telah Dibayarkan) maka pekerjaan telah dibayarkan', 'info');
          },
          formatPrice(value) {
            let val = (value/1).toFixed(0).replace(',', ',')
            return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
          },
          addDetail : function(id){
            this.id_step = id;
          },
          setDetail : function(id){
            this.id_detail = id;
          },
          addTermin : function(){

            this.termin.push({
              step      : [],
              vendor    : 0,
              customer  : 0,
            });
            // console.log(this.termin);
          },
          addWorkUpdate: function(){
            let form = new FormData();
            let date = $('#date_start').val();

            form.append('id', JSON.stringify(parseInt(this.id_step)));
            form.append('date', date);

            for( var i = 0; i < this.image.length; i++ ){
              let file = this.image[i];
              form.append('image[' + i + ']', file);
            }

            axios.post("{{ url('api/vendor/report-step') }}/"+this.id_step, form).then(function(response) {
              Swal.fire('Success', 'Terima Kasih sudah menyelesaikan pekerjaan', 'success');
              report.$nextTick(()=>{
                $('#addModal').modal('hide');
              })
            }).then(()=>{
              this.getData(this.id);
            });
          },
          setWorkUpdate: function(id){
            axios.post("{{ url('api/vendor/report') }}/"+id).then(function(response) {
              Swal.fire('Success', 'Terima Kasih sudah menyelesaikan pekerjaan', 'success');
            }).then(()=>{
              this.getData(this.id);
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
          deleteItem:function(index){
            this.view_image.splice(index, 1);
            this.image.splice(index, 1);  
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
          onFileChange(e) {
            if (this.image.length < 2 ) {
              this.image.push(e.target.files[0]);
              const file = e.target.files[0];
              this.view_image.push(URL.createObjectURL(file));
            }else{
              Swal.fire('Mohon Maaf ... !', 'Batas upload gambar adalah 2 File', 'warning');
            }
          },
        }
      });
      
    </script>
  @endsection

@endif