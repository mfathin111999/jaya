<!DOCTYPE html>
<html lang="id">
	<head>
		<meta charset="utf-8">
	    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no">
		<title>Home Service</title>
		<link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.min.css') }}">
		<link rel="stylesheet" type="text/css" href="{{ asset('css/daterangepicker.css') }}">
		<link rel="stylesheet" type="text/css" href="{{ asset('css/font-awesome.min.css') }}">
		<link rel="stylesheet" type="text/css" href="{{ asset('css/custom.css') }}">
		<link rel="stylesheet" type="text/css" href="{{ asset('css/sweetalert2.min.css') }}">
		<link rel="stylesheet" type="text/css" href="{{ asset('css/select2.min.css') }}">
		<link rel="stylesheet" type="text/css" href="{{ asset('css/owl.carousel.min.css') }}">
		<link rel="stylesheet" type="text/css" href="{{ asset('css/owl.theme.default.min.css') }}">
		<link rel="stylesheet" type="text/css" href="{{ asset('css/jquery-ui.min.css') }}">
		<link rel="stylesheet" type="text/css" href="{{ asset('css/styles.css') }}">

		<style>
			@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap');
			.swal2-popup {
				font-size: 0.8rem !important;
			}

			.font-12{
				font-size: 12px !important;
			}

			.font-14{
				font-size: 14px !important;
			}
		</style>
		@yield('header-css')
		@yield('sec-css')
		@yield('footer-css')
	</head>
	<body style="font-family: 'Poppins', sans-serif; font-size: 12px; overflow-x: hidden;">

		@yield('content')

		<script type="text/javascript" src="{{ asset('js/jquery-3.5.1.min.js') }}"></script>
		<script type="text/javascript" src="{{ asset('js/jquery-ui.min.js') }}"></script>
		<script type="text/javascript" src="{{ asset('js/axios.min.js') }}"></script>
		<script type="text/javascript" src="{{ asset('js/bootstrap.min.js') }}"></script>
		<script type="text/javascript" src="{{ asset('js/moment.min.js') }}"></script>
		<script type="text/javascript" src="{{ asset('js/vue.min.js') }}"></script>
		<script type="text/javascript" src="{{ asset('js/daterangepicker.js') }}"></script>
		<script type="text/javascript" src="{{ asset('js/sweetalert2.min.js') }}"></script>
		<script type="text/javascript" src="{{ asset('js/select2.min.js') }}"></script>
		<script type="text/javascript" src="{{ asset('js/owl.carousel.min.js') }}"></script>
		<script type="text/javascript" src="{{ asset('js/custom.js') }}"></script>
		
		@yield('header-js')
		@yield('sec-js')
		@yield('footer-js')
	</body>
</html>