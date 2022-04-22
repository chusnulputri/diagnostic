<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Career - Bubur Onic </title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="manifest" href="site.webmanifest">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/logo/res-logo.png') }}">

    <!-- CSS here -->
    <link rel="stylesheet" href="{{asset('assets-career/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets-career/css/owl.carousel.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets-career/css/flaticon.css')}}">
    <link rel="stylesheet" href="{{asset('assets-career/css/price_rangs.css')}}">
    <link rel="stylesheet" href="{{asset('assets-career/css/slicknav.css')}}">
    <link rel="stylesheet" href="{{asset('assets-career/css/animate.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets-career/css/magnific-popup.css')}}">
    <link rel="stylesheet" href="{{asset('assets-career/css/fontawesome-all.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets-career/css/themify-icons.css')}}">
    <link rel="stylesheet" href="{{asset('assets-career/css/slick.css')}}">
    <link rel="stylesheet" href="{{asset('assets-career/css/nice-select.css')}}">
    <link rel="stylesheet" href="{{asset('assets-career/css/style.css')}}">

    <style>
        [class^="flaticon-"]:before,
        [class*=" flaticon-"]:before,
        [class^="flaticon-"]:after,
        [class*=" flaticon-"]:after {
            margin-left: 0 !important;
        }

        .loader-custom {
            border: 10px solid #f3f3f3;
            border-radius: 50%;
            border-top: 10px solid #25980b;
            width: 90px;
            height: 90px;
            -webkit-animation: spin 2s linear infinite;
            /* Safari */
            animation: spin 2s linear infinite;
        }

        /* Safari */
        @-webkit-keyframes spin {
            0% {
                -webkit-transform: rotate(0deg);
            }

            100% {
                -webkit-transform: rotate(360deg);
            }
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

    </style>
    @yield('extra_styles_career')
</head>

<body>
    <!-- Preloader Start -->
    <div id="preloader-active">
        <div class="preloader d-flex align-items-center justify-content-center">
            <div class="preloader-inner position-relative">
                <div class="preloader-circle"></div>
                <div class="preloader-img pere-text">
                    <img src="{{ asset('assets/logo/res-logo.png') }}" alt="">
                </div>
            </div>
        </div>
    </div>
    <!-- Preloader Start -->
    <header>
        <!-- Header Start -->
        <div class="header-area header-transparrent">
            <div class="headder-top header-sticky">
                <div class="container">
                    <div class="d-flex justify-content-between align-items-center" style="padding:15px 0;">
                        <!-- Logo -->
                        <div class="logo">
                            <a href="{{route('recruitment.index')}}"><img src="{{ asset('assets/logo/res-logo.png') }}"
                                    width="80px" alt=""></a>
                        </div>

                        <!-- Header-btn -->
                        <div class="header-btn f-right">
                            <a href="javascript:void(0)" data-toggle="modal" data-target="#modal-redirec-exam" class="btn head-btn1">Ujian</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Header End -->
    </header>
    <main>
        @yield('main-career')
    </main>
    <footer>
        <!-- footer-bottom area -->
        <div class="footer-bottom-area footer-bg">
            <div class="container">
                <div class="footer-border">
                    <div class="row d-flex justify-content-between align-items-center">
                        <div class="col-xl-10 col-lg-10 ">
                            <div class="footer-copy-right">
                                <p>
                                    <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                                    Copyright &copy;<script>
                                        document.write(new Date().getFullYear());

                                    </script> Bubur Onic | PT. Rofindiya Ekamulia Sukses
                                    <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                                </p>
                            </div>
                        </div>
                        <!-- <div class="col-xl-2 col-lg-2">
                            <div class="footer-social f-right">
                                <a href="#"><i class="fab fa-facebook-f"></i></a>
                                <a href="#"><i class="fab fa-twitter"></i></a>
                                <a href="#"><i class="fas fa-globe"></i></a>
                                <a href="#"><i class="fab fa-behance"></i></a>
                            </div>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>
        <!-- Footer End-->
    </footer>
    <div class="modal fade" id="modal-redirec-exam" style="z-index:9999999;" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Masukkan kode test yang telah terkirim ke email anda</label>
                        <input type="text" class="form-control" id="test_code_value">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" onClick="redirectExam()" class="btn btn-primary w-100 btn-sm">Selanjutnya</button>
                </div>
            </div>
        </div>
    </div>

    <!-- JS here -->
    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.14/dist/vue.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.21.1/axios.min.js"
        integrity="sha512-bZS47S7sPOxkjU/4Bt0zrhEtWx0y0CRkhEp8IckzK+ltifIIE9EMIMTuT/mEzoIMewUINruDBIR/jJnbguonqQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"
        integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- All JS Custom Plugins Link Here here -->
    <script src="{{asset('assets-career/js/vendor/modernizr-3.5.0.min.js')}}"></script>
    <!-- Jquery, Popper, Bootstrap -->
    <script src="{{asset('assets-career/js/vendor/jquery-1.12.4.min.js')}}"></script>
    <script src="{{asset('assets-career/js/popper.min.js')}}"></script>
    <script src="{{asset('assets-career/js/bootstrap.min.js')}}"></script>
    <!-- Jquery Mobile Menu -->
    <script src="{{asset('assets-career/js/jquery.slicknav.min.js')}}"></script>

    <!-- Jquery Slick , Owl-Carousel Plugins -->
    <script src="{{asset('assets-career/js/owl.carousel.min.js')}}"></script>
    <script src="{{asset('assets-career/js/slick.min.js')}}"></script>
    <script src="{{asset('assets-career/js/price_rangs.js')}}"></script>

    <!-- One Page, Animated-HeadLin -->
    <script src="{{asset('assets-career/js/wow.min.js')}}"></script>
    <script src="{{asset('assets-career/js/animated.headline.js')}}"></script>
    <script src="{{asset('assets-career/js/jquery.magnific-popup.js')}}"></script>

    <!-- Scrollup, nice-select, sticky -->
    <script src="{{asset('assets-career/js/jquery.scrollUp.min.js')}}"></script>
    <script src="{{asset('assets-career/js/jquery.nice-select.min.js')}}"></script>
    <script src="{{asset('assets-career/js/jquery.sticky.js')}}"></script>

    <!-- contact js -->
    <script src="{{asset('assets-career/js/contact.js')}}"></script>
    <script src="{{asset('assets-career/js/jquery.form.js')}}"></script>
    <script src="{{asset('assets-career/js/jquery.validate.min.js')}}"></script>
    <script src="{{asset('assets-career/js/mail-script.js')}}"></script>
    <script src="{{asset('assets-career/js/jquery.ajaxchimp.min.js')}}"></script>

    <!-- Jquery Plugins, main Jquery -->
    <script src="{{asset('assets-career/js/plugins.js')}}"></script>
    <script src="{{asset('assets-career/js/main.js')}}"></script>
    <script>
        function redirectExam(){
            window.location.href= "{{url('recruitment/exam')}}?test_code=" + $('#test_code_value').val();
        }
        function humanizeDate(e, format = 'DD/MM/YYYY') {
            const formatOfDate = moment(e, ['YYYY-MM-DD', 'DD/MM/YYYY']).creationData().format;

            if (formatOfDate) {
                const data = moment(e, formatOfDate);

                if (data.isValid())
                    return data.format(format)
            }

            return 'Unknown Format/Date';
        }

    </script>
    @yield('extra_scripts_career')
</body>

</html>
