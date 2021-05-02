@extends('layout.app')

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
		<section class="mb-3 mt-5 bg-image">
			<div class="row align-items-center" style="height: 100%">
				<div class="col-12 col-md-8 p-0 mb-0">
					<img class="img-fluid" src="{{ asset('img/back.png') }}" style="max-height: 600px;">
				</div>
				<div class="col-12 col-md-4 text-left mt-3">
					<div class="text-center" style="height: 100%">
						<h1 class="font-weight-bold" style="line-height: 3rem;">Bingung cari jasa renovasi rumah ?</h1>
						<button class="btn btn-info mt-3 shadow" style="border-radius: 30px; width: 300px;"><h3 class="font-weight-bold">Yuk Gabung .. !</h3></button>
					</div>
				</div>
			</div>
		</section>

		@guest
		<section class="mb-3 mt-5 pt-5 pb-5 bg-info shadow">
			<div class="container">
				<div class="d-block text-center mb-5 text-white">
					<h1><strong>Apa Yang Anda Butuhkan ?</strong></h1>
					<p>Reservasi sesuai dengan kebutuhan anda</p>
				</div>
				<div class="text-center">
					<button class="btn btn-warning p-4" data-toggle="modal" data-target="#signUp">
						<span class="h3 font-weight-bold">Ayo daftar untuk memulai ..</span>
					</button>
				</div>
			</div>
		</section>
		@endguest

		@auth
		<!-- Form Reservasi Survey -->
		<section class="mb-3 mt-5 pt-5 pb-5 bg-info shadow">
			<div class="container">
				<div class="d-block text-center mb-5 text-white">
					<h1><strong>Apa Yang Anda Butuhkan ?</strong></h1>
					<p>Reservasi sesuai dengan kebutuhan anda</p>
				</div>
				<form v-on:submit.prevent="sendReservation" id="form-engagement">
					<div class="row">
						<div class="col-12 col-md-6">
							<div class="form-group">
					            <label for="name">Name</label>
					            <input type="text" class="form-control" id="name" name="name" placeholder="Nama" required="">
					        </div>
					        <div class="form-group">
					            <label for="phone_number">No Handphone</label>
					            <input type="text" class="form-control" id="phone_number" name="phone_number" placeholder="Whatsapp" required="">
					        </div>
					        <div class="row">
					        	<div class="col-md-6">
						        	<div class="form-group">
							            <label for="province">Provinsi</label>
							            <select type="text" class="form-control" id="province" name="province_id" v-model='thisProvince' @change='getRegency()' required="">
							            	<option value="">Pilih</option>
							            	<option v-for = '(province, index) in province' :value = 'province.id'>@{{ ucwords(province.name) }}</option>
							            </select>
							        </div>
						        </div>
						        <div class="col-md-6">
						        	<div class="form-group">
							            <label for="regency">Kota/Kabupaten</label>
							            <select type="text" class="form-control" id="regency" name="regency_id" v-model='thisRegency' @change='getDistrict()' required="">
							            	<option value="">Pilih</option>
                      						<option v-for = '(regency, index) in regency' :value="regency.id">@{{ ucwords(regency.name) }}</option>
							            </select>
							        </div>
						        </div>
						        <div class="col-md-6">
						        	<div class="form-group">
							            <label for="district">Kecamatan</label>
							            <select type="text" class="form-control" id="district" name="district_id" v-model='thisDistrict' @change='getVillage()' required="">
							            	<option value="">Pilih</option>
							            	<option v-for = '(district, index) in district' :value = 'district.id'>@{{ ucwords(district.name) }}</option>
							            </select>
							        </div>
						        </div>
						        <div class="col-md-6">
						        	<div class="form-group">
							            <label for="village">Kelurahan</label>
							            <select type="text" class="form-control" id="village" name="village_id" v-model='thisVillage' required="">
							            	<option value="">Pilih</option>
							            	<option v-for = '(village, index) in village' :value = 'village.id'>@{{ ucwords(village.name) }}</option>
							            </select>
							        </div>
						        </div>
					        </div>
					         <div class="form-group">
					            <label for="address">Alamat</label>
					            <input type="text" class="form-control" id="address" name="address" placeholder="Masukan Alamat Rumah" required="">
					        </div>
						</div>
						<div class="col-12 col-md-6">
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
							            <label for="date">Date</label>
							            <input type="text" class="form-control datePicker" id="date" name="date" placeholder="YYYY-MM-DD" required="">
							        </div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
							            <label for="time">Waktu</label>
							            <select class="form-control" name="time" id="time" required="">
							            	<option value="">Pilih</option>
							            	<option v-for= 'times in time' :value="times">@{{ times }}</option>
							            </select>
							        </div>
								</div>
							</div>
							<div class="form-group">
					            <label for="service">Servis</label>
					            <select type="text" class="form-control select2" id="service" name="service[]" multiple="" required="">
					            	<option v-for = "(service, index) in service" :value = 'service.id'>@{{ service.name }}</option>
					            </select>
					        </div>
							<div class="form-group">
					            <label for="description">Deskripsi ( 300 Karakter )</label>
					            <textarea type="text" class="form-control" id="description" name="description" placeholder="Description Keperluan" rows="5" maxlength="300" required=""></textarea>
					            <label id="maxDescription" class="mb-0 mt-2">300 Karakter tersisa</label>
					        </div>
						</div>
					</div>
					<button class="btn-block btn btn-warning mt-3 shadow">Kirim Reservasi Survey Lapangan</button>
				</form>
			</div>
		</section>
		@endauth

		<!-- List Service -->
		<section class="container-fluid mt-5 mb-5 pt-5">
			<div class="container">
				<div class="d-block text-center mb-5">
					<h1><strong>Service</strong></h1>
					<p>Pelajari dan mulai coba layanan kami</p>
				</div>
				<div class="row">
					<div class="col-12 col-md-6 col-lg-4 pb-3">
						<div class="card mx-auto shadow" style="max-width: 400px;">
						  	<div class="card-body" style="max-height: 300px; overflow: hidden;">
						  		<div style="display: flex; justify-content: center; align-items: center;" class="text-center">
						  			<div style="width: 100px; height: 100px; background-color: #fed136; border-radius: 100%;">
						  				<i class="fa fa-home text-white" style="font-size: 85px; margin-top: 6px;"></i>
						  			</div>
						  		</div>
						  		<h5 class="text-center mt-3 font-weight-bold pb-2 pt-3">PERBAIKAN RUMAH</h5>
						  		<p class="text-justify">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
						  		tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
						  		quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
						  		consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
						  		cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
						  		proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
						  	</div>
						  	<div class="card-footer text-center mt-3">
						  		<a type="button" class="btn btn-info text-white pl-2 pr-2 f-small font-weight-bold">Pelajari dan Mulai Reservasi .. !</a>
						  	</div>
						</div>
					</div>
					<div class="col-12 col-md-6 col-lg-4 pb-3">
						<div class="card mx-auto shadow" style="max-width: 400px;">
						  	<div class="card-body" style="max-height: 300px; overflow: hidden;">
						  		<div style="display: flex; justify-content: center; align-items: center;" class="text-center">
						  			<div style="width: 100px; height: 100px; background-color: #59b1ff; border-radius: 100%;">
						  				<i class="fa fa-tint text-white" style="font-size: 85px; margin-top: 6px;"></i>
						  			</div>
						  		</div>
						  		<h5 class="text-center mt-3 font-weight-bold pb-2 pt-3">PERBAIKAN SALURAN AIR</h5>
						  		<p class="text-justify">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
						  		tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
						  		quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
						  		consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
						  		cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
						  		proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
						  	</div>
						  	<div class="card-footer text-center mt-3">
						  		<a type="button" class="btn btn-info text-white pl-2 pr-2 f-small font-weight-bold">Pelajari dan Mulai Reservasi .. !</a>
						  	</div>
						</div>
					</div>
					<div class="col-12 col-md-6 col-lg-4 pb-3">
						<div class="card mx-auto shadow" style="max-width: 400px;">
						  	<div class="card-body" style="max-height: 300px; overflow: hidden;">
						  		<div style="display: flex; justify-content: center; align-items: center;" class="text-center">
						  			<div style="width: 100px; height: 100px; background-color: #ffa94f; border-radius: 100%;">
						  				<i class="fa fa-bolt text-white" style="font-size: 85px; margin-top: 6px;"></i>
						  			</div>
						  		</div>
						  		<h5 class="text-center mt-3 font-weight-bold pb-2 pt-3">PERBAIKAN LISTRIK</h5>
						  		<p class="text-justify">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
						  		tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
						  		quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
						  		consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
						  		cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
						  		proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
						  	</div>
						  	<div class="card-footer text-center mt-3">
						  		<a type="button" class="btn btn-info text-white pl-2 pr-2 f-small font-weight-bold">Pelajari dan Mulai Reservasi .. !</a>
						  	</div>
						</div>
					</div>
				</div>
			</div>
		</section>

		<!-- Petunjuk Reservasi -->
		<section class="mt-5 mb-5">
            <div class="container">
                <div class="text-center">
                    <h1 class="font-weight-bold">Ayo Coba</h1>
                    <p class="pt-3 pb-4">Ikut petunjuk reservasi untuk memulai service kami</p>
                </div>
                <ul class="timeline">
                    <li>
                        <div class="timeline-image">
                        	<i class="fa fa-calendar icon-step"></i>
                        </div>
                        <div class="timeline-panel">
                            <div class="timeline-heading">
                                <h4 class="font-weight-bold">Step 1</h4>
                                <h4 class="subheading">Pilih kebutuhan Anda</h4>
                            </div>
                            <div class="timeline-body">
                            	<p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sunt ut voluptatum eius sapiente, totam reiciendis temporibus qui quibusdam, recusandae sit vero unde, sed, incidunt et ea quo dolore laudantium consectetur!</p>
                            </div>
                        </div>
                    </li>
                    <li class="timeline-inverted">
                        <div class="timeline-image bg-info">
                        	<i class="fa fa-plane icon-step"></i>
                        </div>
                        <div class="timeline-panel">
                            <div class="timeline-heading">
                                <h4 class="font-weight-bold">Step 2</h4>
                                <h4 class="subheading">Survei</h4>
                            </div>
                            <div class="timeline-body">
                            	<p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sunt ut voluptatum eius sapiente, totam reiciendis temporibus qui quibusdam, recusandae sit vero unde, sed, incidunt et ea quo dolore laudantium consectetur!</p>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="timeline-image bg-danger">
                        	<i class="fa fa-handshake-o icon-step"></i>
                    	</div>
                        <div class="timeline-panel">
                            <div class="timeline-heading">
                                <h4 class="font-weight-bold">Step 3</h4>
                                <h4 class="subheading">Negosiasi</h4>
                            </div>
                            <div class="timeline-body">
                            	<p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sunt ut voluptatum eius sapiente, totam reiciendis temporibus qui quibusdam, recusandae sit vero unde, sed, incidunt et ea quo dolore laudantium consectetur!</p>
                            </div>
                        </div>
                    </li>
                    <li class="timeline-inverted">
                        <div class="timeline-image bg-warning">
                        	<i class="fa fa-suitcase icon-step"></i>
                    	</div>
                        <div class="timeline-panel">
                            <div class="timeline-heading">
                                <h4 class="font-weight-bold">Step 4</h4>
                                <h4 class="subheading">Mulai Bekerja</h4>
                            </div>
                            <div class="timeline-body">
                            	<p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sunt ut voluptatum eius sapiente, totam reiciendis temporibus qui quibusdam, recusandae sit vero unde, sed, incidunt et ea quo dolore laudantium consectetur!</p>
                            </div>
                        </div>
                    </li>
                    <li class="timeline-inverted">
                        <div class="timeline-image bg-success">
                            <h4>
                                Selesai
                                <br>
                                &
                                <br>
                                Review
                            </h4>
                        </div>
                    </li>
                </ul>
            </div>
        </section>

        <!-- Portofolio -->
		<section class="mt-5 mb-5 shadow rounded bg-light">
			<div class="pt-5 pb-3">
				<div class="d-block text-center">
					<h1><strong>Portofolio</strong></h1>
					<p>Kami bekerja keras untuk hasil yang terbaik</p>
				</div>
			</div>
			<div class="content pb-5">
				<div class="row">
			      <div class="col-12">
			        <div class="owl-carousel owl-theme">
			          <div class="item text-center" style="width: 100%;">
			          	<div class="card mx-auto border border-secondary" style="width: 18rem;">
			          		<div class="text-center mt-3">
			            		<img class="img-fluid d-inline" src="{{ asset('img/default.png') }}" style="width: 100px;">
			          		</div>
						  	<div class="card-body">
						    	<p class="card-text font-italic">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
						  	</div>
						</div>
			          </div>
			          <div class="item text-center" style="width: 100%;">
			          	<div class="card mx-auto border border-secondary" style="width: 18rem;">
			          		<div class="text-center mt-3">
			            		<img class="img-fluid d-inline" src="{{ asset('img/default.png') }}" style="width: 100px;">
			          		</div>
						  	<div class="card-body">
						    	<p class="card-text font-italic">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
						  	</div>
						</div>
			          </div>
			          <div class="item text-center" style="width: 100%;">
			          	<div class="card mx-auto border border-secondary" style="width: 18rem;">
			          		<div class="text-center mt-3">
			            		<img class="img-fluid d-inline" src="{{ asset('img/default.png') }}" style="width: 100px;">
			          		</div>
						  	<div class="card-body">
						    	<p class="card-text font-italic">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
						  	</div>
						</div>
			          </div>
			          <div class="item text-center" style="width: 100%;">
			          	<div class="card mx-auto border border-secondary" style="width: 18rem;">
			          		<div class="text-center mt-3">
			            		<img class="img-fluid d-inline" src="{{ asset('img/default.png') }}" style="width: 100px;">
			          		</div>
						  	<div class="card-body">
						    	<p class="card-text font-italic">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
						  	</div>
						</div>
			          </div>
			          <div class="item text-center" style="width: 100%;">
			          	<div class="card mx-auto border border-secondary" style="width: 18rem;">
			          		<div class="text-center mt-3">
			            		<img class="img-fluid d-inline" src="{{ asset('img/default.png') }}" style="width: 100px;">
			          		</div>
						  	<div class="card-body">
						    	<p class="card-text font-italic">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
						  	</div>
						</div>
			          </div>
			          <div class="item text-center" style="width: 100%;">
			          	<div class="card mx-auto border border-secondary" style="width: 18rem;">
			          		<div class="text-center mt-3">
			            		<img class="img-fluid d-inline" src="{{ asset('img/default.png') }}" style="width: 100px;">
			          		</div>
						  	<div class="card-body">
						    	<p class="card-text font-italic">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
						  	</div>
						</div>
			          </div>
			          <div class="item text-center" style="width: 100%;">
			          	<div class="card mx-auto border border-secondary" style="width: 18rem;">
			          		<div class="text-center mt-3">
			            		<img class="img-fluid d-inline" src="{{ asset('img/default.png') }}" style="width: 100px;">
			          		</div>
						  	<div class="card-body">
						    	<p class="card-text font-italic">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
						  	</div>
						</div>
			          </div>
			          <div class="item text-center" style="width: 100%;">
			          	<div class="card mx-auto border border-secondary" style="width: 18rem;">
			          		<div class="text-center mt-3">
			            		<img class="img-fluid d-inline" src="{{ asset('img/default.png') }}" style="width: 100px;">
			          		</div>
						  	<div class="card-body">
						    	<p class="card-text font-italic">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
						  	</div>
						</div>
			          </div>
			          <div class="item text-center" style="width: 100%;">
			          	<div class="card mx-auto border border-secondary" style="width: 18rem;">
			          		<div class="text-center mt-3">
			            		<img class="img-fluid d-inline" src="{{ asset('img/default.png') }}" style="width: 100px;">
			          		</div>
						  	<div class="card-body">
						    	<p class="card-text font-italic">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
						  	</div>
						</div>
			          </div>
			        </div>
			      </div>
			    </div>
			</div>
		</section>
	</div>
	@include('layout.footer')
@endsection

@section('sec-js')
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
      created: function(){
        this.loadProvince();
        this.loadService();
        this.loadTime();
      },
      methods: {
        viewData : function(id){
          axios.get("{{ url('api/employee') }}/"+id).then(function(response){
            this.view = response.data.data;
            $("#editModal").modal('show');
          }.bind(this)).then(() => { 
            this.getAllAddress();
          });
        },
        submitform : function(){
          axios.post("{{ url('api/employee/create-employee') }}", this.form).then(function(response){
            app.$nextTick(() => {
              $("#editModal").modal('hide');
              $("#example").DataTable().destroy();
            });
          }).then(() => {
            this.form = {};
            this.getData();
          });
        }, 
        addForm: function(){
            this.thisProvince = '';
            this.regency = {};
            this.thisRegency = '';
            this.district = {};
            this.thisDistrict = '';
            this.village = {};
            this.thisVillage = '';        
        },
        loadTime(){
        	var i = 0;
          	for(i = 0; i < 15; i++){
          		this.time.push(moment('10:00', 'HH:mm').add(i*30, 'minutes').format('HH:mm'));
          	};
        },
        loadService(){
          axios.get("{{ url('api/service') }}").then(function(response){
            this.service = response.data.data;
          }.bind(this));
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
        sendReservation: function(){
        	let form 	= document.getElementById('form-engagement');
          	let forms 	= new FormData(form);
            axios.post(
              "{{ url('api/engagement/create-engagement') }}",
              forms,
              {
                headers: {
                  'Content-Type': 'multipart/form-data',
                }
              }
            ).then((response) => {
        		form.reset();
        		console.log(response);
              	Swal.fire('Success', response.data.message, 'success');
            });
         }
      }
    });

    $('#description').keyup(function () {
	    var left = 300 - $(this).val().length;
	    if (left < 0) {
	        left = 0;
	    }
	    $('#maxDescription').text(left + ' Karakter tersisa');
	});

	$('.owl-carousel').owlCarousel({
	    nav: true,
	    margin: 10,
	    loop: true,
		dots: true,
        autoplay:true,
    	autoplayTimeout:3000,
    	autoplayHoverPause:true,
	    responsive: {
	        0: {
	          items: 1
	        },
	        600: {
	          items: 1
	        },
	        1000: {
	          items: 3
	        }
	    }
	});

	$('.select2').select2({
		placeholder: "Pilih service"
	});

	$('.datePicker').daterangepicker({
	    singleDatePicker: true,
	    autoApply: true,
        disableTouchKeyboard: true,
	    startDate: moment().add(7, 'days'),
	    minDate: moment().add(7, 'days'),
	    locale: {
	      format: 'YYYY-MM-DD'
	    }
	});

</script>
@endsection