@section('header-css')
<style type="text/css">
	@media screen and (max-width: 768px){
		.d-mob {
			display : block;
		}

		.d-desk {
			display : none;
		}
	}

	@media screen and (min-width: 769px){
		.d-mob {
			display : none;
		}

		.d-desk {
			display : block;
		}
	}

	.ploton {
		line-height: 1.5rem;
	}
</style>
@endsection

<section id="header-admin">
	<nav class="navbar navbar-expand-lg fixed-top navbar-light bg-info shadow">
		<a class="navbar-brand" href="#">
			<img src="{{ asset('img/logo.png') }}" style="max-width: 85px;">
		</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>

		<div class="collapse navbar-collapse" id="navbarSupportedContent">
			<ul class="navbar-nav mr-auto">
			</ul>
			<ul class="navbar-nav d-desk">
				@auth
				<li class="nav-item ml-4 d-flex align-items-center" style="font-size: 14px;">
					<div class="btn-group">
					  <a class="dropdown-toggle font-weight-bold text-white" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="cursor: pointer;">
					  	<i class="fa fa-user"></i>
					    Hallo, {{ auth()->user()->name }} .. !
					  </a>
					  <div class="dropdown-menu dropdown-menu-right">
					    <button class="dropdown-item" type="button" @click="logout()" style="font-size: 12px;">Logout</button>
					  </div>
					</div>
				</li>
				@endauth
			</ul>
			<ul class="navbar-nav d-mob" style="border-top: 1px #FFFFFF solid; margin-top : 0.5rem; ">
				@auth
				<li class="nav-item">
			        <a class="nav-link ploton active text-white" href="{{ route('dashboard') }}">
			          	<i class="fa fa-home pr-2"></i>
			          	Dashboard <span class="sr-only"></span>
			        </a>
		      	</li>
		      	<li class="nav-item">
		        	<a class="nav-link ploton text-white" href="{{ route('calendar') }}">
		          		<i class="fa fa-calendar pr-2"></i>
		          		Kalender
		        	</a>
		      	</li>
		      	<li class="nav-item">
		        	@if(auth()->user()->role == 5)
		        	<a class="nav-link ploton text-white" href="{{ route('engagement_vendor') }}">
		        	@else
		        	<a class="nav-link ploton text-white" href="{{ route('engagement') }}">
		        	@endif
		          		<i class="fa fa-calendar pr-2"></i>
		          		Reservasi
		        	</a>
		      	</li>
		      	@if(auth()->user()->role == 5)
		      	<li class="nav-item">
		        	<a class="nav-link ploton text-white" href="{{ route('vendor.debt.card') }}">
		          		<i class="fa fa-calendar pr-2"></i>
		          		Kartu Piutang
		        	</a>
		      	</li>
		      	<li class="nav-item">
		        	<a class="nav-link ploton text-white" href="{{ route('vendor.payment.card') }}">
		          		<i class="fa fa-calendar pr-2"></i>
		          		Pembayaran
		        	</a>
		      	</li>
		      	@endif
		      	@if(auth()->user()->role == 1)
		      	<li class="nav-item">
		        	<a class="nav-link ploton text-white" href="{{ route('vendor') }}">
		          		<i class="fa fa-tasks pr-2"></i>
		          		Partner Bisnis
		        	</a>
		      	</li>
		      	<li class="nav-item">
		        	<a class="nav-link ploton text-white" href="{{ route('supervisor.debt.card.vendor') }}">
		          		<i class="fa fa-area-chart pr-2"></i>
		          		Kartu Hutang
		        	</a>
		      	</li>
		      	<li class="nav-item">
		        	<a class="nav-link ploton text-white" href="{{ route('supervisor.debt.card.user') }}">
		          		<i class="fa fa-area-chart pr-2"></i>
		          		Kartu Piutang
		        	</a>
		      	</li>
		       	<li class="nav-item">
		        	<a class="nav-link ploton text-white" href="{{ route('supervisor.payment.vendor') }}">
		          		<i class="fa fa-area-chart pr-2"></i>
		          		Pembayaran Vendor
		        	</a>
		      	</li>
		      	<li class="nav-item">
		        	<a class="nav-link ploton text-white" href="{{ route('supervisor.payment.user') }}">
		          		<i class="fa fa-area-chart pr-2"></i>
		          		Pembayaran Customer
		        	</a>
		      	</li>
		      	<li class="nav-item">
		        	<a class="nav-link ploton text-white" href="{{ route('adminservice') }}">
		          		<i class="fa fa-tags pr-2"></i>
		          		Service
		        	</a>
		      	</li>
		      	<li class="nav-item">
		        	<a class="nav-link ploton text-white" href="{{ route('resource') }}">
		          		<i class="fa fa-tags pr-2"></i>
		          		Resource
		        	</a>
		      	</li>
		      	<li class="nav-item">
		        	<a class="nav-link ploton text-white" href="{{ route('setting_account') }}">
		          		<i class="fa fa-tags pr-2"></i>
		          		PENGATURAN AKUN
		        	</a>
		      	</li>
		      	<li class="nav-item">
		        	<a class="nav-link ploton text-white" href="{{ route('setting_user') }}">
		          		<i class="fa fa-tags pr-2"></i>
		          		PENGELOLAAN USER
		        	</a>
		      	</li>
		      	@endif
		      	<li class="nav-item">
			        <a class="nav-link ploton active text-white" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="cursor: pointer;">
			          	<i class="fa fa-home pr-2"></i>
			          Hallo, {{ auth()->user()->name }} .. ! <span class="sr-only"></span>
			        </a>
			        <div class="dropdown-menu dropdown-menu-right">
					    <button class="dropdown-item" type="button" @click="logout()" style="font-size: 12px;">Logout</button>
					</div>
		      	</li>
				@endauth
			</ul>
		</div>
	</nav>
</section>

@section('header-js')
<script type="text/javascript">
	var header = new Vue({
		el: '#header-admin', 
		data: {

		},
		mounted: function(){
			this.check();
		},
		methods: {
			check:function(){
				if ('{{session("id")}}' == null) {
					window.location = "{{ route('home') }}"
				}
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
		}
	})

</script>
@endsection