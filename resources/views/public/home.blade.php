@extends('layout.public')

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

		.btn-submited{
			padding: 16px 30px;
			font-size: 16px;
			font-weight: 600;
			color: #ffffff;
			background: #030f27;
			border: none;
			border-radius: 0;
			transition: .3s;
		}

		.back-to-whatsapp {
		    position: fixed;
		    display: inline;
		    color: #121518;
		    width: 75px;
		    height: 75px;
		    text-align: center;
		    line-height: 1;
		    font-size: 22px;
		    right: 0px;
		    bottom: 75px;
		    z-index: 9;
		}

		.back-to-whatsapp:hover {
		    transform: scale(1.5);
		}
	</style>
@endsection

@section('content')
	@include('layout.header')
	<div id="app" v-cloak>
	    <!-- Carousel Start -->
	    <div id="carousel" class="carousel slide" data-ride="carousel">
	        <ol class="carousel-indicators">
	            <li data-target="#carousel" data-slide-to="0" class="active"></li>
	            <li data-target="#carousel" data-slide-to="1"></li>
	            <li data-target="#carousel" data-slide-to="2"></li>
	        </ol>
	        <div class="carousel-inner">
	            <div class="carousel-item active">
	                <img src="{{ asset('img/carousel-1.jpg') }}" alt="Carousel Image">
	                <div class="carousel-caption">
	                    <p class="animated fadeInRight">Profesionalitas</p>
	                    <h1 class="animated fadeInLeft">For Your Dream Project</h1>

	                    @auth
	                    	<a class="btn animated fadeInUp" v-on:click="toSelection">Ayo mulai bekerja besama kami</a>
	                    @endauth

	                    @guest
	                    <a class="btn animated fadeInUp"  href="#" data-target='#loginModal' data-toggle="modal">Daftar Untuk Memulai</a>
	                    @endguest
	                </div>
	            </div>

	            <div class="carousel-item">
	                <img src="{{ asset('img/carousel-2.jpg') }}" alt="Carousel Image">
	                <div class="carousel-caption">
	                    <p class="animated fadeInRight">Pekerja Profesional</p>
	                    <h1 class="animated fadeInLeft">We Build Your Home</h1>
	                    @auth
	                    	<a class="btn animated fadeInUp" v-on:click="toSelection">Ayo mulai bekerja besama kami</a>
	                    @endauth

	                    @guest
	                    <a class="btn animated fadeInUp"  href="#" data-target='#loginModal' data-toggle="modal">Daftar Untuk Memulai</a>
	                    @endguest
	                </div>
	            </div>

	            <div class="carousel-item">
	                <img src="{{ asset('img/carousel-3.jpg') }}" alt="Carousel Image">
	                <div class="carousel-caption">
	                    <p class="animated fadeInRight">Terpercaya</p>
	                    <h1 class="animated fadeInLeft">For Your Dream Home</h1>
	                    @auth
	                    	<a class="btn animated fadeInUp" v-on:click="toSelection">Ayo mulai bekerja besama kami</a>
	                    @endauth

	                    @guest
	                    <a class="btn animated fadeInUp"  href="#" data-target='#loginModal' data-toggle="modal">Daftar Untuk Memulai</a>
	                    @endguest
	                </div>
	            </div>
	        </div>

	        <a class="carousel-control-prev" href="#carousel" role="button" data-slide="prev">
	            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
	            <span class="sr-only">Previous</span>
	        </a>
	        <a class="carousel-control-next" href="#carousel" role="button" data-slide="next">
	            <span class="carousel-control-next-icon" aria-hidden="true"></span>
	            <span class="sr-only">Next</span>
	        </a>
	    </div>
	    <!-- Carousel End -->

		<!-- Feature Start-->
	    <div class="feature wow fadeInUp" data-wow-delay="0.1s">
	        <div class="container-fluid">
	            <div class="row align-items-center">
	                <div class="col-lg-4 col-md-12">
	                    <div class="feature-item">
	                        <div class="feature-icon">
	                            <i class="flaticon-worker"></i>
	                        </div>
	                        <div class="feature-text">
	                            <h3>Pekerja Profesional</h3>
	                            <p>Pekerja yang telah mengikuti proses training dan dituntut memiliki kemampuan dalam bidang konstruksi.</p>
	                        </div>
	                    </div>
	                </div>
	                <div class="col-lg-4 col-md-12">
	                    <div class="feature-item">
	                        <div class="feature-icon">
	                            <i class="flaticon-building"></i>
	                        </div>
	                        <div class="feature-text">
	                            <h3>Ahli Dibidangnya</h3>
	                            <p>Teruji dengan banyak nya pekerjaan dengan feedback baik.</p>
	                        </div>
	                    </div>
	                </div>
	                <div class="col-lg-4 col-md-12">
	                    <div class="feature-item">
	                        <div class="feature-icon">
	                            <i class="flaticon-call"></i>
	                        </div>
	                        <div class="feature-text">
	                            <h3>Fast Response</h3>
	                            <p>Pelayanan yang cepat, mudah dan praktis.</p>
	                        </div>
	                    </div>
	                </div>
	            </div>
	        </div>
	    </div>
	    <!-- Feature End-->

		<!-- Contact Start-->
	    <div class="contact wow fadeInUp" id="reservation-selection">
	        <div class="container">
	            <div class="section-header text-center">
	                <p>Apa Yang Anda Butuhkan ?</p>
	                <h2>Beri tahu kami kebutuhan anda .. !</h2>
	            </div>
	            @auth
		            <form v-on:submit.prevent="sendReservation" id="form-engagement">
		            <div class="row">
		                <div class="col-md-6">
		                    <div class="control-group">
					            <label class="font-12 text-white" for="name">Nama</label>
					            <input type="text" class="form-control" id="name" name="name" placeholder="Nama" required="">
					        </div>
					        <div class="control-group pt-2">
					            <label class="font-12 text-white" for="phone_number">No Handphone</label>
					            <input type="text" class="form-control" id="phone_number" name="phone_number" placeholder="Whatsapp / Handphone" required="">
					        </div>
					        <div class="row">
					        	<div class="col-md-6 py-2">
						        	<div class="control-group">
							            <label class="font-12 text-white" for="province">Provinsi</label>
							            <select type="text" class="form-control" id="province" name="province_id" v-model='thisProvince' @change='getRegency()' required="">
							            	<option value="">Pilih</option>
							            	<option v-for = '(province, index) in province' :value = 'province.id'>@{{ ucwords(province.name) }}</option>
							            </select>
							        </div>
						        </div>
						        <div class="col-md-6 py-2">
						        	<div class="control-group">
							            <label class="font-12 text-white" for="regency">Kota/Kabupaten</label>
							            <select type="text" class="form-control" id="regency" name="regency_id" v-model='thisRegency' @change='getDistrict()' required="">
							            	<option value="">Pilih</option>
		              						<option v-for = '(regency, index) in regency' :value="regency.id">@{{ ucwords(regency.name) }}</option>
							            </select>
							        </div>
						        </div>
						        <div class="col-md-6 py-2">
						        	<div class="control-group">
							            <label class="font-12 text-white" for="district">Kecamatan</label>
							            <select type="text" class="form-control" id="district" name="district_id" v-model='thisDistrict' @change='getVillage()' required="">
							            	<option value="">Pilih</option>
							            	<option v-for = '(district, index) in district' :value = 'district.id'>@{{ ucwords(district.name) }}</option>
							            </select>
							        </div>
						        </div>
						        <div class="col-md-6 py-2" style="background-color: #030f27;">
						        	<div class="control-group">
							            <label class="font-12 text-white" for="village">Kelurahan</label>
							            <select type="text" class="form-control" id="village" name="village_id" v-model='thisVillage' required="">
							            	<option value="">Pilih</option>
							            	<option v-for = '(village, index) in village' :value = 'village.id'>@{{ ucwords(village.name) }}</option>
							            </select>
							        </div>
						        </div>
					        </div>
					         <div class="control-group">
					            <label class="font-12 text-white" for="address">Alamat</label>
					            <input type="text" class="form-control" id="address" name="address" placeholder="Masukan Alamat Rumah" required="">
					        </div>
					        <div class="loading-class justify-content-center align-items-center d-none" style="position: absolute; width: 100%; height: 100%; top: 0; left: 0; background-color: #0000007d;">
						        <div class="loader" id="loading" style=""></div>
					        </div>
		                </div>
		                <div class="col-md-6">
		                    <div class="row">
								<div class="col-md-6 pt-0 pb-0" style="background-color: #fdbe33;">
									<div class="control-group">
							            <label class="font-12 text-black" for="date">Tanggal</label>
							            <input type="text" class="form-control datePicker" id="date" name="date" placeholder="YYYY-MM-DD" required="">
							        </div>
								</div>
								<div class="col-md-6 pt-0 pb-0" style="background-color: #fdbe33;">
									<div class="control-group">
							            <label class="font-12 text-black" for="time">Waktu</label>
							            <select class="form-control" name="time" id="time" required="">
							            	<option value="">Pilih</option>
							            	<option v-for= 'times in time' :value="times">@{{ times }}</option>
							            </select>
							        </div>
								</div>
							</div>
							<div class="control-group pt-2">
					            <label class="font-12 text-black" for="service">Servis</label>
					            <select type="text" class="form-control select2" id="service" name="service[]" multiple="" required="">
					            	<option v-for = "(service, index) in service" :value = 'service.id'>@{{ service.name }}</option>
					            </select>
					        </div>
							<div class="control-group pt-2">
					            <label class="font-12 text-black" for="description">Deskripsi ( 300 Karakter )</label>
					            <textarea type="text" class="form-control" id="description" name="description" placeholder="Deskripsi Keperluan" rows="6" maxlength="300" required=""></textarea>
					            <label id="maxDescription" class="mb-0 mt-2 font-12 text-black">300 Karakter tersisa</label>
					        </div>
					        <div class="mt-5 text-right">
		                        <button class="btn-theme btn-submited" type="submit" id="sendMessageButton">Kirim Reservasi Survei Lapangan</button>
		                        <div class="loading-class justify-content-center align-items-center d-none" style="position: absolute; width: 100%; height: 100%; top: 0; left: 0; background-color: #0000007d;">
							        <div class="loader" id="loading" style=""></div>
						        </div>			        	
					        </div>
		                </div>
		            </div>
		            </form>
	            @endauth

	            @guest
		            <div class="text-center mt-5 mb-5">
		                <button class="btn-theme btn-submited" href="#" data-target='#loginModal' data-toggle="modal">Daftar Untuk Memulai</button>
		            </div>
	            @endguest
	        </div>
	    </div> 
	    <!-- Contact End-->

	    <!-- About Start -->
	    <div class="about wow fadeInUp" id="about_us" data-wow-delay="0.1s">
	        <div class="container">
	            <div class="row align-items-center">
	                <div class="col-lg-5 col-md-6">
	                    <div class="about-img">
	                        <img src="img/about.jpg" alt="Image">
	                    </div>
	                </div>
	                <div class="col-lg-7 col-md-6">
	                    <div class="section-header text-left">
	                        <p>Selamat Datang di Servis Rumah</p>
	                        <h2>Dengan Pengalaman Bertahun Tahun</h2>
	                    </div>
	                    <div class="about-text">
	                        <p class="text-justify">
	                            Puji syukur kita panjatkan kehadirat Allah SWT. Pada kesempatan ini perkenankanlah kami memperkenalkan diri, bahwa kami adalah perusahaan yang bergerak dalam bidang :
							</p>
							<ul>
								<li>
							Kontraktor Sipil Bangunan
								</li>
								<li>
							Perdagangan dan Supplier
								</li>
								<li>
							Refrigerasi dan Teknologi Mesin Pendingin (AC)
								</li>
							</ul>
							<p class="text-justify">
								Sejak didirikan sampai dengan sekarang, alhamdulillah PT. Nurani Rejeki Unggul telah mampu menjalin kerjasama dan memberikan kontribusi terbaik dalam mengoptimalkan kinerja customernya dalam mencapai target yang diharapkan. 
								<br>
								<br>
								Insya Allah kami senantiasa berupaya amanah dan bekerja optimal dalam mengemban kepercayaan customer kami.
								<br>
								<br>
								<strong>
									Hormat kami,
									<br>
									PT. Nurani Rejeki Unggul 
								</strong>
	                        </p>
	                    </div>
	                </div>
	            </div>
	        </div>
	    </div>
	    <!-- About End -->

	    <!-- Fact Start -->
	    <div class="fact">
	        <div class="container-fluid">
	            <div class="row counters">
	                <div class="col-md-6 fact-left wow slideInLeft">
	                    <div class="row">
	                        <div class="col-6">
	                            <div class="fact-icon">
	                                <i class="flaticon-worker"></i>
	                            </div>
	                            <div class="fact-text">
	                                <h2 data-toggle="counter-up">33</h2>
	                                <p>Expert Workers</p>
	                            </div>
	                        </div>
	                        <div class="col-6">
	                            <div class="fact-icon">
	                                <i class="flaticon-building"></i>
	                            </div>
	                            <div class="fact-text">
	                                <h2 data-toggle="counter-up">120</h2>
	                                <p>Happy Clients</p>
	                            </div>
	                        </div>
	                    </div>
	                </div>
	                <div class="col-md-6 fact-right wow slideInRight">
	                    <div class="row">
	                        <div class="col-6">
	                            <div class="fact-icon">
	                                <i class="flaticon-address"></i>
	                            </div>
	                            <div class="fact-text">
	                                <h2 data-toggle="counter-up">132</h2>
	                                <p>Completed Projects</p>
	                            </div>
	                        </div>
	                        <div class="col-6">
	                            <div class="fact-icon">
	                                <i class="flaticon-crane"></i>
	                            </div>
	                            <div class="fact-text">
	                                <h2 data-toggle="counter-up">20</h2>
	                                <p>Running Projects</p>
	                            </div>
	                        </div>
	                    </div>
	                </div>
	            </div>
	        </div>
	    </div>
	    <!-- Fact End -->

	    <!-- Service Start -->
	    <div class="service" id="services">
	        <div class="container">
	            <div class="section-header text-center">
	                <p>Servis Kami</p>
	                <h3 class="font-weight-bold">Kami Menyediakan Berbagai Macam Servis</h3>
	            </div>
	            <div class="row">
	                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
	                    <div class="service-item">
	                        <div class="service-img">
	                            <img src="{{ asset('img/all/focus-interior.png') }}" alt="Image">
	                            <div class="service-overlay">
	                                <p>
	                                    Kami menyediakan jasa interior, renovasi bangungan, jalan, pagar, pengecatan, pekerjaan pipa, tanki timbun, pemeliharaan gedung, dan penataan taman.
	                                </p>
	                            </div>
	                        </div>
	                        <div class="service-text">
	                            <h3>Design Interior</h3>
	                            <a class="btn" href="{{ asset('img/all/focus-interior.png') }}" data-lightbox="service">+</a>
	                        </div>
	                    </div>
	                </div>
	                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.2s">
	                    <div class="service-item">
	                        <div class="service-img">
	                            <img src="{{ asset('img/all/focus-supplied.png') }}" alt="Image">
	                            <div class="service-overlay">
	                                <p>
                                      	Pengadaan alat dan barang diantaranya alat – alat komponen sipil, alat kelistrikan, serta berbagai peralatan perlengkapan keselamatan Kerja dan Kesehatan Kerja
	                                </p>
	                            </div>
	                        </div>
	                        <div class="service-text">
	                            <h3>Umum dan Supplier</h3>
	                            <a class="btn" href="{{ asset('img/all/focus-supplied.png') }}" data-lightbox="service">+</a>
	                        </div>
	                    </div>
	                </div>
	                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
	                    <div class="service-item">
	                        <div class="service-img">
	                            <img src="{{ asset('img/all/focus-mechanical.png') }}" alt="Image">
	                            <div class="service-overlay">
	                                <p>
	                                    Mengerjakan Perbaikan Instalasi Listrik, Mesin Pompa serta Jasa Service dan Pengadaan AC
	                                </p>
	                            </div>
	                        </div>
	                        <div class="service-text">
	                            <h3>Mekanikal Elektrikal & Refrigerasi serta Teknologi Pendingin</h3>
	                            <a class="btn" href="{{ asset('img/all/focus-mechanical.png') }}" data-lightbox="service">+</a>
	                        </div>
	                    </div>
	                </div>
	            </div>
	        </div>
	    </div>
	    <!-- Service End -->

	    <!-- Team Start -->
	    <div class="team">
	        <div class="container">
	            <div class="section-header text-center">
	                <p>Team Kami</p>
	                <h2>Bekerja dengan Kami</h2>
	            </div>
	            <div class="row align-items-center justify-content-between">
	                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
	                    <div class="team-item">
	                        <div class="team-img">
	                            <img src="{{ asset('img/team/team-ceo.png') }}" alt="Team Image">
	                        </div>
	                        <div class="team-text">
	                            <h2>Jaedi</h2>
	                            <p>CEO & Founder</p>
	                        </div>
	                        <div class="team-social">
	                            <a class="social-tw" href=""><i class="fab fa-twitter"></i></a>
	                            <a class="social-fb" href=""><i class="fab fa-facebook-f"></i></a>
	                            <a class="social-li" href=""><i class="fab fa-linkedin-in"></i></a>
	                            <a class="social-in" href=""><i class="fab fa-instagram"></i></a>
	                        </div>
	                    </div>
	                </div>
	                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.2s">
	                    <div class="team-item">
	                        <div class="team-img">
	                            <img src="{{ asset('img/team/team-head-operation.png') }}" alt="Team Image">
	                        </div>
	                        <div class="team-text">
	                            <h2>Firman</h2>
	                            <p>Head of Operational</p>
	                        </div>
	                        <div class="team-social">
	                            <a class="social-tw" href=""><i class="fab fa-twitter"></i></a>
	                            <a class="social-fb" href=""><i class="fab fa-facebook-f"></i></a>
	                            <a class="social-li" href=""><i class="fab fa-linkedin-in"></i></a>
	                            <a class="social-in" href=""><i class="fab fa-instagram"></i></a>
	                        </div>
	                    </div>
	                </div>
	                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
	                    <div class="team-item">
	                        <div class="team-img">
	                            <img src="{{ asset('img/team/team-head-finance.png') }}" alt="Team Image">
	                        </div>
	                        <div class="team-text">
	                            <h2>Andi</h2>
	                            <p>Head of Finance</p>
	                        </div>
	                        <div class="team-social">
	                            <a class="social-tw" href=""><i class="fab fa-twitter"></i></a>
	                            <a class="social-fb" href=""><i class="fab fa-facebook-f"></i></a>
	                            <a class="social-li" href=""><i class="fab fa-linkedin-in"></i></a>
	                            <a class="social-in" href=""><i class="fab fa-instagram"></i></a>
	                        </div>
	                    </div>
	                </div>
	                {{-- <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.4s">
	                    <div class="team-item">
	                        <div class="team-img">
	                            <img src="{{ asset('img/team-member.png') }}" alt="Team Image">
	                        </div>
	                        <div class="team-text">
	                            <h2>Sandi</h2>
	                            <p>Profesional Team</p>
	                        </div>
	                        <div class="team-social">
	                            <a class="social-tw" href=""><i class="fab fa-twitter"></i></a>
	                            <a class="social-fb" href=""><i class="fab fa-facebook-f"></i></a>
	                            <a class="social-li" href=""><i class="fab fa-linkedin-in"></i></a>
	                            <a class="social-in" href=""><i class="fab fa-instagram"></i></a>
	                        </div>
	                    </div>
	                </div> --}}
	            </div>
	        </div>
	    </div>
	    <!-- Team End -->


	    <!-- Portofolio Start -->
	    <div class="portfolio" id="works">
            <div class="container">
                <div class="section-header text-center">
                    <p>Pekerjaan Kami</p>
                    <h3 class="font-weight-bold">Pekerjaan - pekerjaan yang telah kami selesaikan</h3>
                </div>
                <div class="row">
                    <div class="col-lg-4 col-md-6 col-sm-12 first wow fadeInUp" data-wow-delay="0.1s">
                        <div class="portfolio-warp">
                            <div class="portfolio-img">
                                <img src="{{ asset('img/project/atap-bp2ip-banten.png') }}" alt="Image">
                                <div class="portfolio-overlay">
                                    <p>
                                        Perbaikan Atap di BP2IP Banten.
                                    </p>
                                </div>
                            </div>
                            <div class="portfolio-text">
                                <h3>Perbaikan Atap</h3>
                                <a class="btn" href="{{ asset('img/project/atap-bp2ip-banten.png') }}" data-lightbox="portfolio">+</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-12 second wow fadeInUp" data-wow-delay="0.2s">
                        <div class="portfolio-warp">
                            <div class="portfolio-img">
                                <img src="{{ asset('img/project/cakar-ayam-stip-jakarta.png') }}" alt="Image">
                                <div class="portfolio-overlay">
                                    <p>
                                        Pemasangan cakar ayam dan pondasi di STIP Jakarta.
                                    </p>
                                </div>
                            </div>
                            <div class="portfolio-text">
                                <h3>Pondasi Cakar Ayam</h3>
                                <a class="btn" href="{{ asset('img/project/cakar-ayam-stip-jakarta.png') }}" data-lightbox="portfolio">+</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-12 third wow fadeInUp" data-wow-delay="0.3s">
                        <div class="portfolio-warp">
                            <div class="portfolio-img">
                                <img src="{{ asset('img/project/cat-pipa-hydran.png') }}" alt="Image">
                                <div class="portfolio-overlay">
                                    <p>
                                        Pengecatan Pipa Hydran
                                    </p>
                                </div>
                            </div>
                            <div class="portfolio-text">
                                <h3>Pengecatan Hydran</h3>
                                <a class="btn" href="{{ asset('img/project/cat-pipa-hydran.png') }}" data-lightbox="portfolio">+</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-12 first wow fadeInUp" data-wow-delay="0.4s">
                        <div class="portfolio-warp">
                            <div class="portfolio-img">
                                <img src="{{ asset('img/project/cat-stip-jakarta.png') }}" alt="Image">
                                <div class="portfolio-overlay">
                                    <p>
                                        Project Pengecatan di STIP Jakarta.
                                    </p>
                                </div>
                            </div>
                            <div class="portfolio-text">
                                <h3>Pengecatan Bangunan</h3>
                                <a class="btn" href="{{ asset('img/project/cat-stip-jakarta.png') }}" data-lightbox="portfolio">+</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-12 second wow fadeInUp" data-wow-delay="0.5s">
                        <div class="portfolio-warp">
                            <div class="portfolio-img">
                                <img src="{{ asset('img/project/hydran-stip-jakarta.png') }}" alt="Image">
                                <div class="portfolio-overlay">
                                    <p>
                                        Perbaikan Pompa Hydran di STIP Jakarta.
                                    </p>
                                </div>
                            </div>
                            <div class="portfolio-text">
                                <h3>Perbaikan Hydran</h3>
                                <a class="btn" href="{{ asset('img/project/hydran-stip-jakarta.png') }}" data-lightbox="portfolio">+</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-12 third wow fadeInUp" data-wow-delay="0.6s">
                        <div class="portfolio-warp">
                            <div class="portfolio-img">
                                <img src="{{ asset('img/project/kramik-stip-jakarta.png') }}" alt="Image">
                                <div class="portfolio-overlay">
                                    <p>
                                        Pemasangan Kramik Lantai di STIP Jakarta.
                                    </p>
                                </div>
                            </div>
                            <div class="portfolio-text">
                                <h3>Perbaikan Lantai</h3>
                                <a class="btn" href="{{ asset('img/project/kramik-stip-jakarta.png') }}" data-lightbox="portfolio">+</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-12 third wow fadeInUp" data-wow-delay="0.6s">
                        <div class="portfolio-warp">
                            <div class="portfolio-img">
                                <img src="{{ asset('img/project/paving-bp2ip-banten.png') }}" alt="Image">
                                <div class="portfolio-overlay">
                                    <p>
                                        Pemasangan Paving Blok di BP2IP Banten.
                                    </p>
                                </div>
                            </div>
                            <div class="portfolio-text">
                                <h3>Pemasangan Paving</h3>
                                <a class="btn" href="{{ asset('img/project/paving-bp2ip-banten.png') }}" data-lightbox="portfolio">+</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-12 third wow fadeInUp" data-wow-delay="0.6s">
                        <div class="portfolio-warp">
                            <div class="portfolio-img">
                                <img src="{{ asset('img/project/perawatan-ac.png') }}" alt="Image">
                                <div class="portfolio-overlay">
                                    <p>
                                        Perawatan AC.
                                    </p>
                                </div>
                            </div>
                            <div class="portfolio-text">
                                <h3>Perawatan AC</h3>
                                <a class="btn" href="{{ asset('img/project/perawatan-ac.png') }}" data-lightbox="portfolio">+</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-12 third wow fadeInUp" data-wow-delay="0.6s">
                        <div class="portfolio-warp">
                            <div class="portfolio-img">
                                <img src="{{ asset('img/project/pemasangan-ac-split.png') }}" alt="Image">
                                <div class="portfolio-overlay">
                                    <p>
                                        Pemasangan dan perawatan AC Split.
                                    </p>
                                </div>
                            </div>
                            <div class="portfolio-text">
                                <h3>Pasang AC Split</h3>
                                <a class="btn" href="{{ asset('img/project/pemasangan-ac-split.png') }}" data-lightbox="portfolio">+</a>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- <div class="row">
                    <div class="col-12 load-more">
                        <a class="btn" href="#">Load More</a>
                    </div>
                </div> --}}
            </div>
        </div>
	    <!-- Portofolio End -->

	    <!-- FAQs Start -->
	    <div class="faqs">
	        <div class="container">
	            <div class="section-header text-center">
	                <p>Pertanyaan Yang Sering Diajukan</p>
	                <h2>Hubungi Kami</h2>
	            </div>
	            <div class="row">
	                <div class="col-md-6">
	                    <div id="accordion-1">
	                        <div class="card wow fadeInLeft" data-wow-delay="0.1s">
	                            <div class="card-header">
	                                <a class="card-link collapsed" data-toggle="collapse" href="#collapseOne">
	                                    Apa itu <strong>Servisrumah.com</strong> ?
	                                </a>
	                            </div>
	                            <div id="collapseOne" class="collapse" data-parent="#accordion-1">
	                                <div class="card-body text-justify">
	                                    <strong>Servisrumah.com</strong> dalah layanan online yang dapat menghubungkan Anda dengan para penyedia layanan perbaikan professional, amanah dan terpercaya. <br><br>
	                                    <strong>Servisrumah.com</strong> siap memudahkan Anda untuk mencari penyedia layanan servis/perbaikan profesional dengan dukungan transaksi secara aman dan nyaman berbasis online.
	                                </div>
	                            </div>
	                        </div>
	                        <div class="card wow fadeInLeft" data-wow-delay="0.2s">
	                            <div class="card-header">
	                                <a class="card-link collapsed" data-toggle="collapse" href="#collapseTwo">
	                                    Apakah <strong>Servisrumah.com</strong> memberikan garansi untuk setiap pekerjaan yang di pesan ?
	                                </a>
	                            </div>
	                            <div id="collapseTwo" class="collapse" data-parent="#accordion-1">
	                                <div class="card-body text-justify">
	                                    Ya, kami menggaransi semua yang kami kerjakan, dan kami respon 1 x 24 jam.
	                                </div>
	                            </div>
	                        </div>
	                        <div class="card wow fadeInLeft" data-wow-delay="0.3s">
	                            <div class="card-header">
	                                <a class="card-link collapsed" data-toggle="collapse" href="#collapseThree">
	                                    Bagaimana jika ada pertanyaan lain yang belum sempat saya tanyakan ?
	                                </a>
	                            </div>
	                            <div id="collapseThree" class="collapse" data-parent="#accordion-1">
	                                <div class="card-body text-justify">
	                                    Silahkan anda menghubungi kami melalui pesan whatsapp (0857-7768-6367).
	                                </div>
	                            </div>
	                        </div>
	                        <div class="card wow fadeInLeft" data-wow-delay="0.4s">
	                            <div class="card-header">
	                                <a class="card-link collapsed" data-toggle="collapse" href="#collapseFour">
	                                    Bagaimana cara memesan jasa servis rumah ini ?
	                                </a>
	                            </div>
	                            <div id="collapseFour" class="collapse" data-parent="#accordion-1">
	                                <div class="card-body text-justify">
	                                    Anda dapat menghubungi kami melalui website aplikasi kami di www.<strong>Servisrumah.com</strong> atau langsung menghubugi kami melalui WhatsApp 0857-7768-6367 dan bicarakan kepada kami mengenai rencana servis atau perbaikan property anda
	                                </div>
	                            </div>
	                        </div>
	                        <div class="card wow fadeInLeft" data-wow-delay="0.5s">
	                            <div class="card-header">
	                                <a class="card-link collapsed" data-toggle="collapse" href="#collapseFive">
	                                    Apakah dalam setiap pengerjaan harus membayar DP (Down Payment) ?
	                                </a>
	                            </div>
	                            <div id="collapseFive" class="collapse" data-parent="#accordion-1">
	                                <div class="card-body text-justify">
	                                    Ya, setiap pengerjaan harus di sertakan DP (down Payment) sebagai tanda keseriusan Anda dalam menggunakan layanan servis atau perbaikan kami
	                                </div>
	                            </div>
	                        </div>
	                    </div>
	                </div>
	                <div class="col-md-6">
	                    <div id="accordion-2">
	                        <div class="card wow fadeInRight" data-wow-delay="0.1s">
	                            <div class="card-header">
	                                <a class="card-link collapsed" data-toggle="collapse" href="#collapseSix">
	                                    Apakah Harga dalam servis bisa ditawar ?
	                                </a>
	                            </div>
	                            <div id="collapseSix" class="collapse" data-parent="#accordion-2">
	                                <div class="card-body text-justify">
	                                    Kami menawarkan jasa servis dengan  professional dan terpercaya, sehingga untuk harga sudah disesuakan dengan se proporsinal mungkin.
	                                </div>
	                            </div>
	                        </div>
	                        <div class="card wow fadeInRight" data-wow-delay="0.2s">
	                            <div class="card-header">
	                                <a class="card-link collapsed" data-toggle="collapse" href="#collapseSeven">
	                                    Sejauh mana jangkauan pelayanan <strong>Servisrumah.com</strong> ini ?
	                                </a>
	                            </div>
	                            <div id="collapseSeven" class="collapse" data-parent="#accordion-2">
	                                <div class="card-body text-justify">
	                                    Untuk saat ini  jasa servis kami melayani Area Jabodetabek.
	                                </div>
	                            </div>
	                        </div>
	                        <div class="card wow fadeInRight" data-wow-delay="0.3s">
	                            <div class="card-header">
	                                <a class="card-link collapsed" data-toggle="collapse" href="#collapseEight">
	                                    Mengapa memilih <strong>Servisrumah.com</strong>?
	                                </a>
	                            </div>
	                            <div id="collapseEight" class="collapse" data-parent="#accordion-2">
	                                <div class="card-body text-justify">
	                                    <strong>Servisrumah.com</strong> didukung oleh tenaga-tenaga professional dibidang nya, dan  memberikan pelayanan sepenuh hati untuk mencapai kepuasaan dan kenyamanan pelanggan.
	                                </div>
	                            </div>
	                        </div>
	                        <div class="card wow fadeInRight" data-wow-delay="0.4s">
	                            <div class="card-header">
	                                <a class="card-link collapsed" data-toggle="collapse" href="#collapseNine">
	                                    Apa yang harus saya lakukan apabila penyedia jasa <strong>Servisrumah.com</strong> tidak bisa dihubungi ?
	                                </a>
	                            </div>
	                            <div id="collapseNine" class="collapse" data-parent="#accordion-2">
	                                <div class="card-body text-justify">
	                                    Tunggu beberapa saat untuk memberikan kesempatan kepada kami untuk menghubungi Anda kembali. Penyedia jasa kami mungkin sedang dalam perjalanan atau masih mengerjakan pekerjaan jasa di tempat lain sehingga tidak bisa langsung membalas Anda.
	                                </div>
	                            </div>
	                        </div>
	                        <div class="card wow fadeInRight" data-wow-delay="0.5s">
	                            <div class="card-header">
	                                <a class="card-link collapsed" data-toggle="collapse" href="#collapseTen">
	                                    Berapa lama saya harus menunggu menerima penawaran untuk jasa <strong>Servisrumah.com</strong> ?
	                                </a>
	                            </div>
	                            <div id="collapseTen" class="collapse" data-parent="#accordion-2">
	                                <div class="card-body text-justify">
	                                    Waktu tunggu bervariasi sesuai dengan lokasi, kategori jasa, dan waktu permintaan jasa Anda. Anda dapat menerima penawaran dalam hitungan  jam atau hari. Sebagai referensi, pada jam kerja dan untuk wilayah jabodetabek, rata-rata customer mendapatkan penawaran pertama dalam waktu ± 24 jam 1(satu) hari.
	                                </div>
	                            </div>
	                        </div>
	                    </div>
	                </div>
	            </div>
	        </div>
	    </div>
	    <!-- FAQs End -->

	</div>
    <a href="https://wa.me/6281224169630?text=Salam, saya ingin bertanya mengenai ServisRumah.com" target="_blank" class="back-to-whatsapp"><img src="{{ asset('img/whatsapp.png') }}" class="img-fluid"></a>
    <a href="#" class="back-to-top"><i class="fa fa-chevron-up"></i></a>
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
      mounted: function(){
        this.loadProvince();
        this.loadService();
        this.loadTime();
        this.isInvalidDated();
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
        isInvalidDated : function(){
          axios.get("{{ url('api/getDisableDate') }}").then(function(response){
          	app.$nextTick(()=>{
				$('.datePicker').daterangepicker({
				    singleDatePicker: true,
				    autoApply: true,
			        disableTouchKeyboard: true,
				    startDate: moment().add(7, 'days'),
				    minDate: moment().add(7, 'days'),
				    isInvalidDate: function(ele) {
					    var currDate = moment(ele._d).format('YYYY-MM-DD');
					    return response.data.data.indexOf(currDate) != -1;
					},
				    locale: {
				      format: 'YYYY-MM-DD'
				    }
				});
	        });
          }.bind(this));
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
        	@auth
        	if ({{ auth()->user()->role }} != 4) {
        		Swal.fire('Opss !', 'Anda tidak dapat melakukan transaksi ini', 'warning');
        	}else{
	        	this.$nextTick(()=>{
		        	$(".loading-class").removeClass('d-none');
		            $(".loading-class").addClass('d-flex');
	        	});

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
	              	Swal.fire('Success', 'Terima Kasih! Reservasi anda akan kami tinjau', 'success');
	              	app.$nextTick(()=>{
	              		$(".select2").val("");
						$(".select2").trigger("change");
						$(".loading-class").removeClass('d-flex');
	              		$(".loading-class").addClass('d-none');
	              	});
	            });
	        }
	        @endauth
        },
        toSelection(){
        	$("html, body").animate({ scrollTop: $('#reservation-selection').offset().top }, 1000);
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
		placeholder: "Pilih service ( Bisa lebih dari 1 )"
	});
</script>
@endsection