@extends('layout.public')

@section('content')
	@include('layout.header')
		<section class="mt-5 mb-5" id="login-section" v-cloak>
			<div class="row">
				<div class="col-4 mx-auto">
					<div class="card shadow">
						<form v-on:submit.prevent='onSubmitLogin' id="login-forms">
							<div class="card-header text-center">
								<img src="{{ asset('img/logo.png') }}" style="max-width: 50px;">
							</div>
							<div class="card-body p-4">
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
							<div class="card-footer font-12 d-flex align-items-center" style="height: 50px;">
								<p class="m-0">Belum punya akun ? &nbsp</p>
                        		<button type="button" class="text-info p-0 m-0" data-dismiss="modal" style="background:none; border:none; cursor: pointer;" @click='signup'>Daftar</button>
							</div>
						</form>
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
		        	// console.log(response.data);
		        	this.setSession();

		        }.bind(this))
		        .catch(function (response) {
					//handle error
                    Swal.fire('Opss', 'Kombinasi Email dan Password Salah !', 'warning');
					// Swal.fire('Opss', response.response.data.message, 'warning');
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
	                    window.location = "{{ url()->previous() }}";
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
					$('#signModal').modal('show');
				});
			},
		}
	})

</script>
@endsection