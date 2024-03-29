@extends('layout.app')

@if(auth()->user()->role != 1)
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
            <form v-on:submit.prevent="sendPayment(add_termin.id)" id="form-add-pay">
              <div class="modal-body">
                <div class="row align-items-center">
                  <div class="col-12 mb-2">
                    <label class="m-0">Total Pembayaran</label>
                  </div>
                  <div class="col-12 mb-2">
                    <label class="m-0 h5 font-weight-bold">Rp. @{{ formatPrice(add_termin.price) }}</label>
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
                      <input type="text" id="date_update" class="form-control" v-model='add_termin.updated_at' required disabled="">
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
                  <label class="m-0 h5 font-weight-bold">Rp. @{{ formatPrice(add_termin.price) }}</label>
                </div>
                <div class="col-12">
                  <div class="form-group">
                    <label for="price_clean1">Tanggal Pembayaran Pekerjaan</label>
                    <input type="text" class="form-control" id="date_start" v-model='add_termin.date_invoice' name="date" required disabled="">
                  </div>
                </div>
                <div class="col-12">
                  <div class="form-group">
                    <label for="date_updated">Tanggal Laporan</label>
                    <input type="text" class="form-control" id="date_updated" v-model='add_termin.updated_at' required disabled="">
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
              <div class="col-md-3 mb-3 mb-md-0">
                <div class="list-group" v-for='(datas, index) in data'>
                  <button type="button" 
                    :class="partner.id == datas.id ? 'list-group-item list-group-item-action d-flex align-items-center justify-content-between active' : 'list-group-item list-group-item-action d-flex align-items-center justify-content-between'" @click='showDetail(datas.id, index)' style="cursor: pointer; border-radius: 0px;">
                    @{{ datas.name }}
                  </button>
                </div>
                <div class="list-group text-center" v-if='data.length == 0'>
                  <button class="list-group-item list-group-item-action" disabled="">
                    Data tidak ditemukan ( Kosong )
                  </button>
                </div>
              </div>
              <div class="col-md-9">
                <div class="card">
                  <div class="card-header">
                    <div class="col-md-12 rounded text-center">
                        <label class="font-weight-bold m-0 h5">Kartu Hutang</label>
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
                                <strong>Kode Reservasi</strong>
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
                                <strong>Invoice Amount</strong>
                            </th>
                              <th align="center" class="text-center" scope="col">
                                <strong>Aksi</strong>
                            </th>
                            </tr>
                          </thead>
                          <tbody v-for='(engage, index2) in partner.vendor_engage'>
                            <tr v-for='(termins, index3) in partner.vendor_engage[index2].termin'>
                              <td align="center" style="vertical-align: middle;">
                                @{{ engage.code }}
                              </td>
                              <td align="center" style="vertical-align: middle;">
                                @{{ termins.date_invoice }}
                              </td>
                              <td align="center" style="vertical-align: middle;">
                                PAY/engage.code/@{{ termins.id }}/@{{ moment().format('YYYY') }}/@{{ view_report.id }}
                              </td>
                              <td align="center" style="vertical-align: middle;">
                                <strong>@{{ mapUh(termins.report) }}</strong>
                              </td>
                              <td align="center" style="vertical-align: middle;">
                                <strong>@{{ formatPrice(termins.price_clean) }}</strong>
                              </td>
                              <td align="center" style="vertical-align: middle;">
                                <span v-if='termins.status != "donePayed"'>
                                  <label class="font-weight-bold m-0" v-if='termins.status != "doneCustomer"'>-</label>
                                  <button class="btn btn-success font-12" v-if='termins.status == "doneCustomer" && allid.findIndex((x) => x == termins.id) === -1' @click='addList(termins.id, index2, index3)'>
                                      Bayar Vendor
                                  </button>
                                  <button class="btn btn-warning font-12" v-if='termins.status == "doneCustomer" && allid.findIndex((x) => x == termins.id) !== -1' @click='addList(termins.id, index2, index3)'>
                                      Batal
                                  </button>
                                </span>
                                  <a href="" class="btn btn-info font-12" data-toggle="modal" data-target="#seePayment" v-if='termins.status == "donePayed"' @click='addPayment(termins)'>Detail</a>
                              </td>
                            </tr>
                          </tbody>
                          <tbody>
                            <tr>
                              <td style="vertical-align: middle;" align="center" colspan="4">Total</td>
                              <td style="vertical-align: middle;" align="center">@{{ formatPrice(total) }}</td>
                              <td class="text-center">
                                <button class="btn btn-info" @click='sendPay()'>
                                  <i class="fa fa-exchange"></i>
                                </button>
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
            today : moment().format('YYYY-MM-DD'),
            id : '',
            id_engage : '',
            partner: {},
            view_report : {},
            add_termin : {
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
            total: 0,
            allid: [],
            allindex: [],
            thisindex: 0,
            vone: '',
            report: {},
            step: [],
            image: [],
            view: [],
            view_image: [],
            vendor: [],
            allunit : [],
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
            axios.get("{{ url('api/vendor/getProgress') }}").then(function(response){
              this.data = response.data.data;
              this.partner = {};
              this.view_report = {};
              this.termin = {
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
            this.thisIndex = index;
            this.allid = [];
            this.allindex = [];
            this.total = [];
            console.log(index);
          },
          showReservation: function(id, id2){
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
          addPayment : function(termin){
            this.add_termin.id            = termin.id; 
            this.add_termin.price         = termin.price_dirt; 
            this.add_termin.name          = termin.name;
            this.add_termin.updated_at    = moment(termin.updated_at).format('YYYY-MM-DD');
            this.add_termin.date_invoice  = termin.date_invoice;
          },
          addList : function(id, index2, index3){
            if (this.allid.length == 0) {
              this.allid.push(id);
              this.allindex.push(this.data[this.thisindex].vendor_engage[index2].termin[index3].price_clean);
            }else{
              if (this.allid.findIndex((x) => x == id ) != -1) {
                this.allid = this.allid.filter(function(value, index, arr){ 
                    return value != id;
                });
                let a = this.data[this.thisindex].vendor_engage[index2].termin[index3].price_clean;
                this.allindex = this.allindex.filter(function(value, index, arr){ 
                    return value != a;
                });
              }else{
                this.allid.push(id);
                this.allindex.push(this.data[this.thisindex].vendor_engage[index2].termin[index3].price_clean);
              }
            }
            this.total = 0;
            for (var i = 0; i < this.allindex.length; i++) {
              this.total += this.allindex[i];
            }
          },
          sendPay : function(){
            if (this.allid.length == 0) {
              Swal.fire('Opss', 'Pilih terlebih dahulu hutang yang ingin anda bayar, Pembayaran tidak bisa kosong');
            }else{
              Swal.fire({
                title: 'Perhatian',
                text: 'Apakah kamu yakin akan membayar '+this.allid.length+' hutang ini ?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes'
              }).then((result) => {
                if (result.isConfirmed) {
                  axios.post("{{ url('api/supervisor/addPayMultiple') }}", {id : this.allid}).then(function(response){
                    Swal.fire('Success', 'Konfirmasi Pembayaran Berhasil', 'success');
                  }.bind(this)).then(()=>{
                    this.getData(this.id);
                  });
                }
              });
            }
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