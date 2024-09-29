<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta content="width=device-width, initial-scale=1.0" name="viewport">

        <title>Tutor Finder</title>
        <meta content="" name="description">

        <meta content="" name="keywords">
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <!-- Favicons -->
        <link href="{{ asset('public/assets/img/favicon.png') }}" rel="icon">
        <link href="{{ asset('public/assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

        <!-- Google Fonts -->
        <link href="{{ asset('public/assets/css/font.css') }}" rel="stylesheet">

        <!-- Vendor CSS Files -->
        <link href="{{ asset('public/assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
        <link href="{{ asset('public/assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
        <link href="{{ asset('public/assets/vendor/aos/aos.css') }}" rel="stylesheet">
        <link href="{{ asset('public/assets/vendor/remixicon/remixicon.css') }}" rel="stylesheet">
        <link href="{{ asset('public/assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">
        <link href="{{ asset('public/assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">



        <!-- Template Main CSS File -->
        <link href="{{ asset('public/assets/css/style.css') }}" rel="stylesheet">
        <meta name="csrf-token" content="{{ csrf_token() }}" />
    </head>

    <body>
        <div class="loader"></div>

        @include('sidebar')
        <header id="header" class="header fixed-top container-fluid">
            <div class="d-flex align-items-center justify-content-between">

                <a href="{{ url('/') }}" class="logo d-flex align-items-center container-xl">
                    <img src="{{ asset('public/assets/img/logo.png') }}">
                    <span>Tutor Finder</span>
                </a>
                <nav id="navbar" class="navbar mr-5">
                    <ul class="pr-5">
                        <li class="profile_photo">
                            <a class="nav-link mb-2" data-toggle="modal" data-target="#profileModal" data-whatever="">
                                <img src="{{ asset('public/assets/img/avatar.png') }}" id="profileImages" height="100px" width="100px" class="shadow bg-white rounded-circle">
                            </a>
                        </li>

                    </ul>
                    <i class="mobile-nav-toggle"></i>
                </nav>
            </div>
        </header>
        <!-- ======= Hero Section ======= -->
        <section id="hero" class="hero d-flex align-items-center">

            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-6 d-flex flex-column">
                        <form method="post" action="{{ URL('change_forgot_pass')}}">
                            <input name="_token" type="hidden" value="{{ csrf_token() }}"/>
                            <center>
                                <h1>Change Password</h1>
                                <div class="form-group input-group w-75 mt-5">
                                    <input type="hidden" name="token" value="{{ $token }}">
                                    <input type="password" class="form-control textField-bg border-0 p-2 mb-2 zIndex-1" id="password" placeholder="Password" name="password" value="" onblur="check_pass(this.value)" required="">
                                </div>

                                <div class="form-group input-group w-75 mt-3">
                                    <input type="text" class="form-control textField-bg border-0 p-2 mb-5 zIndex-1" id="con_password" placeholder="Confirm Password"  required="">
                                </div>
                                <p id = 'compare' class=""></p>
                            </center>
                            <center>
                                <button type="submit" class="orange-btn w-75" id="registers">Change</button>
                            </center>
                        </form>
                    </div>
                </div>
            </div>

        </section><!-- End Hero -->



        @include('footer')


        <script src="{{ asset('public/assets/js/jquery.min.js') }}"></script>
        <link href="{{ asset('public/assets/css/stackpath.css') }}" rel="stylesheet">
        <script src="{{ asset('public/assets/js/stackpath.js') }}"></script>

        <!-- Vendor JS Files -->
        <script src="{{ asset('public/assets/vendor/bootstrap/js/bootstrap.bundle.js') }}"></script>
        <script src="{{ asset('public/assets/vendor/aos/aos.js') }}"></script>
        <script src="{{ asset('public/assets/vendor/php-email-form/validate.js') }}"></script>
        <!--<script src="{{ asset('public/assets/vendor/swiper/swiper-bundle.min.js') }}"></script>-->
        <script src="{{ asset('public/assets/vendor/glightbox/js/glightbox.min.js') }}"></script>

        <!-- Template Main JS File -->
        <script src="{{ asset('public/assets/js/main.js') }}"></script>
        <script>
function check_pass(val)
{
    if (val.length >= 6) {
        document.getElementById("btn_login").removeAttribute("disabled", "disabled");
        document.getElementById("registers").removeAttribute("disabled", "disabled");
    } else {
        alert("Please Enter 8 Digit Password..!!")
        document.getElementById("btn_login").setAttribute("disabled", "disabled");
        document.getElementById("registers").setAttribute("disabled", "disabled");
    }
}
        </script>
        <script>
            $(window).on('load', function () {
                $('.loader').fadeOut();
            });
        </script>
        <script>
            $(document).ready(function () {
                var oldMatched = 0;
                var bothMatched = 0;
                $('#con_password').on('blur', function () {
                    if ($('#password').val() != $('#con_password').val())
                    {
                        $('#compare').html('Both passwords mismatched!');
                        bothMatched = 0;
                    } else
                    {
                        $('#compare').css('color', 'green');
                        $('#compare').html('Passwords matched');
                        bothMatched = 1;
                    }
                    if ($('#con_password').val() == '')
                    {
                        $('#compare').html('confirm password can not be blank!');
                        bothMatched = 0;
                    }
                });
            });
        </script>

    </body>

</html>