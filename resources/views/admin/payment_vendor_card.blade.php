@extends('layout.app')

@if(session('id') == null || session('role') != 5)
  <script type="text/javascript">
    window.location = "{{ route('home') }}";
  </script>
@else

  @section('content')
    @include('layout.admin_header')
    <div id="app" v-cloak>

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
          <main role="main" class="col-lg-10 px-4 mt-4">
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
                  :class="view_report.id == reservation.id ? 'list-group-item list-group-item-action d-flex align-items-center justify-content-between active' : 'list-group-item list-group-item-action d-flex align-items-center justify-content-between'" style="cursor: pointer;" v-for='(reservation, index2) in datas.vendor_engage' @click="showReservation(index, index2)">
                    @{{ reservation.code }}
                  </button>
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
                                @{{ view_report.name }}
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
    <script type="text/javascript">
      var report = new Vue({
        el: '#app',
        data: {
            check : 0,
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
            data: {},
            month : moment().format('MM'),
            year : moment().format('YYYY'),
            report: {},
            priceCleanVendor: ''
        },
        mounted: function(){
          this.getData();
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
          showReservation: function(id, id2){
            this.partner = this.data[id];
            this.view_report = this.data[id].vendor_engage[id2];
            this.id = this.partner.id;
            this.id_engage = this.view_report.id;
          },
          getReport : function(id){
            axios.get("{{ url('api/report/getByIdReport') }}/"+id).then(function(response){
              this.add_report = response.data.data;
            }.bind(this));
          },
          formatPrice(value) {
            let val = (value/1).toFixed(0).replace(',', ',')
            return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
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