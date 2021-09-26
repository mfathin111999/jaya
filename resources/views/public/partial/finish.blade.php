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
			background-color: #fdbe33; 
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
			</div>
			<div class="card-body text-center" style="line-height: 1.5rem;">
				<label class="h5 font-weight-bold">Pembayaran Telah Berhasil !</label>
				<label class="mt-3 font-12 d-block">
					Silahkan login untuk melihat progress dan detail reservasi anda. <br> Terima Kasih telah memilih <strong>Servisrumah.com</strong> sebagai partner.
				</label>		
				<a href="{{ url('/') }}" class="btn-back px-3 py-1 font-12 text-light font-weight-bold mt-2">Halaman Utama</a>
			</div>
			</div>
	</div>
@endsection