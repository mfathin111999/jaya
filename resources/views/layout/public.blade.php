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

        <!-- Template Stylesheet -->
        <link href="css/style.css" rel="stylesheet">
		<style>
			@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap');
			.swal2-popup {
				font-size: 0.8rem !important;
			}

			.font-12{
				font-size: 12px !important;
			}

			.dropdown-item:hover{
				background-color: #030f27;
				color: white;
			}

			.btn-theme{
				display: inline-block;
				font-weight: 400;
				color: #212529;
				text-align: center;
				vertical-align: middle;
				cursor: pointer;
				-webkit-user-select: none;
				-moz-user-select: none;
				-ms-user-select: none;
				user-select: none;
				background-color: transparent;
				border: 1px solid transparent;
				padding: .375rem .75rem;
				font-size: 1rem;
				line-height: 1.5;
				border-radius: .25rem;
				transition: color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;
			}

			.daterangepicker{
				position: absolute !important;
				padding: 0px;
			}
			.btn-navbar{
				background: transparent;
			}

			.select2-container--default .select2-selection--multiple:before {
			    content: ' ';
			    display: block;
			    position: absolute;
			    border-color: #888 transparent transparent transparent;
			    border-style: solid;
			    border-width: 5px 4px 0 4px;
				height: calc(2.25rem + 2px);
			    right: 6px;
			    margin-left: -4px;
			    margin-top: -2px;top: 50%;
			    width: 0;cursor: pointer
			}

			.select2-container--open .select2-selection--multiple:before {
			    content: ' ';
			    display: block;
			    position: absolute;
			    border-color: transparent transparent #888 transparent;
			    border-width: 0 4px 5px 4px;
				height: calc(2.25rem + 2px);
			    right: 6px;
			    margin-left: -4px;
			    margin-top: -2px;top: 50%;
			    width: 0;cursor: pointer
			}

			[v-cloak] {
				display: none;
			}

			.loader {
			  	border: 16px solid #f3f3f3; /* Light grey */
			  	border-top: 16px solid #fdbe33; /* Blue */
			  	border-radius: 50%;
			  	width: 120px;
			  	height: 120px;
			  	animation: spin 1s linear infinite;
			}

			@keyframes spin {
			  	0% { transform: rotate(0deg); }
			  	100% { transform: rotate(360deg); }
			}

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