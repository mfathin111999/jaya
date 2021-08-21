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
                  <div class="pt-3 pb-3" style="background-color: #00000008; border: 1px solid #00000020;">
                    <label class="font-weight-bold m-0 h3">Informasi Reservasi</label>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="name">Nama Customer</label>
                    <input type="text" class="form-control" id="name" v-model='data.name' disabled>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="phone_number">No. Handphone</label>
                    <input type="text" class="form-control" id="phone_number" v-model='data.phone_number' disabled>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" v-model='data.email' disabled>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="ktp">No Identitas</label>
                    <input type="text" class="form-control" id="ktp" v-model='partner.ktp' disabled>
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="form-group">
                      <label for="province">Alamat Pekerjaan</label>
                      <textarea rows="2" class="form-control" id="allPlace" name="allPlace" v-model='allPlace' disabled=""></textarea>
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
          <main role="main" class="col-lg-10 px-4 mt-4">
            <div class="card">
              <div class="card-header">
                <h3 class="text-center mb-4"><strong>KONFIRMASI LAPORAN PEKERJAAN</strong></h3>
                <div class="row">
                  <div class="col-md-6">
                    <div class="row">
                      <div class="col-md-12">
                        <label class="font-12 m-0">Kode Booking</label>
                        <br>
                        <label class="font-14"><strong>@{{ data.code }}</strong></label>
                      </div>
                      <div class="col-md-12">
                        <label class="font-12 m-0">Nama Pelanggan</label>
                        <br>
                        <label class="font-14"><strong>@{{ data.name }}</strong></label>
                      </div>
                      <div class="col-md-12">
                        <label class="font-12 m-0">Tanggal Survey</label>
                        <br>
                        <label class="font-14"><strong>@{{ data.date }} @{{ data.time }}</strong></label>
                      </div>
                      <div class="col-md-12">
                        <label class="font-12 m-0">Vendor</label>
                        <br>
                        <label class="font-14"><strong>@{{ data.vendor ? data.vendor.name : '-' }}</strong></label>
                      </div>
                      <div class="col-md-12">
                        <label class="font-12 m-0">Tanggal Mulai</label>
                        <br>
                        <label class="font-14" v-if= 'data.date_work != null'><strong>@{{ data.date_work }}</strong></label>
                        <label class="font-14" v-if= 'data.date_work == null'><strong>Belum Ditentukan</strong></label>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6 d-block d-md-flex align-items-center justify-content-center">
                    <div>
                      <label class="font-12">Status</label>
                      <br>
                      <label class="font-weight-bold text-warning h4" v-if='data.status != "finish" && check != 0'>Dalam Progres</label>
                      <label class="font-weight-bold text-warning h4" v-if='data.status != "finish" && check == 0'>Semua Tahapan telah Selesai</label>
                      <label class="font-weight-bold text-info h4" v-if='data.status == "finish"'>Selesai</label>

                      <br>
                      <label class="font-12">Aksi</label>
                      <br>
                      <button class="font-weight-bold btn btn-info" v-if='data.status != "finish"' v-on:click="completing">Selesaikan Pekerjaan</button>
                      <button class="font-weight-bold btn btn-danger" v-if='data.status == "finish"' v-on:click="recompleting">Batalkan Perubahan</button>
                    </div>
                  </div>
                  <div class="col-12 mt-2">
                    <button class="btn btn-success font-12" data-toggle="modal" data-target="#info_engage">Detail Selengkapnya</button>
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
                          <th align="center" class="text-center" width="5%"><strong>No</strong></th>
                          <th align="center" class="text-center" width="30%"><strong>Nama</strong></th>
                          <th align="center" class="text-center" width="15%"><strong>Harga Vendor</strong></th>
                          <th align="center" class="text-center" width="15%"><strong>Harga Customer</strong></th>
                          <th align="center" class="text-center" width="25%"><strong>Status</strong></th>
                          <th align="center" class="text-center" width="10%"><strong>Aksi</strong></th>
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
                              <label class="m-0" v-if='report.status == "offer"'>-</label>
                              <label class="m-0" v-if='report.status == "deal"'>Progress</label>
                              <label class="m-0" v-if='report.status == "done"'>Diselesaikan Vendor</label>
                              <label class="m-0" v-if='report.status == "doneMandor"'>Telah Diverivikasi Mandor</label>
                            </div>
                            <label class="m-0" v-if='report.status == "donePayed"'>Telah Lunas</label>
                          </td>
                          <td align="center" class="text-center" style="vertical-align: middle;">
                            {{-- <span v-if='report.status != "donePayed"'>
                              <label class="font-weight-bold m-0" v-if='report.status != "doneMandor"'>-</label>
                              <label class="font-weight-bold m-0" v-if='report.status == "doneMandor"'>-</label>
                            </span> --}}
                              <button class="btn btn-info font-12" data-toggle="modal" data-target="#editModal" @click='getReport(report.id)' v-if='report.status == "done" || report.status == "doneMandor" || report.status == "donePayed"'><i class="fa fa-pencil mr-2"></i><span>Detail</span></button>

                              <label class="font-weight-bold m-0" v-else>-</label>
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
            check : 10,
            today : moment().format('YYYY-MM-DD'),
            id : '{{ $id }}',
            id_step : '',
            partner: {},
            view_report : {},
            data: {},
            report: {},
            step: [],
            image: [],
            termin: [],
            vendor: [],
            allunit : [],
            priceCleanVendor: '',
            allPlace: '',
        },
        mounted: function(){
          this.getData(this.id);
          this.allUnit();
          this.checks();
        },
        methods: {
          getData : function(id){
            axios.get("{{ url('api/report/getByIdEngagement') }}/"+id).then(function(response){
              this.data = response.data.data;
              this.partner = response.data.data.partner;
              this.allPlace = response.data.data.pvillage.name+', '+response.data.data.pdistrict.name+', '+response.data.data.pregency.name+', '+response.data.data.pprovince.name;

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
          async checks () {
            await axios.post("{{ url('api/customer/checkOrder') }}", {'id' : this.id}).then(response => {
              this.check = response.data.data;
            });
          },
          async completing () {
            Swal.fire({
                title: 'Apakah kamu yakin ?',
                text: "Kamu akan mengubah status reservasi ini menjadi 'Selesai'",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes'
              }).then((result) => {
                if (result.isConfirmed) {
                  axios.post("{{ url('api/customer/completingOrder') }}", {'id' : this.id}).then(response => {})
                  .then(() => {
                    this.getData(this.id);
                    Swal.fire('Berhasil !', 'Data berhasil diubah .. !', 'success');
                  });
                }
              });
          },
          async recompleting () {
            Swal.fire({
                title: 'Apakah kamu yakin ?',
                text: "Kamu akan mengubah status reservasi ini menjadi 'Belum Selesai'",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes'
              }).then((result) => {
                if (result.isConfirmed) {
                  axios.post("{{ url('api/customer/recompletingOrder') }}", {'id' : this.id}).then(response => {})
                  .then(() => {
                    this.getData(this.id);
                    Swal.fire('Berhasil !', 'Data berhasil diubah .. !', 'success');
                  });
                }
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