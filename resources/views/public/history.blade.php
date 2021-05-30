@extends('layout.public')

@if(session('id') == null || session('role') != 4)
  <script type="text/javascript">
    window.location = "{{ route('home') }}";
  </script>
@else

@section('sec-css')
	<style type="text/css">
		.max-400{
			width: auto !important;
			height: 400px;
		}

		.nurani-rezeki-unggul{
			
		}

		.max-500{
			width: auto !important;
			height: 500px;
		}

		.f-small{
			font-size: 14px;
		}

		.f-light{
			font-size: 12px;
		}

		.max-height-100{
			height: 30px;
		}

		.card{
			border-radius: 20px;
		}

		.card-footer{
			border-bottom-right-radius: 20px !important;
			border-bottom-left-radius: 20px !important;
		}

    .dataTables_filter{
      text-align: right;
    }

    .dataTables_filter label{
      text-align: left;
      font-size: 12px;
    }

    .dataTables_info, .dataTables_length{
      font-size: 12px;
    }

    .pagination{
      justify-content: flex-end;
      font-size: 12px;
      margin-bottom: 0px !important;
    }

    .activated{
      color: white !important;
    }
	</style>
@endsection

@section('content')
	@include('layout.header')
    <div id="app" v-cloak>

      <div class="page-header py-4">
          <div class="container">
              <div class="row">
                  <div class="col-12">
                      <h2>History</h2>
                  </div>
                  <div class="col-12" v-if='data.length != 0'>
                      <a href="" class="activated">Semua</a>
                      <a href="">Proses</a>
                      <a href="">Progres</a>
                  </div>
              </div>
          </div>
      </div>

      <div class="container">
        <div class="panel">
          <div class="panel-body">
            <div class="col-12 text-center" v-if='data.length == 0'>
                <a href="">Anda belum melakukan transaksi apapun</a>
            </div>
            <div class="row" v-if='data.length != 0'>
              <div class="col-md-12 mx-auto">
                <div class="table table-responsive">
                  <table id="example" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Service</th>
                            <th>Tanggal Survei</th>
                            <th>Kota</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody class="font-12">
                        <tr v-for = "(item, index) in data">
                          <td>@{{ item.name }} </td>
                          <td>@{{ item.service }}</td>
                          <td>@{{ item.date }} @{{ item.time }}</td>
                          <td>@{{ ucwords(item.regency) }}</td>

                          <td v-if='item.status == "ignore"'>Ditolak</td>
                          <td v-if='item.status == "pending"'>Belum Dikonfirmasi</td>
                          <td v-if='item.status == "acc" && item.count == 0 && item.locked == "offer"'>Diterima</td>
                          <td v-if='item.status == "acc" && item.count > 0 && item.locked == "offer"'>Telah Disurvei</td>
                          <td v-if='item.status == "acc" && item.locked == "deal"'>Telah Disepakati</td>

                          <td class="text-center">
                            @if(auth()->user()->role == 4)
                              <button class="btn btn-info" type="button" v-on:click='seeWork(item.id)' v-if='item.status == "acc" && item.locked == "deal"'><i class="fa fa-cog"></i></button>
                            @endif
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
      },
      mounted: function(){
        this.getData();
      },
      methods: {
          getData : function(type = 'all'){
              axios.post("{{ url('api/engagementCustomer') }}").then(function(response){
                this.data = response.data.data;
                this.$nextTick(() => {
                   $("#example").DataTable();
                });
              }.bind(this));
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