@extends('layout.public')

@if(session('id') == null || session('role') != 4)
  <script type="text/javascript">
    window.location = "{{ route('home') }}";
  </script>
@else

  @section('content')
    @include('layout.header')

    <div id="app" v-cloak>

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
          <main role="main" class="col-md-9 mx-auto">
            <div class="card">
              <div class="card-header">
                <div class="row">
                  <div class="col-md-6">
                    <div class="row">
                      <div class="col-md-12">
                        <label class="font-12">Kode Booking</label>
                        <br>
                        <label class="m-0"><strong>@{{ data.code }}</strong></label>
                      </div>
                      <div class="col-md-12">
                        <label class="font-12">Tanggal Survey</label>
                        <br>
                        <label class="m-0"><strong>@{{ data.date }} @{{ data.time }}</strong></label>
                      </div>
                      <div class="col-md-12">
                        <label class="font-12">Tanggal Mulai</label>
                        <br>
                        <label class="m-0" v-if= 'data.date_work != null'><strong>@{{ data.date_work }}</strong></label>
                        <label class="m-0" v-if= 'data.date_work == null'><strong>Dalam Proses</strong></label>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6 d-flex align-items-center justify-content-center">
                    <div>
                      <label class="font-12">Status</label>
                      <br>
                      <label class="font-weight-bold text-warning h-3" v-if='data.status != "finish"'>Dalam Progres</label>
                      <label class="font-weight-bold text-info h-3" v-if='data.status == "finish"'>Selesai</label>
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
                    </div>
                  </div>
                  <div class="col-12 table-responsive" v-for='(report, index) in data.report'>
                    <table class="table table-bordered" width="100%">
                      <thead>
                        <tr>
                          <th colspan="7" style="vertical-align: middle;"><strong>Tahapan @{{ index+1 }} @{{ report.name }}</strong></th>
                          <th align="center" class="text-center font-12" style="vertical-align: middle;">
                            <label class="m-0" v-if='report.status != "done" && report.status != "doneMandor" && report.status != "donePayed"'>Belum ada Laporan</label>
                            <label class="m-0" v-if='report.status == "doneMandor"'>Lengkap</label>
                            <label class="m-0" v-if='report.status == "donePayed"'>Selesai</label>
                            {{-- <a href="#" class="btn btn-info font-12"><i class="fa fa-pencil mr-2"></i><span>Bayar</span></a> --}}
                          </th>
                        </tr>
                        <tr class="font-12">
                          <td align="center" width="5%"><strong>No</strong></td>
                          <td align="center" width="20%"><strong>Nama</strong></td>
                          <td align="center" width="20%"><strong>Keterangan</strong></td>
                          <td align="center" width="10%"><strong>Volume</strong></td>
                          <td align="center" width="10%"><strong>Waktu</strong></td>
                          <td align="center" width="10%"><strong>Harga Satuan</strong></td>
                          <td align="center" width="10%"><strong>Harga</strong></td>
                          <td align="center" width="15%"><strong>Aksi</strong></td>
                        </tr>
                      </thead>
                      <tbody class="font-12">
                        <tr v-for='(detail, index3) in data.report[index].detail'>
                          <td align="center" style="vertical-align: middle;">@{{ index3+1 }}</td>
                          <td align="center" style="vertical-align: middle;">@{{ detail.name }}</td>
                          <td align="center" style="vertical-align: middle;">@{{ detail.description }}</td>
                          <td align="center" style="vertical-align: middle;">@{{ detail.volume }} @{{ detail.unit }}</td>
                          <td align="center" style="vertical-align: middle;">@{{ detail.time }} Hari</td>
                          <td align="center" style="vertical-align: middle;">@{{ formatPrice(detail.price_dirt) }}</td>
                          <td align="center" style="vertical-align: middle;">@{{ formatPrice(detail.price_dirt*detail.volume) }}</td>
                          <td align="center" style="vertical-align: middle;">
                            <label class="m-0 text-success" v-if='(report.status == "deal" || report.status == "offer") && (detail.status == "deal" || detail.status == "offer")'>Proses Pengerjaan</label>
                            <label class="m-0 text-success" v-if='report.status == "done"'>Pengerjaan Selesai</label>
                            <label class="m-0 text-success" v-if='report.status == "doneMandor"'>Selesai</label>
                            <label class="m-0 text-success" v-if='report.status == "donePayed"'>Selesai</label>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                  <div class="col-md-12 mb-4 mt-3 rounded text-center">
                    <div class="pt-3 pb-3 pl-2 pr-2" style="background-color: #00000008; border: 1px solid #00000020;">
                      <label class="font-weight-bold m-0 h3">Pembayaran</label>
                    </div>
                  </div>
                  <div class="col-md-12 table-responsive">
                    <table class="table table-striped table-bordered text-center font-12">
                      <thead>
                        <tr>
                          <th>Termin</th>  
                          <th>Tahapan</th>  
                          <th>Total Harga</th>
                          <th>Aksi</th>  
                        </tr>
                      </thead>
                      <tbody>
                        <tr v-for = '(termins, indexs) in termin'>
                          <td style="vertical-align: middle;">@{{ termins.termin }}</td>
                          <td style="vertical-align: middle;">@{{ termins.report_all }}</td>
                          <td style="vertical-align: middle;">@{{ formatPrice(termins.customer_price) }}</td>
                          <td>
                            <a :href="termins.payment_url+'?_token='+termins.payment_token" class="btn btn-primary text-white font-12" v-if = 'termins.payment_url != null && termins.payment.length == 0'>
                              Bayar Tagian
                            </a>
                            <label class="m-0" v-if='termins.payment_url == null'>
                              Belum ada tagihan
                            </label>
                            <label class="m-0 text-success" v-if='termins.status == "doneCustomer"'>
                              Lunas
                            </label>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>

              </div>
            </div>    
          </main>
        </div>
      </div>
      <!-- End Content -->
    </div>
    
    @include('layout.footer')

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
            priceCleanVendor: '',
            allPlace: '',
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
              this.data = response.data.data.data;
              this.partner = response.data.data.data.partner;
              this.allPlace = response.data.data.data.pvillage.name+', '+response.data.data.data.pdistrict.name+', '+response.data.data.data.pregency.name+', '+response.data.data.data.pprovince.name;
              this.termin = response.data.data.termin;
              console.log(response.data.data.termin)
            }.bind(this)).catch((error) => {
              console.log(error.response);

              Swal.fire({
                title: 'Ops !',
                text: 'Anda tidak punya akses untuk data ini',
                icon: 'warning',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Kembali'
              }).then((result) => {
                if (result.isConfirmed) {
                  window.location.href = '{{ url("/") }}';
                }
              });
            });
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
          addPayment : function(id, price){
            this.getReport(id);
            this.priceCleanVendor = price;
          },
          sendPayment : function(id){
            let form = document.getElementById('form-add-pay');
            let forms = new FormData(form);

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