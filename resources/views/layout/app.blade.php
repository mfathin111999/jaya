<!DOCTYPE html>
<html lang="id">
	<head>
		<meta charset="utf-8">
	    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<title>Home Service</title>
		<link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.min.css') }}">
		<link rel="stylesheet" type="text/css" href="{{ asset('css/daterangepicker.css') }}">
		<link rel="stylesheet" type="text/css" href="{{ asset('css/font-awesome.min.css') }}">
		<link rel="stylesheet" type="text/css" href="{{ asset('css/custom.css') }}">
		<link rel="stylesheet" type="text/css" href="{{ asset('css/sweetalert2.min.css') }}">
		<link rel="stylesheet" type="text/css" href="{{ asset('css/select2.min.css') }}">
		<link rel="stylesheet" type="text/css" href="{{ asset('css/owl.carousel.min.css') }}">
		<link rel="stylesheet" type="text/css" href="{{ asset('css/owl.theme.default.min.css') }}">
		<link rel="stylesheet" type="text/css" href="{{ asset('css/styles.css') }}">

		<style>
			@import url('https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,400;0,500;0,800;1,400;1,500;1,800&display=swap');
		</style>

		@yield('sec-css')
	</head>
	<body style="font-family: 'Montserrat', sans-serif; font-size: 14px; overflow-x: hidden;">
		@include('public.partial.login')
		@include('public.partial.registration')

		@yield('content')

		<script type="text/javascript" src="{{ asset('js/jquery-3.5.1.min.js') }}"></script>
		<script type="text/javascript" src="{{ asset('js/axios.min.js') }}"></script>
		<script type="text/javascript" src="{{ asset('js/bootstrap.min.js') }}"></script>
		<script type="text/javascript" src="{{ asset('js/moment.min.js') }}"></script>
		<script type="text/javascript" src="{{ asset('js/vue.min.js') }}"></script>
		<script type="text/javascript" src="{{ asset('js/daterangepicker.js') }}"></script>
		<script type="text/javascript" src="{{ asset('js/sweetalert2.min.js') }}"></script>
		<script type="text/javascript" src="{{ asset('js/select2.min.js') }}"></script>
		<script type="text/javascript" src="{{ asset('js/owl.carousel.min.js') }}"></script>
		<script type="text/javascript" src="{{ asset('js/custom.js') }}"></script>
		<script type="text/javascript">
			$('#trigSign').click(function(){
				$('#signUp').modal('toggle')
				$('#signUp').modal('show');
			});

			$('#trigLog').click(function(){
				$('#loginModal').modal('toggle');
				$('#loginModal').modal('show');
			});
		</script>
		@yield('sec-js')
	</body>
</html>