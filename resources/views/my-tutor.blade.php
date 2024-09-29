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
                <h2>My Tutor</h2>
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
                    ?>
                    <div class="col-lg-4 col-md-4">
                        <!--<a href="#" data-toggle="modal" data-target="#StudentDetailModal">-->
                        <div class="count-box tutor-img">
                            <img src="{{ (isset($request)) ? ((empty($request->image)) ? asset('public/assets/img/avatar.png') : asset($request->image) ) : asset('public/assets/img/avatar.png') }}" class="rounded shadow-sm">
                            <div>
                                <h4 class="text-secondary">{{ $string  }}</h4>
                                <?php
                                $myString = $request->sname;
                                $subject = str_replace(",", " | ", $myString);
                                ?>
                                <li class="d-inline text-secondary font-weight-light">{{ $subject }}</li><br>
                                <li class="d-inline text-secondary font-weight-light">{{ $request->mobile_no }}</li><br>
                                <li class="d-inline text-secondary font-weight-light">{{ $request->location }}</li><br>
                                @if($request->status == 'Pending')
                                <a class="btn btn-outline-success mt-2 opacity-75" data-id="{{ $request->id }}" data-tutor="{{ $request->tutor_email }}" onclick="send_fees(this)">Pay Fees</a>
                                @else
                                <li class="d-inline text-secondary font-weight-light text-success">{{ $request->status }}</li>
                                @endif
                            </div>

                        </div>
                        <?php
                        $amount = $request->fees;
                        $arr = explode(',', $amount);
                        $stripe = new \Stripe\StripeClient($stripe_client_key);
                        $customer = $stripe->customers->create();
// creating setup intent
                        $payment_intent = $stripe->paymentIntents->create([
                            'payment_method_types' => ['card'],
                            // convert double to integer for stripe payment intent, multiply by 100 is required for stripe
                            'amount' => array_sum($arr),
                            'currency' => 'usd',
                        ]);
                        ?>
                        <!--</a>-->
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
        <div class="modal fade" id="paymenttypeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content p-5 top-50 shadow rounded-modal border-0">
                    <div class="">
                        <button type="button" class="close mb-4" data-dismiss="modal" aria-label="Close" onclick="close_model()">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <input type="hidden" id="stripe-public-key" value="{{ $stripe_public_key }}" />
                        <input type="hidden" id="stripe-payment-intent" value="<?php echo $payment_intent->client_secret; ?>" />

                        <!-- credit card UI will be rendered here -->
                        <div id="stripe-card-element" style="margin-top: 20px; margin-bottom: 20px;"></div>

                        <button type="button" class="btn btn-primary" onclick="payViaStripe();">Pay via stripe</button>
                        <p id="card-error" class="text-danger text-center mt-2" role="alert"></p>

                        <!-- billing details is required for some countries -->
                        <input type="hidden" id="user-email" value="{{ session()->get('web_username') }}" />
                        <input type="hidden" id="tutor-email" value="" />
                        <input type="hidden" id="user-name" value="{{ $customer->id }}" />
                        <input type="hidden" id="user-mobile-number" value="" />
                    </div>
                </div>
            </div>
        </div>

        <!-- student detail modal -->
        <div class="modal fade" id="StudentDetailModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content top-50 shadow border-0">
                    <div class="modal-header top-border border-bottom-0">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="close_model();">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body mb-5">
                        <div class="d-flex align-items-center tutor-img" id="get_tutor_data">

                        </div>
                    </div>
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
    <script src="{{ asset('public/assets/vendor/jquery/jquery.min.js') }}"></script>

    <script type="text/javascript">
                            $('#StudentDetailModal').on('shown.bs.modal', function () {
                                $('#StudentDetailModal').trigger('focus')
                            })
    </script>
    <script>
        $(window).on('load', function () {
            $('.loader').fadeOut();
        });
        function send_fees(val) {
            var tutor = $(val).attr("data-tutor");
            document.getElementById('tutor-email').value = tutor;
            $('#paymenttypeModal').modal('show');
        }
    </script>
    <!-- Bootstrap core JavaScript -->
    <script src="https://js.stripe.com/v3/"></script>
    <script>
        $.ajaxSetup({

            headers: {

                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

            }

        })
        // global variables
        var stripe = null;
        var cardElement = null;

        const stripePublicKey = document.getElementById("stripe-public-key").value;

        // initialize stripe when page loads
        window.addEventListener("load", function () {
            stripe = Stripe(stripePublicKey);
            var elements = stripe.elements();
            const style = {
                base: {
                    fontWeight: 400,
                    fontFamily: 'futurabold',
                    fontSize: '16px',
                    lineHeight: '1.4',
                    display: 'flex',
                    color: '#555',
                    backgroundColor: '#fff',
                    '::placeholder': {
                        color: '#888',
                        fontFamily: 'futurabold',
                    },
                },
                invalid: {
                    fontFamily: 'Arial, sans-serif',
                    color: "#fa755a",
                    iconColor: "#fa755a"
                }
            };
            cardElement = elements.create('card', {style});
            cardElement.mount('#stripe-card-element');
        });
        function payViaStripe() {
            // get stripe payment intent
            const stripePaymentIntent = document.getElementById("stripe-payment-intent").value;

            // execute the payment
            stripe
                    .confirmCardPayment(stripePaymentIntent, {
                        payment_method: {
                            card: cardElement,
                            billing_details: {
                                "email": document.getElementById("user-email").value,
                                "name": document.getElementById("user-name").value,
                                "phone": document.getElementById("user-mobile-number").value
                            },
                        },
                    })
                    .then(function (result) {
                        console.log(result);
                        // Handle result.error or result.paymentIntent
                        if (result.error) {
                            console.log(result.error);
                            document.getElementById("card-error").innerHTML = result.error.message;
                        } else {
                            console.log("The card has been verified successfully...", result.paymentIntent.id);
                            document.getElementById("card-error").innerHTML = "";
                            alert("Your Payment is Succeeded..!!");
                            $('#paymenttypeModal').modal('hide');

                            var student_email = '<?= session()->get('web_username') ?>';
                            var tutor_email = document.getElementById("tutor-email").value;
//                            alert(tutor_email);
                            var dataString = 'transaction_id=' + result.paymentIntent.id + '&student_email=' + student_email + '&tutor_email=' + tutor_email;
                            $.ajax({
                                url: "<?php echo URL('send_payment_data') ?>",
                                type: "post",
                                data: dataString,
                                cache: false,
                                success: function (data) {
//                                    alert(data);
                                    location.reload();
                                    document.getElementById('get_tutor_data').innerHTML = data;
                                }
                            });

//                                confirmPayment(result.paymentIntent.id);
                        }
                    });
        }

//            function confirmPayment(paymentId) {
//                var ajax = new XMLHttpRequest();
//                ajax.open("POST", "<?php echo URL('stripe') ?>", true);
//
//                ajax.onreadystatechange = function () {
//                    if (this.readyState == 4) {
//                        if (this.status == 200) {
//                            var response = JSON.parse(this.responseText);
//                            console.log(response);
//                        }
//
//                        if (this.status == 500) {
//                            console.log(this.responseText);
//                        }
//                    }
//                };
//
//                var formData = new FormData();
//                formData.append("payment_id", paymentId);
//                ajax.send(formData);
//            }
        function close_model() {
            $("#paymenttypeModal").modal("hide");
        }
    </script>

</body>

</html>
