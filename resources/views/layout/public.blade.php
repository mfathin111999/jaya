<!DOCTYPE html>
<html lang="id">
	<head>
		<meta charset="utf-8">
	    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no">
		<title>Home Service</title>

        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
		<link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.min.css') }}">
		<link rel="stylesheet" type="text/css" href="{{ asset('css/daterangepicker.css') }}">
		<link rel="stylesheet" type="text/css" href="{{ asset('css/custom.css') }}">
		<link rel="stylesheet" type="text/css" href="{{ asset('css/sweetalert2.min.css') }}">
		<link rel="stylesheet" type="text/css" href="{{ asset('css/select2.min.css') }}">
		<link rel="stylesheet" type="text/css" href="{{ asset('css/jquery-ui.min.css') }}">
		<link rel="stylesheet" type="text/css" href="{{ asset('css/styles.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('plugin/flaticon/font/flaticon.css') }}"> 
        <link rel="stylesheet" type="text/css" href="{{ asset('plugin/animate/animate.min.css') }}">
		<link rel="stylesheet" type="text/css" href="{{ asset('css/owl.carousel.min.css') }}">
		<link rel="stylesheet" type="text/css" href="{{ asset('css/owl.theme.default.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('plugin/lightbox/css/lightbox.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('plugin/slick/slick.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('plugin/slick/slick-theme.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}">

		<link rel="icon" href="{{ url('img/logo/favicon.ico') }}">

        <!-- Template Stylesheet -->
        <link href="css/style.css" rel="stylesheet">
		<style>
			

		</style>
		@yield('header-css')
		@yield('sec-css')
		@yield('footer-css')
	</head>
	<body style="overflow-x: hidden;">

		<div class="wrapper">

		@yield('content')

        </div>

		<script type="text/javascript" src="{{ asset('js/jquery-3.5.1.min.js') }}"></script>
		<script type="text/javascript" src="{{ asset('js/jquery-ui.min.js') }}"></script>
		<script type="text/javascript" src="{{ asset('js/axios.min.js') }}"></script>
		<script type="text/javascript" src="{{ asset('js/bootstrap.min.js') }}"></script>
		<script type="text/javascript" src="{{ asset('js/moment.min.js') }}"></script>
		<script type="text/javascript" src="{{ asset('js/vue.min.js') }}"></script>
		<script type="text/javascript" src="{{ asset('js/daterangepicker.js') }}"></script>
		<script type="text/javascript" src="{{ asset('js/sweetalert2.min.js') }}"></script>
		<script type="text/javascript" src="{{ asset('js/select2.min.js') }}"></script>
		<script type="text/javascript" src="{{ asset('js/custom.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('plugin/easing/easing.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('plugin/wow/wow.min.js') }}"></script>
		<script type="text/javascript" src="{{ asset('js/owl.carousel.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('plugin/isotope/isotope.pkgd.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('plugin/lightbox/js/lightbox.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('plugin/waypoints/waypoints.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('plugin/counterup/counterup.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('plugin/slick/slick.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/main.js') }}"></script>

		@yield('header-js')
		@yield('sec-js')
		@yield('footer-js')
	</body>
</html>