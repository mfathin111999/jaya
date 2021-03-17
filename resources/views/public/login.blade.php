@extends('layout.app')

@section('content')
	@include('layout.header')
		<section class="mt-5 mb-5">
			<div class="row">
				<div class="col-4 mx-auto">
					<div class="card">
						<form method="POST" action="{{ url('api/login') }}">
							<div class="card-header text-center">
								<img src="{{ asset('img/logo.png') }}" style="max-width: 50px;">
							</div>
							<div class="card-body p-4">
								  <div class="form-group">
								    <label for="exampleInputEmail1">Email address</label>
								    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email" required="">
								    <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
								  </div>
								  <div class="form-group">
								    <label for="exampleInputPassword1">Password</label>
								    <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" required="">
								  </div>
								  <div class="form-group form-check">
								    <input type="checkbox" class="form-check-input" id="exampleCheck1">
								    <label class="form-check-label" for="exampleCheck1">Ingat saya !</label>
								  </div>
							</div>
							<div class="card-footer text-right">
								<div class="row">
									<div class="col-6 text-left">
								    	<a href="#">Daftar</a>										
									</div>
									<div class="col-6 text-right">
										<button type="submit" class="btn btn-primary">Submit</button>								
									</div>
								</div>
							</div>
						</form>
					</div>		
				</div>
			</div>
		</section>
@endsection