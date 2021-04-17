<header id="header-app" v-cloak>

	<div class="modal fade" id="loginModal" role="dialog">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <img class="modal-title" src="{{ asset('img/logo.png') }}" style="max-width: 50px;">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <form id="login-form" v-on:submit.prevent="onSubmitLogin()">
	        <div class="modal-body pl-4 pr-4">
	          <div class="form-group">
	            <label for="emailLogin">Email address</label>
	            <input type="email" class="form-control" id="emailLogin" name="email" placeholder="Enter email" required="" autocomplete="false">
	          </div>
	          <div class="form-group">
	            <label for="passwordLogin">Password</label>
	            <input type="password" class="form-control" id="passwordLogin" name="password" placeholder="Password" required="" autocomplete="false">
	          </div>
	          <div class="form-group form-check">
	            <input type="checkbox" class="form-check-input" id="exampleCheck1">
	            <label class="form-check-label" for="exampleCheck1">Ingat saya !</label>
	          </div>
	          <button type="submit" class="btn btn-info btn btn-block text-center">Login</button>
	        </div>
	        <div class="modal-footer" style="justify-content: center;">
	          <p class="m-0">Belum punya akun ?</p>
	          <a class="text-info" data-dismiss="modal" id="trigSign">Daftar</a>
	        </div>
	      </form>
	    </div>
	  </div>
	</div>

	<div class="modal fade" id="signUp" role="dialog">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <img class="modal-title" src="{{ asset('img/logo.png') }}" style="max-width: 50px;">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <form id="registration" method="POST" action="{{ url('register') }}">
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
	          <p class="m-0">Sudah punya akun ?</p>
	          <a class="text-info" data-dismiss="modal">Login</a>
	        </div>
	      </form>
	    </div>
	  </div>
	</div>

	<nav class="navbar navbar-expand-lg navbar-light bg-light shadow">
		<a class="navbar-brand" href="#">
			<img src="img/logo.png" style="max-width: 30px;">
		</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>

		<div class="collapse navbar-collapse" id="navbarSupportedContent">
			<ul class="navbar-nav mr-auto">
				<li class="nav-item active ml-4">
					<a class="nav-link" href="#">Home</a>
				</li>
				<li class="nav-item dropdown ml-4">
					<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						Service
					</a>
					<div class="dropdown-menu" aria-labelledby="navbarDropdown" style="font-size: 12px;">
						<a class="dropdown-item" href="#" v-for='(service, index) in data'>@{{ service.name }}</a>
						<div class="dropdown-divider"></div>
						<a class="dropdown-item" href="#">Petunjuk Reservasi</a>
					</div>
				</li>
				<!-- <li class="nav-item ml-4">
					<a class="nav-link" href="#">Reservasi Survey</a>
				</li>
				<li class="nav-item ml-4">
					<a class="nav-link" href="#">Konsultasi</a>
				</li> -->
				@if(session('role') == 4)
				<li class="nav-item ml-4">
					<a class="nav-link" href="#">History</a>
				</li>
				@endif
			</ul>
			<ul class="navbar-nav">
				@auth
				<li class="nav-item ml-4">
					<a class="nav-link" href="#">Hallo, {{ auth()->user()->name }} !</a>
				</li>
				<li class="nav-item ml-4">
					<a class="nav-link" type="submit" @click='logout' href="#">Logout</a>
				</li>
				@endauth
				@guest
				<li class="nav-item ml-4">
					<a class="nav-link" data-toggle="modal" data-target="#loginModal" href="#">Login</a>
				</li>
				<li class="nav-item ml-4">
					<a class="nav-link" data-toggle="modal" data-target="#signUp" href="#">Daftar</a>
				</li>
				@endguest
			</ul>
		</div>
	</nav>
</header>

@section('header-js')
<script type="text/javascript">
	var header = new Vue({
		el: '#header-app', 
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
			}
		}
	})

	$('#trigSign').click(function(){
		$('#signUp').modal('toggle')
		$('#signUp').modal('show');
	});

	$('#trigLog').click(function(){
		$('#loginModal').modal('toggle');
		$('#loginModal').modal('show');
	});

</script>
@endsection