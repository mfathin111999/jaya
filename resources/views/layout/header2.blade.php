<header id="headerApp" v-cloak>
	<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document" style="max-width: 400px;">
            <div class="modal-content">
                <form>
                    <div class="modal-header d-flex align-items-center justify-content-between">
                        <h5 class="modal-title">Servis Rumah</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="emailLogin">Email</label>
                            <input type="email" class="form-control" id="emailLogin" name="email" placeholder="Masukan email" required="" autocomplete="false">
                        </div>
                        <div class="form-group">
                            <label for="passwordLogin">Kata Sandi</label>
                            <input type="password" class="form-control" id="passwordLogin" name="password" placeholder="Kata Sandi" required="" autocomplete="false">
                        </div>
                        <div class="custom-control custom-checkbox mb-2">
                          <input type="checkbox" class="custom-control-input" id="customCheck1">
                          <label class="custom-control-label" for="customCheck1">Ingat Saya !</label>
                        </div>
                        <button type="submit" class="btn btn-info btn btn-block text-center">Login</button>
                    </div>
                    <div class="modal-footer">
                        <p class="m-0">Belum punya akun ? &nbsp</p>
                        <button class="text-info p-0 m-0" data-dismiss="modal" style="background:none; border:none; cursor: pointer;" @click='signup'>Daftar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="signModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document" style="max-width: 400px;">
            <div class="modal-content">
                <form id="registration" method="POST" action="{{ url('register') }}">
                    <div class="modal-header d-flex align-items-center justify-content-between">
                        <h5 class="modal-title">Servis Rumah</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @csrf
                    <div class="modal-body pl-4 pr-4">
                        <div class="form-group">
                            <label for="nameSign">Nama Lengkap</label>
                            <input type="text" class="form-control" id="nameSign" placeholder="Nama Lengkap" name="name" required="">
                        </div>
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" class="form-control" id="username" placeholder="Username" name="username" required="">
                        </div>
                        <div class="form-group">
                            <label for="emailSign">Email</label>
                            <input type="email" class="form-control" id="emailSign" aria-describedby="emailHelp" name="email" placeholder="Enter email" required="">
                        </div>
                        <div class="form-group">
                            <label for="passwordSign">Password</label>
                            <input type="password" class="form-control" id="passwordSign" placeholder="Password" name="password" minlength="8" required="">
                        </div>
                        <button type="submit" class="btn btn-info btn btn-block text-center">Daftar</button>
                    </div>
                    <div class="modal-footer" style="justify-content: center;">
                        <p class="m-0">Sudah punya akun ? &nbsp</p>
                        <button class="text-info p-0 m-0" data-dismiss="modal" style="background:none; border:none; cursor: pointer;" @click='signup'>Login</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Top Bar Start -->
    <div class="top-bar">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-lg-4 col-md-12">
                    <div class="logo">
                        <a href="index.html">
                            <h1 style="font-size: 40px !important;">Servis Rumah</h1>
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
                                    <p>+62 8810 2355 4758</p>
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
    <!-- Top Bar End -->

    <!-- Nav Bar Start -->
    <div class="nav-bar">
        <div class="container-fluid">
            <nav class="navbar navbar-expand-lg bg-dark navbar-dark">
                <a href="#" class="navbar-brand">MENU</a>
                <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                    <div class="navbar-nav mr-auto">
                        <a href="index.html" class="nav-item nav-link active">Home</a>
                        <div class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Servis</a>
                            <div class="dropdown-menu">
                                <a href="blog.html" class="dropdown-item">Blog Page</a>
                            </div>
                        </div>
                        <a href="portfolio.html" class="nav-item nav-link">Pekerjaan</a>
                        <a href="#" class="nav-item nav-link">Kontak</a>
                        <a href="about.html" class="nav-item nav-link">Tentang Kami</a>
                    </div>
                    <div class="ml-auto">
                    	@auth
                        <button class="btn" href="#">Hallo .. ! {{ auth()->user()->name }}</button>
                        @endauth
                        @guest
                        <button class="btn" href="#" data-target='#loginModal' data-toggle="modal">Login</button>
                        @endguest
                    </div>
                </div>
            </nav>
        </div>
    </div>
</header>

@section('header-js')
<script type="text/javascript">
	var header = new Vue({
		el: '#headerApp', 
		data: {
			data: [],
		},
		created: function(){
			this.getData();
		},
		methods: {
			getData : function(){
	            axios.get("{{ url('api/service') }}").then(function(response){
	              	this.data = response.data.data;
	            }.bind(this));
	        },
			onSubmitLogin: function(){
				let form = document.getElementById('login-form');
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
		        	// console.log(response.data);
		        	this.setSession();

		        }.bind(this))
		        .catch(function (response) {
					//handle error
					Swal.fire('Opss', response.response.data.message, 'warning');
				});
			},
			logout: function(){
				axios.post(
					'{{ route("logout") }}',
					{},
					{
						headers: {
							'Content-Type': 'application/json'
						}
					}
				)
				.then(function(response){
                    window.location = "{{ route('home') }}";
				})
				.catch(function (response) {
					//handle error
					console.log(response);
				});
			},
			setSession: function(){
				axios.post(
					'{{ url("auth/setSession") }}',
					{},
					{
						headers: {
							'Content-Type': 'application/json'
						}
					}
				)
				.then(function(response){
					if (response.data.data.role == 4) {
	                    window.location = "{{ route('home') }}";
	                }else{
	                    window.location = "{{ route('dashboard') }}";
	                }
				})
				.catch(function (response) {
					//handle error
					console.log(response);
				});
			},
			signup: function(){
				this.$nextTick(() => {
					$('#signUp').modal('show');
				});
			},
			login: function(){
				this.$nextTick(() => {
					$('#loginModal').modal('show');
				});
			}
		}
	})

</script>
@endsection