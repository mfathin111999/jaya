@extends('layout.app')

@if(session('id') == null || session('role') != 1)
  <script type="text/javascript">
    window.location = "{{ route('home') }}";
  </script>
@else

  @section('content')
    @include('layout.admin_header')
    <div id="app" v-cloak>

      <div class="modal fade" id="addPayment" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header" style="background-color: #ffc3c3;">
              <h5 class="modal-title" id="exampleModalLabel">Lihat Detail</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form v-on:submit.prevent="sendPayment(add_report.id)" id="form-add-pay">
              <div class="modal-body">
                <div class="row align-items-center">
                  <div class="col-12 mb-2">
                    <label class="m-0">Total Pembayaran</label>
                  </div>
                  <div class="col-12 mb-2">
                    <label class="m-0 h5 font-weight-bold">Rp. @{{ formatPrice(add_report.price) }}</label>
                  </div>
                  <div class="col-12">
                    <div class="form-group">
                      <label for="date_start">Bayar Pekerjaan</label>
                      <input type="text" class="form-control" id="date_start" name="date" required>
                    </div>
                  </div>
                  <div class="col-12">
                    <div class="form-group">
                      <label for="date_update">Tanggal Laporan</label>
                      <input type="text" id="date_update" class="form-control" v-model='add_report.updated_at' required disabled="">
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
            <div class="modal-body">
              <div class="row align-items-center">
                <div class="col-12 mb-2">
                  <label class="m-0">Total Pembayaran</label>
                </div>
                <div class="col-12 mb-2">
                  <label class="m-0 h5 font-weight-bold">Rp. @{{ formatPrice(add_report.price) }}</label>
                </div>
                <div class="col-12">
                  <div class="form-group">
                    <label for="price_clean1">Tanggal Pembayaran Pekerjaan</label>
                    <input type="text" class="form-control" id="date_start" v-model='add_report.date_invoice' name="date" required disabled="">
                  </div>
                </div>
                <div class="col-12">
                  <div class="form-group">
                    <label for="date_updated">Tanggal Laporan</label>
                    <input type="text" class="form-control" id="date_updated" v-model='add_report.updated_at' required disabled="">
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

      <!-- Content -->
      <div class="container-fluid" style="margin-top: 60px;">
        <div class="row">
          @include('layout.admin_side')
          <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4 mt-4">
            <div class="row">
              <div class="col-md-3">
                <div class="form-group">
                  <label for="filter-find">Tahun</label>
                  <select class="form-control font-12" v-model='year' v-on:change='getData'>
                    <option value="2021">2021</option>
                    <option value="2022">2022</option>
                    <option value="2023">2023</option>
                    <option value="2024">2024</option>
                    <option value="2025">2025</option>
                    <option value="all">Semua</option>
                  </select>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="filter-find">Bulan</label>
                  <select class="form-control font-12" v-model='month' v-on:change='getData'>
                    <option value="01">1</option>
                    <option value="02">2</option>
                    <option value="03">3</option>
                    <option value="04">4</option>
                    <option value="05">5</option>
                    <option value="06">6</option>
                    <option value="07">7</option>
                    <option value="08">8</option>
                    <option value="09">9</option>
                    <option value="10">10</option>
                    <option value="11">11</option>
                    <option value="12">12</option>
                    <option value="all">Semua</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-3 mb-3 mb-md-0">
                <div v-if='data.length == 0' class="text-center list-group">
                  <div class="list-group-item">
                    Data Kosong
                  </div>
                </div>
                <div class="list-group" v-for='(datas, index) in data'>
                  <button type="button" 
                    :class="partner.id == datas.id ? 'list-group-item list-group-item-action d-flex align-items-center justify-content-between active' : 'list-group-item list-group-item-action d-flex align-items-center justify-content-between'" @click='showDetail(datas.id, index)' style="cursor: pointer; border-radius: 0px;">
                    @{{ datas.name }}
                    <span class="badge badge-secondary badge-pill pull-right">@{{ datas.vendor_engage_count }}</span>
                  </button>
                  <div class="list-group-item" style="display: none;" :id='datas.id'>
                    <div class="list-group">
                      <button type="button" 
                      :class="view_report.id == reservation.id ? 'list-group-item list-group-item-action d-flex align-items-center justify-content-between active' : 'list-group-item list-group-item-action d-flex align-items-center justify-content-between'" style="cursor: pointer;" v-for='(reservation, index2) in datas.vendor_engage' @click="showReservation(index, index2)">
                        @{{ reservation.name }}
                      </button>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-9">
                <div class="card">
                  <div class="card-header">
                    <div class="col-md-12 rounded text-center">
                        <label class="font-weight-bold m-0 h5">PEMBAYARAN VENDOR</label>
                    </div>
                  </div>
                  <div class="card-body">

                    <!-- PEKERJAAN VENDOR -->

                    <div class="row">
                      <div class="col-12 table-responsive">
                        <table class="table table-bordered" width="100%">
                          <thead>
                            <tr>
                              <th align="center" class="text-center">
                                <strong>Business Partner</strong>
                              </th>
                              <th align="center" class="text-center" scope="col">
                                <strong>Date Invoise</strong>
                              </th>
                              <th align="center" class="text-center" scope="col">
                                <strong>Document No</strong>
                              </th>
                              <th align="center" class="text-center" scope="col">
                                <strong>Description</strong>
                              </th>
                              <th align="center" class="text-center" scope="col">
                                <strong>Payment</strong>
                              </th>
                              <th align="center" class="text-center" scope="col">
                                <strong>Payment Date</strong>
                              </th>
                              <th align="center" class="text-center" scope="col">
                                <strong>Payment Amount</strong>
                              </th>
                              <th align="center" class="text-center" scope="col">
                                <strong>Bank Account</strong>
                            </th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr v-for='(termins, index) in view_report.termin'>
                              <td align="center" style="vertical-align: middle;">
                                @{{ partner.name }}
                              </td>
                              <td align="center" style="vertical-align: middle;">
                                @{{ termins.date_pay }}
                              </td>
                              <td align="center" style="vertical-align: middle;">
                                @{{ termins.document_no }}
                              </td>
                              <td align="center" style="vertical-align: middle;">
                                <strong>@{{ mapUh(termins.report) }}</strong>
                              </td>
                              <td align="center" style="vertical-align: middle;">
                                @{{ termins.payment[0].number }}
                              </td>
                              <td align="center" style="vertical-align: middle;">
                                @{{ moment(termins.date_pay).format('YYYY-MM-DD') }}
                              </td>
                              <td align="center" style="vertical-align: middle;">
                                @{{ formatPrice(termins.price_clean) }}
                              </td>
                              <td align="center" style="vertical-align: middle;">
                                @{{ termins.payment[0].payment_type }}
                              </td>
                            </tr>
                            <tr>
                              <td colspan="6">
                                <strong>Total @{{ partner.name }}</strong>
                              </td>
                              <td align="center" style="vertical-align: middle;">
                                <strong>@{{ formatPrice(view_report.allprice_clean == null ? 0 : view_report.allprice_clean) }}</strong>
                              </td>
                              <td align="center" style="vertical-align: middle;">
                                <strong>-</strong>
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>    
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
      var report = new Vue({
        el: '#app',
        data: {
            check : 0,
            today : moment().format('YYYY-MM-DD'),
            id : '',
            id_engage : '',
            partner: {},
            view_report : {},
            add_report : {
              price : 0,
              name : 0,
              id : '',
              updated_at : '',
              date_invoice : '',
            },
            add_form : {},
            add_date : {},
            add_step : {},
            data: {},
            month : moment().format('MM'),
            year : moment().format('YYYY'),
            vone: '',
            report: {},
            step: [],
            image: [],
            view: [],
            view_image: [],
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
          this.getData();
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
          getData : function(){
            axios.post("{{ url('api/vendor/getPayment') }}", { 'year' : this.year, 'month' : this.month, _method: 'get'}).then(function(response){
              this.data = response.data.data;
              this.partner = {};
              this.view_report = {};
              this.add_report = {
                price : 0,
                name : 0,
                id : '',
                updated_at : '',
                date_invoice : '',
              };
            }.bind(this));
          },
          showDetail: function(id, index){
            this.partner = this.data[index];
            $('#'+id).slideToggle();
          },
          showReservation: function(id, id2){
            this.partner = this.data[id];
            this.view_report = this.data[id].vendor_engage[id2];
            this.id = this.partner.id;
            this.id_engage = this.view_report.id;
          },
          allUnit: function(){
            axios.get("{{ url('api/resource/all-unit') }}").then(function(response){
              this.allunit = response.data.data;
            }.bind(this));
          },
          getReport : function(id){
            axios.get("{{ url('api/report/getByIdReport') }}/"+id).then(function(response){
              this.add_report = response.data.data;
            }.bind(this));
          },
          addPayment : function(report){
            this.add_report.id          = report.id; 
            this.add_report.price       = report.price_dirt; 
            this.add_report.name        = report.name;
            this.add_report.updated_at  = moment(report.updated_at).format('YYYY-MM-DD');
            this.add_report.date_invoice= report.date_invoice;
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
          mapUh(x){
            let data = [];
            for (var i = 0; i < x.length; i++) {
              data.push(x[i].name);
            }

            if (data.length <= 1 )
              return 'Tahap '+data[0];
            else
              return 'Tahap '+data.join(', ');
          },
        }
      });
      
    </script>
  @endsection

@endif