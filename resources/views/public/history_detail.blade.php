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
                      <label class="font-weight-bold text-warning h-3" v-if='data.status != "finish" && check != 0'>Dalam Progres</label>
                      <label class="font-weight-bold text-warning h-3" v-if='data.status != "finish" && check == 0'>Semua Tahapan telah Selesai</label>
                      <label class="font-weight-bold text-info h-3" v-if='data.status == "finish"'>Selesai</label>

                      <br>
                      <label class="font-12">Aksi</label>
                      <br>
                      <button class="font-weight-bold btn btn-info" v-if='check == 0' v-on:click="completing">Selesaikan Pekerjaan</button>
                      <label class="font-weight-bold" v-if='data.status != "finish" && check != 0'> - </label>
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
    <script type="text/javascript">
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
            vone: '',
            report: {},
            step: [],
            image: [],
            view: [],
            view_image: [],
            termin: [],
            vendor: [],
            allunit : [],
            allPlace: '',
        },
        mounted: function(){
          this.checks();
          this.getData(this.id);
          this.allUnit();
        },
        methods: {
          getData : function(id){
            axios.get("{{ url('api/report/getByIdEngagement') }}/"+id).then(function(response){
              this.data = response.data.data.data;
              this.partner = response.data.data.data.partner;
              this.allPlace = response.data.data.data.pvillage.name+', '+response.data.data.data.pdistrict.name+', '+response.data.data.data.pregency.name+', '+response.data.data.data.pprovince.name;
              this.termin = response.data.data.termin;
            }.bind(this)).catch((error) => {
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
                    Swal.fire('Berhasil !', 'Data berhasil dihapus .. !', 'success');
                    this.getData(this.id);
                  });
                }
              });
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
        }
      });
      
    </script>
  @endsection

@endif