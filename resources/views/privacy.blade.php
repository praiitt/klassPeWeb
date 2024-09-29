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
        <header id="header" class="header fixed-top container-fluid text-white mt-3">
            <div class="d-flex align-items-center justify-content-between container">
                <a href="{{ url('/') }}"><span class="menu" onclick=""><i class="bi bi-chevron-left h1 text-white"></i></span></a>
                <h2>Privacy Policy</h2>
                <a class="nav-link" href=""></a>
            </div>
        </header><!-- End Header -->

        <section> </section>



        <!-- ======= list Section ======= -->
        <section id="counts" class="counts bg-white top-rounded">
            <div class="container">
                <div class="bg-white shadow p-5 rounded">
                    <center><img src="{{ asset('public/assets/img/about.png') }}" class="mb-5"></center>
                    <p class="text-secondary">
                        {{ strip_tags($getdata->privacy_policy) }}
                    </p>
                </div>
            </div>
        </section>


    </main>
    <!-- ======= Footer ======= -->
    @include('footer')
    <!-- End Footer -->


    <<script src="{{ asset('public/assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('public/swiper/swiper.min.js') }}"></script>
    <!-- Template Main JS File -->
    <script src="{{ asset('public/assets/js/main.js') }}"></script>


    <!-- Bootstrap core JavaScript -->
    <script src="assets/vendor/jquery/jquery.min.js"></script>
    <script src="{{ asset('public/assets/vendor/bootstrap/js/bootstrap.bundle.js') }}"></script>
    <script>
$(window).on('load', function () {
    $('.loader').fadeOut();
});
    </script>
</body>

</html>
