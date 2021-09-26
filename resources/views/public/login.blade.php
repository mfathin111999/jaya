@extends('layout.public')

@section('content')
		<div class="top-bar">
		    <div class="container-fluid">
		        <div class="row align-items-center">
		            <div class="col-lg-4 col-md-12">
		                <div class="logo">
		                    <a href="index.html">
		                        <h1 style="font-size: 30px !important;">Servis Rumah</h1>
		                        <!-- <img src="img/logo.jpg" alt="Logo"> -->
		                    </a>
		                </div>
		            </div>
		            <div class="col-lg-8 col-md-7 d-none d-lg-block">
		                <div class="row">
		                    <div class="col-4">
		                        <div class="top-bar-item">
		                            <div class="top-bar-icon">
		                                <i class="flaticon-calendar"></i>
		                            </div>
		                            <div class="top-bar-text">
		                                <h3>Jam Kerja</h3>
		                                <p>Senin - Jumat, 08:00 - 17:00</p>
		                            </div>
		                        </div>
		                    </div>
		                    <div class="col-4">
		                        <div class="top-bar-item">
		                            <div class="top-bar-icon">
		                                <i class="flaticon-call"></i>
		                            </div>
		                            <div class="top-bar-text">
		                                <h3>Kontak Kami</h3>
		                                <p>+62 812 1996 1904</p>
		                            </div>
		                        </div>
		                    </div>
		                    <div class="col-4">
		                        <div class="top-bar-item">
		                            <div class="top-bar-icon">
		                                <i class="flaticon-send-mail"></i>
		                            </div>
		                            <div class="top-bar-text">
		                                <h3>Email Us</h3>
		                                <p>nru@servisrumah.com</p>
		                            </div>
		                        </div>
		                    </div>
		                </div>
		            </div>
		        </div>
		    </div>
		</div>

		<div class="nav-bar p-0">
		    <div class="container-fluid">
		        <nav class="navbar navbar-expand-lg bg-dark navbar-dark">
		            <a href="{{ url('/') }}" class="text-white">HOME</a>

		        </nav>
		    </div>
		</div>

		<section class="mt-5 mb-5" id="login-section" v-cloak>
			<div class="row">
				<div class="col-4 mx-auto">
					<div class="card shadow">
						<div class="card-header text-center">
							<img src="{{ asset('img/logo.png') }}" style="max-width: 50px;">
						</div>
						<div class="card-body p-4">
							<form v-on:submit.prevent='onSubmitLogin' id="login-forms">
								<div class="form-group">
		                            <label for="emailLogin" class="font-12">Email</label>
		                            <input type="email" class="form-control" id="emailLogin" name="email" placeholder="Masukan email" required="" autocomplete="false">
		                        </div>
		                        <div class="form-group">
		                            <label for="passwordLogin" class="font-12">Kata Sandi</label>
		                            <input type="password" class="form-control" id="passwordLogin" name="password" placeholder="Kata Sandi" required="" autocomplete="false">
		                        </div>
		                        <div class="custom-control custom-checkbox mb-2">
		                          <input type="checkbox" class="custom-control-input" id="customCheck1" name="remember">
		                          <label class="custom-control-label font-12" for="customCheck1">Ingat Saya !</label>
		                        </div>
		                        <button type="submit" class="btn btn-block text-center" style="background-color: #fdbe33;">Login</button>
							</form>
						</div>
						<div class="card-footer font-12 d-flex align-items-center" style="height: 50px;">
							<p class="m-0">Belum punya akun ? &nbsp</p>
							<form method="POST" action="{{ url('register') }}">
								@csrf
	                    		<button type="submit" class="text-info p-0 m-0" data-dismiss="modal" style="background:none; border:none; cursor: pointer;">Daftar</button>
							</form>
						</div>
					</div>		
				</div>
			</div>
		</section>
	@include('layout.footer')
@endsection

@section('sec-js')
<script type="text/javascript">
	var login = new Vue({
		el: '#login-section', 
		data: {
			data: [],
		},
		created: function(){

		},
		methods: {
			onSubmitLogin: function(){
				let form = document.getElementById('login-forms');
				var formData = new FormData(form);

				axios.post(
		            "{{ url('login') }}",
		            formData,
		            {
		              	headers: {
		                	'Content-Type': 'multipart/form-data',
		              	}
		            }
		        )
		        .then(function(response){
                    window.location = "{{ url()->previous() }}";
		        }.bind(this))
		        .catch(function (response) {
                    Swal.fire('Opss', 'Kombinasi Email dan Password Salah !', 'warning');
					// Swal.fire('Opss', response.response.data.message, 'warning');
				});
			},
		}
	})

</script>
@endsection