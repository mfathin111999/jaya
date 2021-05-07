@extends('layout.app')

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
	</style>
@endsection

@section('content')
	@include('layout.header')
  	<div id="app" v-cloak>
      <div class="row">
        <div class="col-md-9 mx-auto">
          <div class="rounded text-center mt-5 mb-5">
            <label class="m-0 h4 font-weight-bold">
              Daftar History Pemesanan
            </label>
          </div>
        </div>
        <div class="col-md-9 mx-auto">
          <div class="table">
            <table id="example" class="table table-striped table-bordered" style="width:100%">
              <thead>
                  <tr>
                      <th>Name</th>
                      <th>Service</th>
                      <th>Email</th>
                      <th>Tanggal</th>
                      <th>Kota</th>
                      <th>Status</th>
                      <th>Action</th>
                  </tr>
              </thead>
              <tbody>
                  <tr v-for = "(item, index) in data" v-bind:class = 'item.status == "acc" ? "table-success" : (item.status == "pending" ? "table-warning" : "table-danger")'>
                    <td>@{{ item.name }} </td>
                    <td>@{{ item.service }}</td>
                    <td>@{{ item.email }}</td>
                    <td>@{{ item.date }} @{{ item.time }}</td>
                    <td>@{{ item.regency }}</td>

                    <td v-if='item.status == "acc" && item.count == 0 && item.locked == "offer"'>Diterima</td>
                    <td v-if='item.status == "ignore"'>Ditolak</td>
                    <td v-if='item.status == "acc" && item.count > 0 && item.locked == "offer"'>Telah Disurvei</td>
                    <td v-if='item.status == "acc" && item.locked == "deal"'>Telah Disepakati</td>
                    <td v-if='item.status == "pending"'>Belum Dikonfirmasi</td>

                    <td>
                      @if(auth()->user()->role == 1)
                      <a class="btn btn-info" href="#" type="button" data-toggle="modal" data-target="#actionModal" v-on:click='viewData(item.id)' v-if = 'item.status == "pending"'><i class="fa fa-eye"></i></a>
                      <!-- <a class="btn btn-danger" href="#" type="button" v-on:click='deleteItem(item.id)' v-if='item-status'><i class="fa fa-trash"></i></a> -->
                      <a class="btn btn-success" href="#" type="button" v-on:click='addReport(item.id)' v-if='item.status == "acc" && item.locked != "deal" && item.count == 0'><i class="fa fa-pencil"></i></a>
                      <a class="btn btn-primary" href="#" type="button" v-on:click='seeReport(item.id)' v-if='item.status == "acc" && item.locked != "deal" &&  item.count > 0'><i class="fa fa-list-alt"></i></a>
                      <a class="btn btn-info" href="#" type="button" v-on:click='seeWork(item.id)' v-if='item.status == "acc" && item.locked == "deal"'><i class="fa fa-cog"></i></a>
                      <!-- <a class="btn btn-success" href="#" type="button" v-on:click='addReport(item.id)' v-if='item.status != "acc"'><i class="fa fa-pencil"></i></a> -->
                      @elseif(auth()->user()->role == 2)
                      <a class="btn btn-success" href="#" type="button" v-on:click='addReport(item.id)' v-if='item.status == "acc" && item.count == 0'><i class="fa fa-pencil"></i></a>
                      @elseif(auth()->user()->role == 3)
                      <a class="btn btn-primary" href="#" type="button" v-on:click='seeReportMandor(item.id)' v-if='item.status == "acc" && item.count > 0'><i class="fa fa-list-alt"></i></a>
                      @endif
                    </td>
                  </tr>
              </tbody>
            </table>
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
          getData : function(){
              axios.get("{{ url('api/engagementCustomer') }}").then(function(response){
                this.data = response.data.data;
                console.log(this.data);
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
          seeReport : function(id){
            window.location ="{{ url('report_view') }}/"+id;
          },
          seeReportMandor : function(id){
            window.location ="{{ url('/report_mandor') }}/"+id;
          },
          seeWork : function(id){
            window.location ="{{ url('/report_supervisor_action') }}/"+id;
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