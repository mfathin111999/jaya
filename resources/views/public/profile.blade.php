@extends('layout.public')

@section('content')
	@include('layout.header')

	<div class="page-header">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h2>Tentang</h2>
                </div>
                <div class="col-12">
                    <a href="">Home</a>
                    <a href="">Tentang Kami</a>
                </div>
            </div>
        </div>
    </div>

	<!-- About Start -->
    <div class="about wow fadeInUp" data-wow-delay="0.1s">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-5 col-md-6">
                    <div class="about-img">
                        <img src="img/about.jpg" alt="Image">
                    </div>
                </div>
                <div class="col-lg-7 col-md-6">
                    <div class="section-header text-left">
                        <p>Selamat Datang di Servis Rumah</p>
                        <h2>Dengan Pengalaman Bertahun Tahun</h2>
                    </div>
                    <div class="about-text">
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus nec pretium mi. Curabitur facilisis ornare velit non vulputate. Aliquam metus tortor, auctor id gravida condimentum, viverra quis sem.
                        </p>
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus nec pretium mi. Curabitur facilisis ornare velit non vulputate. Aliquam metus tortor, auctor id gravida condimentum, viverra quis sem. Curabitur non nisl nec nisi scelerisque maximus. Aenean consectetur convallis porttitor. Aliquam interdum at lacus non blandit.
                        </p>
                        <a class="btn" href="">Pelajari lebih lanjut</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- About End -->


    <!-- Fact Start -->
    <div class="fact">
        <div class="container-fluid">
            <div class="row counters">
                <div class="col-md-6 fact-left wow slideInLeft">
                    <div class="row">
                        <div class="col-6">
                            <div class="fact-icon">
                                <i class="flaticon-worker"></i>
                            </div>
                            <div class="fact-text">
                                <h2 data-toggle="counter-up">109</h2>
                                <p>Expert Workers</p>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="fact-icon">
                                <i class="flaticon-building"></i>
                            </div>
                            <div class="fact-text">
                                <h2 data-toggle="counter-up">485</h2>
                                <p>Happy Clients</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 fact-right wow slideInRight">
                    <div class="row">
                        <div class="col-6">
                            <div class="fact-icon">
                                <i class="flaticon-address"></i>
                            </div>
                            <div class="fact-text">
                                <h2 data-toggle="counter-up">789</h2>
                                <p>Completed Projects</p>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="fact-icon">
                                <i class="flaticon-crane"></i>
                            </div>
                            <div class="fact-text">
                                <h2 data-toggle="counter-up">890</h2>
                                <p>Running Projects</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Fact End -->


    <!-- Service Start -->
    <div class="service">
        <div class="container">
            <div class="section-header text-center">
                <p>Servis Kami</p>
                <h3 class="font-weight-bold">Kami Menyediakan Berbagai Macam Servis</h3>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="service-item">
                        <div class="service-img">
                            <img src="img/service-1.jpg" alt="Image">
                            <div class="service-overlay">
                                <p>
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus nec pretium mi. Curabitur facilisis ornare velit non vulputate. Aliquam metus tortor, auctor id gravida condimentum, viverra quis sem.
                                </p>
                            </div>
                        </div>
                        <div class="service-text">
                            <h3>Pembagunan Konstruksi</h3>
                            <a class="btn" href="img/service-1.jpg" data-lightbox="service">+</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.2s">
                    <div class="service-item">
                        <div class="service-img">
                            <img src="img/service-2.jpg" alt="Image">
                            <div class="service-overlay">
                                <p>
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus nec pretium mi. Curabitur facilisis ornare velit non vulputate. Aliquam metus tortor, auctor id gravida condimentum, viverra quis sem.
                                </p>
                            </div>
                        </div>
                        <div class="service-text">
                            <h3>Renovasi Rumah</h3>
                            <a class="btn" href="img/service-2.jpg" data-lightbox="service">+</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="service-item">
                        <div class="service-img">
                            <img src="img/service-3.jpg" alt="Image">
                            <div class="service-overlay">
                                <p>
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus nec pretium mi. Curabitur facilisis ornare velit non vulputate. Aliquam metus tortor, auctor id gravida condimentum, viverra quis sem.
                                </p>
                            </div>
                        </div>
                        <div class="service-text">
                            <h3>Desain Arsitektur</h3>
                            <a class="btn" href="img/service-3.jpg" data-lightbox="service">+</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.4s">
                    <div class="service-item">
                        <div class="service-img">
                            <img src="img/service-4.jpg" alt="Image">
                            <div class="service-overlay">
                                <p>
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus nec pretium mi. Curabitur facilisis ornare velit non vulputate. Aliquam metus tortor, auctor id gravida condimentum, viverra quis sem.
                                </p>
                            </div>
                        </div>
                        <div class="service-text">
                            <h3>Desain Interior</h3>
                            <a class="btn" href="img/service-4.jpg" data-lightbox="service">+</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.5s">
                    <div class="service-item">
                        <div class="service-img">
                            <img src="img/service-5.jpg" alt="Image">
                            <div class="service-overlay">
                                <p>
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus nec pretium mi. Curabitur facilisis ornare velit non vulputate. Aliquam metus tortor, auctor id gravida condimentum, viverra quis sem.
                                </p>
                            </div>
                        </div>
                        <div class="service-text">
                            <h3>Maintenance</h3>
                            <a class="btn" href="img/service-5.jpg" data-lightbox="service">+</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.6s">
                    <div class="service-item">
                        <div class="service-img">
                            <img src="img/service-6.jpg" alt="Image">
                            <div class="service-overlay">
                                <p>
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus nec pretium mi. Curabitur facilisis ornare velit non vulputate. Aliquam metus tortor, auctor id gravida condimentum, viverra quis sem.
                                </p>
                            </div>
                        </div>
                        <div class="service-text">
                            <h3>Pengecatan</h3>
                            <a class="btn" href="img/service-6.jpg" data-lightbox="service">+</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Service End -->

    <!-- Team Start -->
    <div class="team">
        <div class="container">
            <div class="section-header text-center">
                <p>Team Kami</p>
                <h2>Bekerja dengan Kami</h2>
            </div>
            <div class="row">
                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="team-item">
                        <div class="team-img">
                            <img src="img/team-1.jpg" alt="Team Image">
                        </div>
                        <div class="team-text">
                            <h2>H. Jaedi</h2>
                            <p>CEO & Founder</p>
                        </div>
                        <div class="team-social">
                            <a class="social-tw" href=""><i class="fab fa-twitter"></i></a>
                            <a class="social-fb" href=""><i class="fab fa-facebook-f"></i></a>
                            <a class="social-li" href=""><i class="fab fa-linkedin-in"></i></a>
                            <a class="social-in" href=""><i class="fab fa-instagram"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.2s">
                    <div class="team-item">
                        <div class="team-img">
                            <img src="img/team-2.jpg" alt="Team Image">
                        </div>
                        <div class="team-text">
                            <h2>H. Firman</h2>
                            <p>Civil Engineer</p>
                        </div>
                        <div class="team-social">
                            <a class="social-tw" href=""><i class="fab fa-twitter"></i></a>
                            <a class="social-fb" href=""><i class="fab fa-facebook-f"></i></a>
                            <a class="social-li" href=""><i class="fab fa-linkedin-in"></i></a>
                            <a class="social-in" href=""><i class="fab fa-instagram"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="team-item">
                        <div class="team-img">
                            <img src="img/team-3.jpg" alt="Team Image">
                        </div>
                        <div class="team-text">
                            <h2>H. Agus</h2>
                            <p>Interior Designer</p>
                        </div>
                        <div class="team-social">
                            <a class="social-tw" href=""><i class="fab fa-twitter"></i></a>
                            <a class="social-fb" href=""><i class="fab fa-facebook-f"></i></a>
                            <a class="social-li" href=""><i class="fab fa-linkedin-in"></i></a>
                            <a class="social-in" href=""><i class="fab fa-instagram"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.4s">
                    <div class="team-item">
                        <div class="team-img">
                            <img src="img/team-4.jpg" alt="Team Image">
                        </div>
                        <div class="team-text">
                            <h2>H. Sandi</h2>
                            <p>Painter</p>
                        </div>
                        <div class="team-social">
                            <a class="social-tw" href=""><i class="fab fa-twitter"></i></a>
                            <a class="social-fb" href=""><i class="fab fa-facebook-f"></i></a>
                            <a class="social-li" href=""><i class="fab fa-linkedin-in"></i></a>
                            <a class="social-in" href=""><i class="fab fa-instagram"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Team End -->
    

    <!-- FAQs Start -->
    <div class="faqs">
        <div class="container">
            <div class="section-header text-center">
                <p>Pertanyaan Yang Sering Diajukan</p>
                <h2>Hubungi Kami</h2>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div id="accordion-1">
                        <div class="card wow fadeInLeft" data-wow-delay="0.1s">
                            <div class="card-header">
                                <a class="card-link collapsed" data-toggle="collapse" href="#collapseOne">
                                    Lorem ipsum dolor sit amet?
                                </a>
                            </div>
                            <div id="collapseOne" class="collapse" data-parent="#accordion-1">
                                <div class="card-body">
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus nec pretium mi. Curabitur facilisis ornare velit non.
                                </div>
                            </div>
                        </div>
                        <div class="card wow fadeInLeft" data-wow-delay="0.2s">
                            <div class="card-header">
                                <a class="card-link collapsed" data-toggle="collapse" href="#collapseTwo">
                                    Lorem ipsum dolor sit amet?
                                </a>
                            </div>
                            <div id="collapseTwo" class="collapse" data-parent="#accordion-1">
                                <div class="card-body">
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus nec pretium mi. Curabitur facilisis ornare velit non.
                                </div>
                            </div>
                        </div>
                        <div class="card wow fadeInLeft" data-wow-delay="0.3s">
                            <div class="card-header">
                                <a class="card-link collapsed" data-toggle="collapse" href="#collapseThree">
                                    Lorem ipsum dolor sit amet?
                                </a>
                            </div>
                            <div id="collapseThree" class="collapse" data-parent="#accordion-1">
                                <div class="card-body">
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus nec pretium mi. Curabitur facilisis ornare velit non.
                                </div>
                            </div>
                        </div>
                        <div class="card wow fadeInLeft" data-wow-delay="0.4s">
                            <div class="card-header">
                                <a class="card-link collapsed" data-toggle="collapse" href="#collapseFour">
                                    Lorem ipsum dolor sit amet?
                                </a>
                            </div>
                            <div id="collapseFour" class="collapse" data-parent="#accordion-1">
                                <div class="card-body">
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus nec pretium mi. Curabitur facilisis ornare velit non.
                                </div>
                            </div>
                        </div>
                        <div class="card wow fadeInLeft" data-wow-delay="0.5s">
                            <div class="card-header">
                                <a class="card-link collapsed" data-toggle="collapse" href="#collapseFive">
                                    Lorem ipsum dolor sit amet?
                                </a>
                            </div>
                            <div id="collapseFive" class="collapse" data-parent="#accordion-1">
                                <div class="card-body">
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus nec pretium mi. Curabitur facilisis ornare velit non.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div id="accordion-2">
                        <div class="card wow fadeInRight" data-wow-delay="0.1s">
                            <div class="card-header">
                                <a class="card-link collapsed" data-toggle="collapse" href="#collapseSix">
                                    Lorem ipsum dolor sit amet?
                                </a>
                            </div>
                            <div id="collapseSix" class="collapse" data-parent="#accordion-2">
                                <div class="card-body">
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus nec pretium mi. Curabitur facilisis ornare velit non.
                                </div>
                            </div>
                        </div>
                        <div class="card wow fadeInRight" data-wow-delay="0.2s">
                            <div class="card-header">
                                <a class="card-link collapsed" data-toggle="collapse" href="#collapseSeven">
                                    Lorem ipsum dolor sit amet?
                                </a>
                            </div>
                            <div id="collapseSeven" class="collapse" data-parent="#accordion-2">
                                <div class="card-body">
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus nec pretium mi. Curabitur facilisis ornare velit non.
                                </div>
                            </div>
                        </div>
                        <div class="card wow fadeInRight" data-wow-delay="0.3s">
                            <div class="card-header">
                                <a class="card-link collapsed" data-toggle="collapse" href="#collapseEight">
                                    Lorem ipsum dolor sit amet?
                                </a>
                            </div>
                            <div id="collapseEight" class="collapse" data-parent="#accordion-2">
                                <div class="card-body">
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus nec pretium mi. Curabitur facilisis ornare velit non.
                                </div>
                            </div>
                        </div>
                        <div class="card wow fadeInRight" data-wow-delay="0.4s">
                            <div class="card-header">
                                <a class="card-link collapsed" data-toggle="collapse" href="#collapseNine">
                                    Lorem ipsum dolor sit amet?
                                </a>
                            </div>
                            <div id="collapseNine" class="collapse" data-parent="#accordion-2">
                                <div class="card-body">
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus nec pretium mi. Curabitur facilisis ornare velit non.
                                </div>
                            </div>
                        </div>
                        <div class="card wow fadeInRight" data-wow-delay="0.5s">
                            <div class="card-header">
                                <a class="card-link collapsed" data-toggle="collapse" href="#collapseTen">
                                    Lorem ipsum dolor sit amet?
                                </a>
                            </div>
                            <div id="collapseTen" class="collapse" data-parent="#accordion-2">
                                <div class="card-body">
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus nec pretium mi. Curabitur facilisis ornare velit non.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- FAQs End -->
	@include('layout.footer')
@endsection