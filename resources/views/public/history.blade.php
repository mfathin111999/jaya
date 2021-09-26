@extends('layout.public')

@if(auth()->user()->role != 4)
  <script type="text/javascript">
    window.location = "{{ route('home') }}";
  </script>
@else

@section('content')
	@include('layout.header')
    <div id="app" v-cloak>

      <div class="page-header py-4">
          <div class="container">
              <div class="row">
                  <div class="col-12">
                      <h2>History</h2>
                  </div>
              </div>
          </div>
      </div>

      <div class="container">
        <div class="card" style="border-radius: 8px;">
              <div class="card-body">
                <div class="row px-3">
                  <div class="col-12 col-md-12 mb-3 d-none d-lg-block">
                    <label class="mb-0 mr-2">filter :</label>
                    <button :class="filter == 'pending' ? active : normal " :disabled="filter == 'pending' ? true : false" @click="getData('pending')">Pending @{{ filter == 'pending' ? '('+count+')' : '' }}</button>
                    <button :class="filter == 'offer' ? active : normal " :disabled="filter == 'offer' ? true : false" @click="getData('offer')">Diterima @{{ filter == 'offer' ? '('+count+')' : ''  }}</button>
                    <button :class="filter == 'post_offer' ? active : normal " :disabled="filter == 'post_offer' ? true : false" @click="getData('post_offer')">Telah Disurvei @{{ filter == 'post_offer' ? '('+count+')' : '' }}</button>
                    <button :class="filter == 'deal' ? active : normal " :disabled="filter == 'deal' ? true : false" @click="getData('deal')">Proses Pekerjaan @{{ filter == 'deal' ? '('+count+')' : '' }}</button>
                    <button :class="filter == 'ignore' ? active : normal " :disabled="filter == 'ignore' ? true : false" @click="getData('ignore')">Ditolak @{{ filter == 'ignore' ? '('+count+')' : '' }}</button>
                    <button :class="filter == 'finish' ? active : normal " :disabled="filter == 'finish' ? true : false" @click="getData('finish')">Selesai @{{ filter == 'finish' ? '('+count+')' : '' }}</button>
                  </div>
                  <div class="col-12 col-md-12 mb-3 d-none d-lg-block">
                    <label class="mb-0 mr-2">Urutan :</label>
                    <button :class="order == 'desc' ? active : normal " :disabled="order == 'desc' ? true : false" @click="getData(filter, 'desc')">Terbaru</button>
                    <button :class="order == 'asc' ? active : normal " :disabled="order == 'asc' ? true : false" @click="getData(filter, 'asc')">Terlama</button>
                  </div>
                  <div class="col-12 col-md-12 mb-3 d-lg-none d-block">
                    <label class="mb-0 mr-2">filter :</label>
                    <select class="form-control font-12" v-model='filter' @change="getData(filter)">
                      <option value="pending">Pending</option>
                      <option value="offer">Diterima</option>
                      <option value="post_offer">Telah Disurvei</option>
                      <option value="deal">Telah Deal</option>
                      <option value="finish">Finish</option>
                      <option value="ignore">Ditolak</option>
                    </select>
                  </div>
                  <div class="col-12 col-md-12 mb-3 d-md-none d-block">
                    <label class="mb-0 mr-2">Urutan :</label>
                    <select class="form-control font-12" v-model='order' @change="getData(filter)">
                      <option value="desc">Terbaru</option>
                      <option value="asc">Terlama</option>
                    </select>
                  </div>
                  <div class="col-md-12 p-3 mb-3 shadow-cards text-center" v-if='data.length == 0'>
                    <label class="m-0 font-weight-bold">data tidak ditemukan</label>
                  </div>
                  <div class="col-md-12 p-3 mb-3 shadow-cards" v-if='data.length != 0' v-for='(engage, index) in data'>
                    <div class="row">
                      <div class="col-md-8 col-12 mb-3">
                        <h5 class="font-weight-bold font-14">@{{ engage.service }}</h5>
                        <div class="table-responsive">
                          <table class="table m-0" style="border : 0; line-height: 1.5rem;">
                            <tr>
                              <td class="p-0" width="20%" style="border : 0;">Pelanggan</td>
                              <td class="pt-0 pb-0" width="10%" style="border : 0;">:</td>
                              <td class="p-0" width="70%" style="border : 0;">@{{ engage.name }}</td>
                            </tr>
                            <tr>
                              <td class="p-0" style="border : 0;">Penawaran</td>
                              <td class="pt-0 pb-0" style="border : 0;">:</td>
                              <td class="p-0" style="border : 0;">Rp. @{{ formatPrice(engage.price) }}</td>
                            </tr>
                            <tr>
                              <td class="p-0" style="border : 0;">Lokasi</td>
                              <td class="pt-0 pb-0" style="border : 0;">:</td>
                              <td class="p-0" style="border : 0;">@{{ engage.regency }}</td>
                            </tr>
                            <tr>
                              <td class="p-0" style="border : 0;">Tanggal</td>
                              <td class="pt-0 pb-0" style="border : 0;">:</td>
                              <td class="p-0" style="border : 0;">@{{ moment(engage.date).format('LL') }}</td>
                            </tr>
                          </table>
                        </div>
                      </div>
                      <div class="col-12 col-md-4">
                        <div class="align-items-center d-flex justify-content-between">
                          <label class="m-0 font-12">Status Pekerjaan </label>
                          <label class="text-center m-0 font-weight-bold px-2 py-1 bg-warning mt-2 rounded" v-if='filter == "pending"'>Pending</label>
                          <label class="text-center m-0 font-weight-bold px-2 py-1 bg-danger text-white mt-2 rounded" v-if= 'filter == "ignore"'>Ditolak</label>
                          <label class="text-center m-0 font-weight-bold px-2 py-1 bg-success text-white mt-2 rounded" v-if= 'filter == "offer"'>Diterima</label>
                          <label class="text-center m-0 font-weight-bold px-2 py-1 bg-primary text-white mt-2 rounded" v-if= 'filter == "post_offer"'>Telah Disurvey</label>
                          <label class="text-center m-0 font-weight-bold px-2 py-1 bg-dark text-white mt-2 rounded" v-if= 'filter == "deal"'>Telah Deal</label>
                          <label class="text-center m-0 font-weight-bold px-2 py-1 bg-info text-white mt-2 rounded" v-if= 'filter == "finish"'>Finish</label>
                        </div>
                        <span class="d-block font-12">
                          <span v-if='engage.status == "pending" && filter == "pending"'>Note : <br> <span class="d-block text-info text-justify">Reservasi anda sedang kami tinjau, kami akan mengirimkan hasil tinjauan kami melalui email anda.</span></span>
                          <span class="mt-3" v-if='engage.status == "ignore" && filter == "ignore"'>Alasan Penolakan : <br> <span class="d-block text-danger text-justify">@{{ engage.reason }}</span></span>
                          <span v-if='engage.status == "acc" && filter == "offer"'>Note : <br> <span class="d-block text-info text-justify">Surveyer kami sedang memproses Reservasi anda</span></span>
                          <span v-if='engage.status == "acc" && filter == "post_offer"'>Note : <br> <span class="d-block text-info text-justify">Reservasi anda telah kami survei, kami akan segera memberikan penawaran harga untuk anda. Detail penawaran akan kami kirim lewat email</span></span>
                          <button class="btn-block btn btn-info font-14 mt-3" href="#" type="button" v-on:click='seeWork(engage.id)' v-if='engage.status == "acc" && engage.locked == "deal" && filter == "deal"'>
                            Detail
                          </button>
                          <button class="btn-block btn btn-info font-14 mt-3" href="#" type="button" v-on:click='seeWork(engage.id)' v-if='engage.status == "finish" && filter == "finish"'>
                            Detail
                          </button>
                        </span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
      </div>
	</div>
	@include('layout.footer')
@endsection

@section('sec-js')
<script type="text/javascript" src="{{ asset('js/datatables.min.js') }}"></script>
<script type="text/javascript">
	var app = new Vue({
      el: '#app',
      data: {
          data: [],
          defaultImg : '{{ asset('img/default.png') }}',
          service: '',
          time: [],
          addViewImage: '',
          province: {},
          thisProvince: '',
          regency: {},
          thisRegency: '',
          district: {},
          thisDistrict: '',
          village: {},
          thisVillage: '',
          filter : 'pending',
          active: 'btn btn-success mx-2',
          normal: 'btn btn-outline-secondary mx-2',
          order : 'desc',
          count : 0,
      },
      mounted: function(){
        this.getData();
      },
      methods: {
          getData : function(filter = this.filter, order = 'desc'){
              this.filter = filter;
              this.order = order;
              axios.post("{{ url('api/engagementCustomer') }}", {'filter' : this.filter, 'order' : this.order}).then(function(response){
                this.data = response.data.data.data;
                this.count = response.data.data.count;
              }.bind(this))
              .catch(error => {
                Swal.fire('Opss', 'Terjadi Kesalahan <br> Harap hubungi team Developer', 'warning');
              });
          },
          viewData : function(id){
            axios.get("{{ url('api/engagement') }}/"+id).then(function(response){
              this.view = response.data.data;
            }.bind(this));
          },
          getEmployee : function(){
            axios.get("{{ url('api/user/getSurveyer') }}").then(function(response){
              this.employee = response.data.data;
            }.bind(this));
          },
          formatPrice(value) {
            let val = (value/1).toFixed(0).replace(',', ',')
            return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
          },
          valid: function() {
            if (this.action == 'acc') {
              document.getElementById('employee').disabled = false;
            }else{
              document.getElementById('employee').disabled = true;
            }
          },
          ucwords(str) {
              str = str.toLowerCase();
              str = str.toLowerCase().replace(/\b[a-z]/g, function(letter) {
                  return letter.toUpperCase();
              });

              return str;
          },
          seeWork : function(id){
            window.location ="{{ url('/history/detail') }}/"+id;
          },
          addReport : function(id){
            // axios.get("{{ url('api/report') }}/"+id).then(function(response){
            //   if (response != 0) {
            //     window.location ="{{ url('report_survey') }}/"+id;
            //   }else{

            //   }
            // }.bind(this));

            window.location ="{{ url('report_survey') }}/"+id;

          },
          actionEngagement : function(id){
            let forms = document.getElementById('actionForm');

            let data = new FormData(forms);

            if (this.action == '' || (this.action == 'acc' && data.get('employee[]') == null)) {
              Swal.fire(
                  'Warning!',
                  'Harap isi Aksi dan Surveyer.',
                  'warning'
              );
            }else{
              axios.post("{{ url('api/engagement/action') }}", data).then(function(response){
                app.$nextTick(() => {
                  $('#actionModal').modal('hide');
                  $("#example").DataTable();
                });
                Swal.fire(
                    'Success!',
                    'Survey diterima.',
                    'success'
                );
              }).then(()=>{
                this.getData();
              });
            }
          },
          deleteItem: function(id){
            Swal.fire({
              title: 'Are you sure?',
              text: "You won't be able to revert this!",
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Yes'
            }).then((result) => {
              if (result.isConfirmed) {
                axios.post("{{ url('api/engagement/destroy') }}/"+id).then(function(response){
                  app.$nextTick(() => {
                    $('#example').DataTable().destroy();
                  });
                }).then(() => {
                    Swal.fire(
                      'Deleted!',
                      'Your file has been deleted.',
                      'success'
                  )
                });
                this.getData();
              }
            })
          },
        }
    });

</script>
@endsection

@endif