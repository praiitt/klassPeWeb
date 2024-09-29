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
        <meta name="csrf-token" content="{{ csrf_token() }}" />

    </head>

    <body class="bg-blue">
        <div class="loader"></div>
        <!-- ======= Header ======= -->
        <header id="header" class="header fixed-top container-fluid text-white mt-3">
            <div class="d-flex align-items-center justify-content-between container">
                <a href="{{ url('/') }}"><span class="menu" onclick=""><i class="bi bi-chevron-left h1 text-white"></i></span></a>
                <h2>My Student</h2>
                <a class="nav-link" href="{{ url('Notification') }}"><i class="bi bi-bell-fill text-white h2"></i></a>
            </div>
        </header><!-- End Header -->

        <section> </section>



        <!-- ======= list Section ======= -->
        <section id="counts" class="counts bg-white top-rounded">
            <div class="container">
                <div class="row gy-4">
                    @if(count($getdata) >= 1)
                    @foreach($getdata as $request)
                    <?php
                    $string = (strlen($request->username) > 13) ? substr($request->username, 0, 10) . '...' : $request->username;
//                    print_r($request);
                    ?>

                    <div class="col-lg-4 col-md-4">
                        <a href="#" data-email="{{ $request->student_email }}" data-mobile="{{ $request->mobile_no }}" data-subject="{{ $request->sname }}" data-standard="{{ $request->standard }}" data-tuition-type="{{ $request->tuition_type }}"  data-status="{{ $request->status }}" data-location="{{ $request->location }}" data-m_hours="{{ $request->m_hours }}" data-a_hours="{{ $request->a_hours }}" data-amount="{{ $request->amount }}" data-transaction_id="{{ $request->transaction_id }}" data-datetime="{{ $request->datetime }}" onclick="get_student_details(this)">
                            <div class="count-box tutor-img">
                                <img src="{{ (isset($request)) ? ((empty($request->image)) ? asset('public/assets/img/avatar.png') : asset($request->image) ) : asset('public/assets/img/avatar.png') }}" class="rounded shadow-sm">
                                <div>
                                    <h4 class="text-secondary">{{ $string  }}</h4>
                                    <?php
                                    $myString = $request->sname;
                                    $subject = str_replace(",", " | ", $myString);
                                    ?>
                                    <li class="d-inline text-secondary font-weight-light">{{ $subject }}</li><br>
                                    <li class="d-inline text-secondary font-weight-light">Std. {{ $request->standard }}</li><br>
                                    <!-- <li class="d-inline text-secondary font-weight-light">{{ $request->mobile_no }}</li><br>
                                    <li class="d-inline text-secondary font-weight-light">{{ $request->location }}</li> -->
                                    <li class="d-inline"><p class="text-lighter">Fees <span class="text-success">{{ $request->status }}</span></p></li>
                                    <!-- <li class="d-inline"><p class="text-lighter">Fees <span class="text-danger">Pending</span></p></li> -->
                                </div>
                            </div>
                        </a>
                    </div>
                    @endforeach
                    @else
                    <div class="col-lg-12 col-md-12">
                        <!--<a href="#" data-toggle="modal" data-target="#StudentDetailModal">-->
                        <center>
                            <img src="{{ asset('public/assets/img/no-data.png') }}" class="rounded shadow-sm">
                        </center>
                        <!--</a>-->
                    </div>
                    @endif
                </div>
            </div>
        </section><!-- End Counts Section -->


        <!-- student detail modal -->
        <div class="modal fade" id="StudentDetailModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content top-20 shadow border-0">
                    <div class="modal-header border-bottom-0">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="close_model();">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <center>
                        <div class="modal-body mb-1">
                            <div class="tutor-img" id="get_tutor_data">
                                <img src="{{ (isset($request)) ? ((empty($request->image)) ? asset('public/assets/img/avatar.png') : asset($request->image) ) : asset('public/assets/img/avatar.png') }}" class="rounded">
                            </div>
                            <h5 class="text-secondary text-center" id="email"></h5>
                            <input type="hidden" name="email" id="s_email">
                            <h6 class="text-secondary text-center" id="mobile"></h6>
                            <div class="student-detail text-left">
                                <p class="font-weight-light mb-1" >Subjects</p>
                                <h5 id="subject"></h5>
                                <hr/>

                                <p class="font-weight-light mb-1">Standard</p>
                                <h5 id="standard"></h5>
                                <hr/>

                                <p class="font-weight-light mb-1">Tution Type</p>
                                <h5 id="tuition"></h5>
                                <hr/>

                                <p class="font-weight-light mb-1">Selected Hours</p>
                                <h5 id="hours"></h5>
                                <hr/>

                                <p class="font-weight-light mb-1">Fees Payment Status</p>
                                <h5 class="text-success" id="status">Recieved</h5>

                                <!-- if pending uncomment this -->
                                <div class="d-flex" id="pending_btn">
                                    <h5 class="text-danger p-2" id="p_status">Pending</h5>
                                    <button type="button" class="blue-btn w-50 p-2 ml-auto" onclick="payment_request()">Send Request</button>
                                </div> 
                                <hr/>
                                <div id="paid_details">
                                    <p class="font-weight-light mb-1">Payment Details</p>
                                    <h6 class="text-secondary">Payment Amount: <span class="text-dark" id="p_amount"></span></h6>
                                    <h6 class="text-secondary">Payment Date: <span class="text-dark" id="p_date"></span></h6>
                                    <h6 class="text-secondary">Payment Method: <span class="text-dark">Stripe</span></h6>
                                    <h6 class="text-secondary">Transaction ID: <span class="text-dark" id="p_transaction"></span></h6>
                                    <hr/>
                                </div>
                                <p class="font-weight-light mb-1">Address</p>
                                <h5 id="location"></h5>

                            </div>
                        </div>
                    </center>
                </div>
            </div>
        </div>


    </main>
    <!-- ======= Footer ======= -->
    <footer id="footer" class="footer">
        <div class="container">
            <div class="copyright">
                &copy; Copyright <strong><span>LPK Technosoft</span></strong>. All Rights Reserved
            </div>
            <div class="credits">
                Designed & Developed by <a href="https://lpktechnosoft.com/">LPK Technosoft</a>
            </div>
        </div>
    </footer>
    <!-- End Footer -->
    <script src="{{ asset('public/swiper/swiper.min.js') }}"></script>

    <script src="{{ asset('public/assets/js/jquery.min.js') }}"></script>
<!-- <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a> -->
    <link href="{{ asset('public/assets/css/stackpath.css') }}" rel="stylesheet">
    <script src="{{ asset('public/assets/js/stackpath.js') }}"></script>

    <!-- Vendor JS Files -->
    <script src="{{ asset('public/assets/vendor/bootstrap/js/bootstrap.bundle.js') }}"></script>
    <!-- Template Main JS File -->
    <script src="{{ asset('public/assets/js/main.js') }}"></script>
    <script type="text/javascript">
                                        $('#StudentDetailModal').on('shown.bs.modal', function () {
                                            $('#StudentDetailModal').trigger('focus')
                                        })
    </script>
    <script>
        $(window).on('load', function () {
            $('.loader').fadeOut();
        });
        function get_student_details(val) {
            var student = $(val).attr("data-email");
            var mobile = $(val).attr("data-mobile");
            var subject = $(val).attr("data-subject");
            var standard = $(val).attr("data-standard");
            var tuition = $(val).attr("data-tuition-type");
            var status = $(val).attr("data-status");
            var location = $(val).attr("data-location");
            var m_hours = $(val).attr("data-m_hours");
            var a_hours = $(val).attr("data-a_hours");
            var amount = $(val).attr("data-amount");
            var datetime = $(val).attr("data-datetime");
            var transaction_id = $(val).attr("data-transaction_id");
            if (tuition == '1') {
                var type = 'Online';
            }
            if (tuition == '2') {
                var type = 'Offline';
            }
            if (tuition == '3') {
                var type = 'Online, Offline';
            }

            if (status == 'Pending') {
                $("#pending_btn").addClass("d-flex");
                document.getElementById('status').style.display = 'none';
                document.getElementById('paid_details').style.display = 'none';
                document.getElementById('p_status').innerHTML = status;
            }
            if (status == 'Paid') {
                $("#pending_btn").removeClass("d-flex");
                document.getElementById('pending_btn').style.display = 'none';
                document.getElementById('status').style.display = 'block';
                document.getElementById('paid_details').style.display = 'block';
                document.getElementById('status').innerHTML = status;
            }
            document.getElementById('email').innerHTML = student;
            document.getElementById('s_email').value = student;
            document.getElementById('mobile').innerHTML = "+" + mobile;
            document.getElementById('subject').innerHTML = subject;
            document.getElementById('standard').innerHTML = standard;
            document.getElementById('tuition').innerHTML = type;
            document.getElementById('status').innerHTML = status;
            document.getElementById('location').innerHTML = location;
            document.getElementById('hours').innerHTML = m_hours + a_hours;
            document.getElementById('p_amount').innerHTML = amount;
            document.getElementById('p_date').innerHTML = datetime;
            document.getElementById('p_transaction').innerHTML = transaction_id;
            $('#StudentDetailModal').modal('show');
        }

    </script>
    <!-- Bootstrap core JavaScript -->
    <script src="{{ asset('public/assets/vendor/jquery/jquery.min.js') }}"></script>
    <script>
        $.ajaxSetup({

            headers: {

                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

            }

        })
        function close_model() {
            $("#StudentDetailModal").modal("hide");
        }
        function payment_request() {
            var email = document.getElementById("s_email").value;
            var dataString = 'email=' + email;
            $.ajax({
                url: "<?php echo URL('send_payment_request') ?>",
                type: "get",
                data: dataString,
                cache: false,
                success: function (data) {
                    alert(data);
                    location.reload();
                }
            });
        }

    </script>
</body>

</html>
