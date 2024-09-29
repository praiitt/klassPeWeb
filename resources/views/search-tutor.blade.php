<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Tutor Finder</title>

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

        <link href="{{ asset('public/swiper/swiper.min.css') }}" rel="stylesheet">

        <!-- Template Main CSS File -->
        <link href="{{ asset('public/assets/css/style.css') }}" rel="stylesheet">
        <meta name="csrf-token" content="{{ csrf_token() }}" />

    </head>

    <body class="bg-blue">
        <div class="loader"></div>
        <!-- ======= Header ======= -->
        <header id="header" class="header fixed-top container-fluid text-white mt-3">
            <div class="d-flex align-items-center justify-content-between container">
                <a href="{{ url('/') }}"><span class="menu" onclick=""><i class="bi bi-chevron-left h1 text-white"></i></span></a>
                <h2>Find Tutor</h2>
                <a class="nav-link" href="{{ url('Notification') }}"><i class="bi bi-bell-fill text-white h2"></i></a>
            </div>
        </header><!-- End Header -->

        <section> </section>

        <main class="mt-5 bg-white top-rounded">
            <section class="mb-n5">
                <div class="container">
                    <div class="sb-example-3">
                        <div class="search__container">
                            <input class="search__input textField-bg border-0" type="text" placeholder="Search" id="search_tutor" onkeyup="search_tutor()">
                        </div>
                    </div>
                </div>
            </section>

            <!-- ======= list Section ======= -->
            <section id="counts" class="counts">
                <div class="container">
                    <div class="row gy-4" id="tutor_serch_value">
                        @if(count($getdata) == 0)
                        <div class="col-auto col-centered mr-4">
                            <center>
                                <img src="{{ asset('public/assets/img/no-data.png') }}" class="rounded shadow-sm">
                            </center>
                        </div>
                        @else
                        @foreach($getdata as $tutor)
                        <div class="col-lg-4 col-md-6">
                            <a href="{{ url('Tutor_details/'.$tutor->id) }}">
                                <div class="count-box tutor-img">
                                    <img src="{{ (isset($tutor)) ? ((empty($tutor->image)) ? asset('public/assets/img/avatar.png') : asset($tutor->image)) : asset('public/assets/img/avatar.png') }}" class="rounded shadow-sm">
                                    <div>
                                        <h4 class="text-secondary">{{ $tutor->username }}</h4>
                                        @php
                                        $myString = $tutor->sname;
                                        $subject = str_replace(",", "|", $myString);
                                        @endphp
                                        <li class="d-inline text-secondary font-weight-light"><?php echo $subject ?></li>
                                    </div>
                                    <i class="bi bi-chevron-right h2 text-blue"></i>
                                </div>
                            </a>
                        </div>
                        @endforeach
                        @endif
                    </div>
                </div>
            </section><!-- End Counts Section -->
        </main>
        <!-- ======= Footer ======= -->
        @include('footer')
        <!-- End Footer -->
        <script src="{{ asset('public/swiper/swiper.min.js') }}"></script>
        <!-- Template Main JS File -->
        <script src="{{ asset('public/assets/js/main.js') }}"></script>

        <!-- Bootstrap core JavaScript -->
        <script src="{{ asset('public/assets/js/jquery.min.js') }}"></script>
        <!-- Vendor JS Files -->
        <script src="{{ asset('public/assets/vendor/bootstrap/js/bootstrap.bundle.js') }}"></script>
        <script>
                                $(window).on('load', function () {
                                    $('.loader').fadeOut();
                                });
        </script>
        <script>
            $.ajaxSetup({

                headers: {

                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

                }

            })
            function search_tutor() {
                var value = document.getElementById('search_tutor').value;
                var dataString = 'username=' + value;
                $.ajax({
                    url: "<?php echo URL('s_tutor') ?>",
                    type: "post",
                    data: dataString,
                    cache: false,
                    success: function (data) {
//                                            alert(data);
                        $('#tutor_serch_value').html(data);
                    }
                });
            }
        </script>
    </body>

</html>
