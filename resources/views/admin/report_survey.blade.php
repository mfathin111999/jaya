@extends('layout.app')

@if(session('id') == null || session('role') == 4)
  <script type="text/javascript">
    window.location = "{{ route('home') }}";
  </script>
@else

  @section('content')
  	@include('layout.admin_header')
    <div id="app" v-cloak>

      <div class="container-fluid" style="margin-top: 60px;">
        <div class="row">
          @include('layout.admin_side')
          <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4 mt-4">
            <form v-on:submit.prevent="submitform">
              <div class="card">
        				<div class="card-header">
        					<h3 class="text-center mb-4 font-weight-bold">TAMBAH LAPORAN SURVEY</h3>
                  <div class="row">
                    <div class="col-md-3">Kode Booking</div>
                    <div class="col-md-1 text-center">:</div>
                    <div class="col-md-8"><strong>@{{ view.code }}</strong></div>
                    <div class="col-md-3">Nama Pelanggan</div>
                    <div class="col-md-1 text-center">:</div>
                    <div class="col-md-8"><strong>@{{ view.name }}</strong></div>
                  </div>

        					<div class="btn-group mb-3 mt-3" v-if = 'check == 0'>
                      <button type="button" class="btn btn-sm btn-outline-secondary font-weight-bold" v-on:click='addNewForm()'><i class="fa fa-plus pr-2"></i>Tambah Tahapan</button>
                  </div>
        				</div>
                <div class="card-body" v-if = 'check > 0'>
                  <div class="text-center">
                    <h4 class="font-weight-bold">LAPORAN TELAH TERKIRIM</h4>
                  </div>
                </div>
      					<div class="card-body" v-if = 'check == 0'>

                  <!-- KELENGKAPAN DATA CUSTOMER -->

                  <div class="row">
                    <div class="col-md-12">
                      <label class="font-weight-bold">KELENGKAPAN DATA CUSTOMER</label>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="name">Nama Customer</label>
                        <input type="text" class="form-control" id="name" name="name" v-model='view.name' disabled>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="phone_number">No. Handphone</label>
                        <input type="text" class="form-control" id="phone_number" v-model='view.phone_number' name="phone_number" disabled>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" v-model='view.email' disabled>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="ktp">No Identitas</label>
                        <input type="text" class="form-control" id="ktp" name="ktp" v-model='partner.ktp' required>
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="form-group">
                        <label for="address">Alamat Lokasi</label>
                        <textarea type="text" rows="2" class="form-control" id="address" name="address" v-model='partner.address' required></textarea>
                      </div>
                    </div>
                  </div>

                  <!-- LAPORAN SURVEY -->
                  <div class="row mb-4">
                    <div class="col-md-12 pt-3 pb-3 rounded" style="background-color: #00000008; border: 1px solid #00000020;">
                      <div class="btn-group" v-if = 'check == 0'>
                          <button type="button" class="btn btn-sm btn-outline-secondary font-weight-bold" v-on:click='addNewForm()'><i class="fa fa-plus pr-2"></i>Tambah Tahapan</button>
                      </div>
                    </div>
                  </div>
                  <div class="row" v-if = 'data.length == 0'>
                    <div class="col-md-12 text-center">
                      <h4 class="font-weight-bold m-0">LAPORAN KOSONG</h4>
                    </div>
                  </div>
      						<div class="row" v-for='(form, index) in data'>
      							<div class="col-md-12 mb-3 mt-3" v-if = 'index != 0' style="border-top: 1px solid #d8d8d8;"></div>
      							<div class="col-md-12">
      								<div class="form-group">
                          <i class="btn btn-info fa fa-minus-circle" style="position: absolute; right: 16px;" @click = 'deleteItem(index, 2)'></i>
                          <label for="name">Tahapan @{{ index+1 }}</label>
                          <input type="text" class="form-control" v-model = 'form.name_part' required="">
                      </div>
      							</div>
      							<div class="col-md-12">
      								<div class="btn-group mb-3">
      		                <button type="button" class="btn btn-sm btn-outline-secondary" v-on:click='addNewPoint(index)' style="font-size: 12px;"><i class="fa fa-plus pr-2"></i>Tambah Point Detail</button>
      		            </div>
      							</div>
      							<div class="col-md-12">
      								<div class="row">
      									<div class="col-md-4 text-center">Nama detail</div>
      									<div class="col-md-4 text-center">Unit</div>
      									<div class="col-md-3 text-center">Volume</div>
                        <div class="col-md-1 text-center"></div>
      								</div>
      							</div>
      							<div class="col-md-12">
      								<div class="row mt-3 align-items-center" v-for='(form1, index2) in data[index].detail'>
      									<div class="col-md-4">
                          <input type="text" class="form-control" v-model = 'form1.name_point' required="">
      									</div>
      									<div class="col-md-4">
                          <select class="form-control" v-model='form1.unit' required="">
                            <option value=''>Pilih Jenis Unit</option>
                            <option v-for='(units, index) in allunit' :value="units.data2">@{{ units.data2 }}</option>
                          </select>
      									</div>
      									<div class="col-md-3">
                          <input type="text" class="form-control" v-model = 'form1.volume' required="">
      									</div>
                        <div class="col-md-1">
                          <i class="btn btn-danger fa fa-minus-circle" @click = 'deleteItem(index2, 3, index)'></i>
                        </div>
      								</div>
      							</div>
      						</div>

                  <!-- GALLERIES -->
                  <div class="row mt-4">
                    <div class="col-md-12 pt-3 pb-3 rounded" style="background-color: #00000008; border: 1px solid #00000020;">
                      <label for="image_report" class="btn btn-sm btn-outline-secondary font-weight-bold m-0"><i class="fa fa-plus pr-2"></i>Tambah Gambar Report</label>
                      <input type="file" name="gambar" id="image_report" class="form-control" multiple="" @change="onFileChange" style="display: none;">
                    </div>
                    <div class="col-md-12 text-center" v-if= 'view_image.length == 0'>
                      <h4 class="font-weight-bold mt-4">GAMBAR KOSONG</h4>
                    </div>
                    <div class="col-md-3 text-right mt-3" v-for = "(image, index3) in view_image" >
                      <div>
                        <i class="fa fa-minus-circle btn btn-warning" @click='deleteItem(index3, 1)' style="position: absolute; top: 5%; right: 10%;"></i>
                        <img :src="image" class="img-fluid p-2" style="background-color: #00000008; border: 1px solid #00000020;">
                      </div>
                    </div>
                  </div>
      					</div>
      					<div class="card-footer text-center">
      						<button type="submit" class="btn btn-success" v-if = 'check == 0'>Save</button>
      					</div>
    			    </div>
            </form>	
          </main>
        </div>
      </div> 
    </div>
    

  @endsection
  @section('sec-js')
    <script type="text/javascript" src="{{ asset('js/datatables.min.js') }}"></script>
    <script type="text/javascript">
      var app = new Vue({
        el: '#app',
        data: {
            check : 0,
            id : '{{ $id }}',
            data: [],
            vone: '',
            allunit: '',
            view: {},
            image: [],
            view_image:[],
            partner:{
              address : '',
              ktp : '',
            },
        },
        created: function(){
          this.allUnit();
          this.getData(this.id);
          this.checkReport(this.id);
        },
        methods: {
          checkReport: function(id){
            axios.get("{{ url('api/report/getCount') }}/"+id).then(function(response){
              this.check = response.data.data;
            }.bind(this));
          },
          allUnit: function(){
            axios.get("{{ url('api/resource/all-unit') }}").then(function(response){
              this.allunit = response.data.data;
            }.bind(this));
          },
          onFileChange(e) {
            if (this.image.length < 8 ) {
              this.image.push(e.target.files[0]);
              const file = e.target.files[0];
              this.view_image.push(URL.createObjectURL(file));
            }else{
              Swal.fire('Mohon Maaf ... !', 'Batas upload gambar adalah 8 File', 'warning');
            }
          },
        	addNewForm : function(){
        		this.data.push(
        			{
  	          		name_part: '',
  	          		detail: [],
            		}
            	);
        		// console.log(this.data);
        	},
        	addNewPoint : function(index){
        		this.data[index].detail.push(
        			{
  		          	name_point: '',
  		          	unit: '',
  		          	Volume: '',
  		        }
  	        );
        		console.log(index);
        	},
          getData : function(id){
            axios.get("{{ url('api/engagement') }}/"+id).then(function(response){
              this.view = response.data.data;
            }.bind(this));
          },
          addForm : function(){
            this.status = false;
          },
          submitform : function(){
            var form = new FormData();

            var partner = {
              name: this.view.name,
              email: this.view.email,
              address: this.partner.address,
              ktp: this.partner.ktp,
              phone_number: this.view.phone_number,
            }

            form.append('id', JSON.stringify(parseInt(this.id)));
            form.append('data', JSON.stringify(this.data));
            form.append('partner', JSON.stringify(partner));
            for( var i = 0; i < this.image.length; i++ ){
              let file = this.image[i];
              form.append('image[' + i + ']', file);
            }
            console.log(this.view.name);

            axios.post("{{ url('api/report/create') }}", 
              form
              ).then(function(response){
              window.location = "{{ route('engagement') }}";
              console.log(response.data.data);
            });
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
                axios.post("{{ url('api/resource/destroy') }}/"+id).then(function(response){
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
          deleteItem:function(index, type, data = 0){
            if (type == 1) {
              this.view_image.splice(index, 1);
              this.image.splice(index, 1);  
            }else if (type == 2) {
              this.data.splice(index, 1)
            }else if (type == 3){
              this.data[data].detail.splice(index, 1);
            }
            
          },
          editData: function(id){
            axios.post("{{ url('api/resource/update-resource') }}/"+id, this.view).then(function(response){
              app.$nextTick(() => {
                $("#editModal").modal('hide');
                $("#example").DataTable().destroy();
              });
            }).then(() => {
              this.getData();
            });
          }
        }
      });
    </script>
  @endsection

@endif