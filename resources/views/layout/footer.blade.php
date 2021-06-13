<div class="footer wow fadeIn" data-wow-delay="0.3s">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-lg-3">
                <div class="footer-contact">
                    <h2>Kantor</h2>
                    <p><i class="fa fa-map-marker-alt"></i>123 Street, Jakarta, Indonesia</p>
                    <p><i class="fa fa-phone-alt"></i>+62 8810 2355 4758</p>
                    <p><i class="fa fa-envelope"></i>nru@servisrumah.com</p>
                    <div class="footer-social">
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-youtube"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="footer-link">
                    <h2>Servis Kami</h2>
                    <a style="cursor:pointer;" onclick="scroled('services')">Desain Interior</a>
                    <a style="cursor:pointer;" onclick="scroled('services')">Umum dan Supplier</a>
                    <a style="cursor:pointer;" onclick="scroled('services')">Mekanikal Elektrikal & Refrigerasi serta Teknologi Pendingin</a>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="footer-link">
                    <h2>Menu</h2>
                    <a style="cursor:pointer;" onclick="scroled('about_us')">Tentang Kami</a>
                    <a style="cursor:pointer;" onclick="scroled('works')">Pekerjaan Kami</a>
                    <a style="cursor:pointer;" onclick="scroled('team')">Team Kami</a>
                    <a style="cursor:pointer;" onclick="scroled('services')">Servis</a>
                    {{-- <a href="">Testimoni</a> --}}
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="newsletter">
                    <h2>Berlangganan</h2>
                    <p>
                        Dapatkan informasi dan penawaran kami secara berkala
                    </p>
                    <div class="form">
                        <input class="form-control" placeholder="Masukan Email">
                        <button class="btn">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container footer-menu">
        <div class="f-menu">
            <a href="#">Syarat dan Ketentuan</a>
            <a href="#">Privacy policy</a>
            <a href="#">Bantuan</a>
        </div>
    </div>
    <div class="container copyright">
        <div class="row">
            <div class="col-md-6">
                <p>&copy; <a href="#">Servis Rumah</a>, All Right Reserved.</p>
            </div>
            <div class="col-md-6">
                <p>Designed By <a href="https://htmlcodex.com">HTML Codex</a></p>
            </div>
        </div>
    </div>
</div>

@section('footer-js')
    <script type="text/javascript">
        function scroled(data){
            if (data == 'services') {
                $('html, body').animate({
                    scrollTop: $("#services").offset().top
                }, 2000);
            }else if(data == 'team'){
                $('html, body').animate({
                    scrollTop: $(".team").offset().top
                }, 2000);
            }else if(data == 'about_us'){
                $('html, body').animate({
                    scrollTop: $("#about_us").offset().top
                }, 2000);
            }else if(data == 'works'){
                $('html, body').animate({
                    scrollTop: $("#works").offset().top
                }, 2000);
            }
        }
    </script>
@endsection