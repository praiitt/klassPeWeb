<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>KlassPe</title>

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

    </head>

    <body class="bg-blue">
        <div class="loader"></div>
        <!-- ======= Header ======= -->
        <header id="header" class="header fixed-top container-fluid mt-3 text-white">
            <div class="d-flex align-items-center justify-content-between container">
                <a href="{{ url('/') }}"><span class="menu" onclick=""><i class="bi bi-chevron-left h1 text-white"></i></span></a>
                <h2>Notification</h2>
                <a class="nav-link" href=""></a>
                <!-- <nav id="navbar" class="navbar mr-5">
                  <ul class="pr-5">
                    <li><a class="nav-link" href="notification.html"><i class="bi bi-gear-fill text-white"></i></a></li>
                  </ul>
                </nav> -->
            </div>
        </header><!-- End Header -->

        <section> </section>

        <main class="mt-5 bg-white top-rounded">

            <!-- ======= notification Section ======= -->
            <section id="faq" class="faq">

                <div class="container">

                    <div class="row">
                        @php
                        $count = count($getdata);
                        $rconut = count($request);
                        @endphp

                        @if(session()->get('type') == 'student')
                        @foreach($request as $res)
                        <div class="accordion accordion-flush" id="faqlistr{{ $res->id }}">
                            <div class="accordion-item shadow bg-white border-0 mb-5">
                                <h2 class="accordion-header b-border-sky">
                                    <button class="accordion-button collapsed text-secondary font-weight-regular" type="button" data-bs-toggle="collapse" data-bs-target="#faq-content-r{{ $res->id }}">
                                        Your&nbsp;<b>{{ $res->sname }}</b>&nbsp;Subject Request
                                    </button>
                                </h2>
                                <div id="faq-content-r{{ $res->id }}" class="accordion-collapse collapse" data-bs-parent="#faqlistr{{ $res->id }}">
                                    <div class="accordion-body text-secondary">
                                        Your <b>{{ $res->sname }}</b> Subject's Request Accepted by <b>{{ $res->username }}</b>..!!
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        @endif
                        @if($count == 0 && $rconut == 0)
                        <div class="col-lg-12 col-md-12">
                            <center>
                                <img src="{{ asset('public/assets/img/no-data.png') }}" class="rounded shadow-sm">
                            </center>
                        </div>
                        @else
                        @for($i = 0; $i < $count; $i++)
                        <div class="accordion accordion-flush" id="faqlist{{ $getdata[$i]->id }}">
                            <div class="accordion-item shadow bg-white border-0 mb-5">
                                <h2 class="accordion-header b-border-sky">
                                    <button class="accordion-button collapsed text-secondary font-weight-regular" type="button" data-bs-toggle="collapse" data-bs-target="#faq-content-{{ $getdata[$i]->id }}">
                                        {{ $getdata[$i]->title }}
                                    </button>
                                </h2>
                                <div id="faq-content-{{ $getdata[$i]->id }}" class="accordion-collapse collapse" data-bs-parent="#faqlist{{ $getdata[$i]->id }}">
                                    <div class="accordion-body text-secondary">
                                        {{ $getdata[$i]->message }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endfor
                        @endif

                    </div>

                </div>

            </section><!-- End notification Section -->
        </main>


        <!-- ======= Footer ======= -->
        @include('footer')
        <!-- End Footer -->

        <script src="{{ asset('public/swiper/swiper.min.js') }}"></script>
        <link href="{{ asset('public/assets/css/stackpath.css') }}" rel="stylesheet">
        <script src="{{ asset('public/assets/js/stackpath.js') }}"></script>
        <!-- Bootstrap core JavaScript -->
        <script src="{{ asset('public/assets/js/jquery.min.js') }}"></script>
        <script src="{{ asset('public/assets/vendor/bootstrap/js/bootstrap.bundle.js')}}"></script>

        <!-- Template Main JS File -->
        <script src="{{ asset('public/assets/js/main.js') }}"></script>
        <script>
$(window).on('load', function () {
    $('.loader').fadeOut();
});
        </script>
    </body>

</html>
