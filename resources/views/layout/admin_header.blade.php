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
			<ul class="navbar-nav">
				@auth
				<li class="nav-item ml-4" style="font-size: 14px;">
					<div class="btn-group">
					  <a class="dropdown-toggle font-weight-bold text-white" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="cursor: pointer;">
					    Hallo, {{ auth()->user()->name }} .. !
					  </a>
					  <div class="dropdown-menu dropdown-menu-right">
					    <button class="dropdown-item" type="button" @click="logout()" style="font-size: 12px;">Logout</button>
					  </div>
					</div>
				</li>
				@endguest
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