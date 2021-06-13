<header id="headerApp" v-cloak>
	<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document" style="max-width: 400px;">
            <div class="modal-content">
                <form v-on:submit.prevent='onSubmitLogin' id="login-form">
                    <div class="modal-header d-flex align-items-center justify-content-between">
                        <h5 class="modal-title">Servis Rumah</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="emailLogin" class="font-12">Email</label>
                            <input type="email" class="form-control" id="emailLogin" name="email" placeholder="Masukan email" required="" autocomplete="false">
                        </div>
                        <div class="form-group">
                            <label for="passwordLogin" class="font-12">Kata Sandi</label>
                            <input type="password" class="form-control" id="passwordLogin" name="password" placeholder="Kata Sandi" required="" autocomplete="false">
                        </div>
                        <div class="custom-control custom-checkbox mb-2">
                          <input type="checkbox" class="custom-control-input" id="customCheck1">
                          <label class="custom-control-label font-12" for="customCheck1">Ingat Saya !</label>
                        </div>
                        <button type="submit" class="btn btn-info btn-block text-center">Login</button>
                    </div>
                    <div class="modal-footer font-12">
                        <p class="m-0">Belum punya akun ? &nbsp</p>
                        <button class="text-info p-0 m-0" data-dismiss="modal" style="background:none; border:none; cursor: pointer;" data-target='#signModal' data-toggle="modal" >Daftar</button>
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
                        @if ($errors->any())
                            @foreach ($errors->all() as $error)
                                <div class="alert alert-danger">
                                    {{ $error }}
                                </div>
                            @endforeach
                        @endif
                        <div class="form-group">
                            <label for="nameSign" class="font-12">Nama Lengkap</label>
                            <input type="text" value="{{request()->old('name')}}" class="form-control" id="nameSign" placeholder="Nama Lengkap" name="name" required="">
                        </div>
                        <div class="form-group">
                            <label for="username" class="font-12">Username</label>
                            <input type="text" value="{{request()->old('username')}}" class="form-control" id="username" placeholder="Username" name="username" required="">
                        </div>
                        <div class="form-group">
                            <label for="emailSign" class="font-12">Email</label>
                            <input type="email" value="{{request()->old('email')}}" class="form-control" id="emailSign" aria-describedby="emailHelp" name="email" placeholder="Enter email" required="">
                        </div>
                        <div class="form-group">
                            <label for="passwordSign" class="font-12">Password</label>
                            <input type="password" value="{{request()->old('password')}}" class="form-control" id="passwordSign" placeholder="Password" name="password" minlength="8" required="">
                        </div>
                        <button type="submit" class="btn btn-info btn btn-block text-center">Daftar</button>
                    </div>
                    <div class="modal-footer font-12" style="justify-content: center;">
                        <p class="m-0">Sudah punya akun ? &nbsp</p>
                        <button class="text-info p-0 m-0" data-dismiss="modal" style="background:none; border:none; cursor: pointer;"  data-target='#loginModal' data-toggle="modal" >Login</button>
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
    <!-- Top Bar End -->

    <!-- Nav Bar Start -->
    <div class="nav-bar p-0">
        <div class="container-fluid">
            <nav class="navbar navbar-expand-lg bg-dark navbar-dark">
                <a href="#" class="navbar-brand">MENU</a>
                <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse" v-if="'{{ !request()->is('history/*') }}'">
                    <div class="navbar-nav mr-auto">
                        <a href="#" v-on:click.prevent='goto("homes")' :class="class_menu == 'homes' ? 'nav-item nav-link active' : 'nav-item nav-link'">Home</a>
                        <a href="#" v-on:click.prevent='goto("services")' :class="class_menu == 'services' ? 'nav-item nav-link active' : 'nav-item nav-link'">Servis</a>
                        <a href="#" v-on:click.prevent='goto("works")' :class="class_menu == 'works' ? 'nav-item nav-link active' : 'nav-item nav-link'">Pekerjaan</a>
                        <a href="#" v-on:click.prevent='goto("about_us")' :class="class_menu == 'about_us' ? 'nav-item nav-link active' : 'nav-item nav-link'">Tentang Kami</a>
                        {{-- <a href="{{ url('profile') }}" class="nav-item nav-link {{ request()->is('profile') ? 'active' : '' }}">Tentang Kami</a> --}}
                    </div>
                    <div class="navbar-nav ml-auto">
                    	@auth
                    	<div class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Hallo .. ! {{ auth()->user()->name }}</a>
                            <div class="dropdown-menu" style="width: 100%;">
                                <form method="post" action="{{ url('logout') }}">
                                @csrf
                                <button class="dropdown-item" style="cursor: pointer;">Logout</button>
                                </form>
                        		<a href="{{ url('history/all') }}" class="dropdown-item">History</a>
                            </div>
                        </div>
                        @endauth

                        @guest
                        <a class="btn-navbar nav-item nav-link mr-2" href="#" data-target='#loginModal' data-toggle="modal">Login</a>
                        <a class="btn-navbar nav-item nav-link" href="#" data-target='#signModal' data-toggle="modal">Daftar</a>
                        @endguest
                    </div>
                </div>

                <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse" v-else>
                    <div class="navbar-nav mr-auto">
                        <a href="{{ url('/') }}" :class="class_menu == 'homes' ? 'nav-item nav-link active' : 'nav-item nav-link'">Home</a>
                    </div>
                    <div class="navbar-nav ml-auto">
                        @auth
                        <div class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Hallo .. ! {{ auth()->user()->name }}</a>
                            <div class="dropdown-menu" style="width: 100%;">
                                <form method="post" action="{{ url('logout') }}">
                                    @csrf
                                <button class="dropdown-item" style="cursor: pointer;">Logout</button>
                                </form>
                                @if(auth()->user()->role == 4)
                                <a href="{{ url('history/all') }}" class="dropdown-item">History</a>
                                @endif
                            </div>
                        </div>
                        @endauth

                        @guest
                        <a class="btn-navbar nav-item nav-link mr-2" href="#" data-target='#loginModal' data-toggle="modal">Login</a>
                        <a class="btn-navbar nav-item nav-link" href="#" data-target='#signModal' data-toggle="modal">Daftar</a>
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
            signup: '{{ count($errors->all()) }}',
            class_menu : '{{ request()->is('history/*') }}' ? '' : 'homes',
		},
		created: function(){
			this.getData();
            if(this.signup != 0){
                this.$nextTick(()=>{
                    $('#signModal').modal('show');
                });
            }
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
            goto : function(data){
                if (data == 'homes') {
                    this.class_menu = data;
                    console.log(this.class_menu);
                    $('html, body').animate({
                        scrollTop: 0
                    }, 2000, 'easeInOutExpo');
                }else if (data == 'works') {
                    this.class_menu = data;
                    console.log(this.class_menu);
                    $('html, body').animate({
                        scrollTop: $("#works").offset().top
                    }, 2000);
                }else if (data == 'services') {
                    this.class_menu = data;
                    console.log(this.class_menu);
                    $('html, body').animate({
                        scrollTop: $("#services").offset().top
                    }, 2000);
                }else if (data == 'about_us') {
                    this.class_menu = data;
                    console.log(this.class_menu);
                    $('html, body').animate({
                        scrollTop: $("#about_us").offset().top
                    }, 2000);
                }
            },
			signup: function(){
				this.$nextTick(() => {
					$('#signModal').modal('show');
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