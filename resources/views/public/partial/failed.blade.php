@extends('layout.public')

@section('sec-css')
	<style type="text/css">
		.btn-back{
			border-radius: 20px; 
			background-color: #fdbe33; 
			position: relative; 
			display: inline-block; 
		}
		.btn-back:hover{
			color: #ffffff;
		}
		.card{
			border-radius: 1rem;
		}
		.card-header{
			border-radius: calc(1rem - 1px) calc(1rem - 1px) 0px 0px !important;
			background-color: #030f27; 
			border: none;
		}
		.d-center{
			position: absolute;
			transform: translate(-50%, 50%); 
			left: 50%; 
			top: 50%; 
			min-width: 300px;
		}

		.d-bord{
			border: none; 
			box-shadow: 0px 0px 5px -1px #000000;
		}
	</style>

@endsection

@section('content')
	<div class="mx-auto my-auto d-center">
		<div class="card d-bord">
			<div class="card-header text-center text-light">
				<i class="fa fa-check-circle" style="font-size: 50px;"></i> 
				{{-- <span class="h5 font-weight-bold m-0">Penawaran disetujui !</span> --}}
			</div>
			<div class="card-body text-center" style="line-height: 1.5rem;">
				<label class="h5 font-weight-bold">Maaf Pembayaran anda gagal dilakukan</label>
				<label class="mt-3 font-12 d-block">
					Silahkan coba kembali pembayaran setelah beberapa saat.
				</label>		
				<a href="{{ url('/') }}" class="btn-back px-3 py-1 font-12 text-light font-weight-bold mt-2">Halaman Utama</a>
			</div>
		</div>
	</div>
@endsection