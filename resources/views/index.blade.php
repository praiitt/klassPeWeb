<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta content="width=device-width, initial-scale=1.0" name="viewport">

        <title>KlassPe</title>
        <meta content="" name="description">

        <meta content="" name="keywords">
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <!-- Favicons -->
        <link href="{{ asset('assets/img/favicon.png') }}" rel="icon">
        <link href="{{ asset('assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

        <!-- Google Fonts -->
        <link href="{{ asset('assets/css/font.css') }}" rel="stylesheet">

        <!-- Vendor CSS Files -->
        <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/vendor/aos/aos.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/vendor/remixicon/remixicon.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
        <link href="{{ asset('public/swiper/swiper.min.css') }}" rel="stylesheet">


        <!-- Template Main CSS File -->
        <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">

    </head>

    <body>

        <div class="loader"></div>
        @include('sidebar')
        <header id="header" class="header fixed-top container-fluid">
            <div class="d-flex align-items-center justify-content-between">
                <span class="menu" id="opennav" onclick="openNav()">
                    <img src="" class="menu-scroll" width="50px" height="auto" /></span>

                <a href="{{ url('/') }}" class="logo d-flex align-items-center container-xl">
                    <img src="" class="img-scroll">
                    <span>KlassPe</span>
                </a>
                <nav id="navbar" class="navbar mr-5">
                    <ul class="pr-5">
                        @if(session()->get('web_username'))
                        <li class="profile_photo">
                            @if(session()->get('type') == 'student')
                            <a class="nav-link mb-2" data-toggle="modal" data-target="#profileModal" data-whatever="">
                                <img src="{{ (isset($side)) ? ((empty($side->image)) ? asset('public/assets/img/avatar.png') : asset($side->image) ) : asset('public/assets/img/avatar.png') }}" id="profileImages" height="100px" width="100px" class="shadow bg-white rounded-circle">
                            </a>
                            @endif
                            @if(session()->get('type') == 'tutor')
                            <?php
                            print_r($getdata);
                            ?>
                            <a href="{{ url('Tutor_profile') }}">
                                <img src="{{ (isset($side)) ? ((empty($side->image)) ? asset('public/assets/img/avatar.png') : asset($side->image) ) : asset('public/assets/img/avatar.png') }}" id="profileImages" height="100px" width="100px" class="shadow bg-white rounded-circle">
                            </a>
                            @endif
                            <!--<p class="">{{ session()->get('web_username') }}</p>-->
                        </li>
                        @else
                        <li><a class="nav-link" data-toggle="modal" data-target="#loginModal" data-whatever="">Login</a></li>
                        <li><a class="nav-link" data-toggle="modal" data-target="#signUpModal" data-whatever="">Register</a></li>
                        @endif
                    </ul>
                    <i class="mobile-nav-toggle"></i>
                </nav>
            </div>
        </header>
        <!-- ======= Hero Section ======= -->
        <section id="hero" class="hero d-flex align-items-center">

            <div class="container">
                <div class="row">
                    <div class="col-lg-6 d-flex flex-column justify-content-center">
                        @if(session()->get('type') == 'student')
                        <h1>Find Home Tutor </h1>
                        <h2>Get best tutor list & their details on single tap!</h2>
                        <div>
                            <div class="text-lg-start">
                                @if(session()->get('web_username') == '')
                                <a href=""  data-toggle="modal" data-target="#loginModal" data-whatever="" class="btn-get-started scrollto d-inline-flex align-items-center justify-content-center align-self-center">
                                    <span>Start Find</span>
                                    <i class="bi bi-arrow-right"></i>
                                </a>
                                @else
                                <a href="{{ url('Find_tutor') }}"  class="btn-get-started scrollto d-inline-flex align-items-center justify-content-center align-self-center">
                                    <span>Start Find</span>
                                    <i class="bi bi-arrow-right"></i>
                                </a>
                                @endif

                            </div>
                        </div>
                        @endif
                        @if(session()->get('type') == 'tutor')
                        <h1>Every student deserves best education.</h1>
                        <h2>Let’s teach them, Start a teaching career, Become an Online Tutor !</h2>
                        <div>
                            <div class="text-lg-start">
                                @if(session()->get('web_username') == '')
                                <a href=""  data-toggle="modal" data-target="#loginModal" data-whatever="" class="btn-get-started scrollto d-inline-flex align-items-center justify-content-center align-self-center">
                                    <span>Start Find</span>
                                    <i class="bi bi-arrow-right"></i>
                                </a>
                                @else

                                @endif

                            </div>
                        </div>
                        @endif
                        @if(session()->get('type') == '')
                        <h1>Find Home Tutor </h1>
                        <h2>A platform for Students to find and connect home tutors nearby!</h2>
                        <div>
                            <div class="text-lg-start">
                                @if(session()->get('web_username') == '')
                                <a href=""  data-toggle="modal" data-target="#loginModal" data-whatever="" class="btn-get-started scrollto d-inline-flex align-items-center justify-content-center align-self-center">
                                    <span>Start Find</span>
                                    <i class="bi bi-arrow-right"></i>
                                </a>
                                @else
                                <a href="{{ url('Find_tutor') }}"  class="btn-get-started scrollto d-inline-flex align-items-center justify-content-center align-self-center">
                                    <span>Start Find</span>
                                    <i class="bi bi-arrow-right"></i>
                                </a>
                                @endif

                            </div>
                        </div>
                        @endif
                    </div>
                    <div class="col-lg-6 hero-img">
                        <img src="{{ asset('public/assets/img/hero-img.png') }}" class="img-fluid" alt="">
                    </div>
                </div>
            </div>

        </section><!-- End Hero -->

        <!-- Login Modal -->
        <div class="modal fade" id="loginModal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog mt-5" role="document">
                <div class="modal-content bg-blue rounded-modal shadow p-3">
                    <center>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h3 class="text-white mb-5 mt-3" id="exampleModalLabel">Login as</h3>
                    </center>
                    <div class="bg-white top-rounded pt-4">
                        <center>
                            <label class="switch">
                                <input type="checkbox" id="type">
                                <span class="slider round"></span>
                                <span class="absolute-no">Tutor</span>
                            </label>
                        </center>
                        <div class="modal-body">
                            <form id="login_form">
                                <center>
                                    <div class="form-group input-group w-75">
                                        <input type="text" class="form-control textField-bg border-0 p-3 mb-2 zIndex-1" id="email" placeholder="Email" required="">
                                    </div>
                                    <div class="form-group input-group w-75 z-Index-2">
                                        <input type="password" class="form-control textField-bg border-0 p-3 mb-4 zIndex-1" id="password" placeholder="Password" required="" value="" onblur="check_pass(this.value);">
                                    </div>
                                </center>
                                <p class="w-85 text-right mt-n3 mb-4"><a class="text-red" id="forgot" data-toggle="modal" data-target="#forgotModal" data-whatever="">Forgot Password?</a></p>

                                <center>
                                    <button type="button" id="btn_login" class="blue-btn w-75" onclick="Login()">Login</button>

                                    <p class="text-center text-secondary mt-3">OR</p>
                                    <button type="button" onclick="login_with_google();" class="social-login rounded-circle shadow mr-4 google-icon"><i class="bi bi-google"></i></button>
                                    <button type="button" onclick="login_with_facebook();" class="social-login rounded-circle shadow fb-icon"><i class="bi bi-facebook"></i></button> </center>
                            </form>
                            <div id="loading" style="display: none; text-align: center; z-index: 1060;"><h5>Loading..</h5></div>

                        </div>

                        <div class="modal-footer border-0 d-block">
                            <center><p class="text-center text-secondary mt-3">Don't have an account? <a href="" data-dismiss="modal" class="text-red" data-toggle="modal" data-target="#signUpModal" data-whatever="">Register Here</a> </p></center>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- SignUp Modal -->
        <div class="modal fade mt-5" id="signUpModal"  role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog mt-5" role="document">
                <div class="modal-content bg-blue rounded-modal shadow p-3" style="margin-top: 4rem;">
                    <center>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h3 class="text-white mb-5 mt-3" id="exampleModalLabel">Register as</h3>
                    </center>
                    <div class="bg-white top-rounded pt-4">
                        <center>
                            <label class="switch">
                                <input type="checkbox" id="types" >
                                <span class="slider round"></span>
                                <span class="absolute-no">Tutor</span>
                            </label>
                        </center>
                        <div class="modal-body bg-white top-rounded mt-3">
                            <form class="mt-3" id="register_form"><center>
                                    <div class="form-group input-group w-75">
                                        <input type="text" class="form-control textField-bg border-0 p-3 mb-2 zIndex-1" id="username" value="" placeholder="Username" required="">
                                    </div>

                                    <div class="form-group input-group w-75">
                                        <input type="text" class="form-control textField-bg border-0 p-3 mb-2 zIndex-1" id="r_email" placeholder="Email" onblur="check_email();" required="">
                                    </div>
                                    <p id="email_message" class="text-danger"></p>

                                    <div class="form-group input-group w-75">
                                        <input type="password" class="form-control textField-bg border-0 p-2 mb-2 zIndex-1" id="r_password" placeholder="Password" required="" value="" onblur="check_pass(this.value)">
                                    </div>

                                    <div class="form-group input-group w-75">
                                        <input type="text" class="form-control textField-bg border-0 p-2 mb-5 zIndex-1" id="con_password" placeholder="Confirm Password" required="">
                                    </div>
                                    <p id = 'compare' class=""></p>
                                </center>
                                <center><button type="button" class="orange-btn w-75" id="registers" onclick="register();">Register</button>
                            </form>
                        </div>
                    </div>
                    <div class="modal-footer bg-white border-0 mt-n4 d-block">
                        <p class="text-center text-secondary mt-3 animated wow fadeInUp delay-0-6s">Already have an account? <a href="" data-dismiss="modal" class="text-red" data-toggle="modal" data-target="#loginModal" data-whatever="">Login</a> </p>
                    </div>
                </div>
            </div>
        </div>

        <!--Forgot Model-->
        <div class="modal fade mt-5" id="forgotModal"  role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog mt-5" role="document">
                <div class="modal-content bg-blue rounded-modal shadow p-3" style="margin-top: 4rem;">
                    <center>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close" onClick="window.location.reload();">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h3 class="text-white mb-5 mt-3" id="exampleModalLabel">Forgot Password</h3>
                    </center>
                    <div class="bg-white top-rounded pt-4">
                        <div class="modal-body bg-white top-rounded mt-3">
                            <form class="mt-3" id="forgot_form"><center>
                                    <div class="form-group input-group w-75">
                                        <input type="text" class="form-control textField-bg border-0 p-3 mb-2 zIndex-1" id="f_email" placeholder="Email" required="">
                                    </div>
                                    <p class="text-danger" id="forgot_email"></p>
                                </center>
                                <center><button type="button" id="forgot_btn" class="blue-btn w-75" onclick="forgot_pass()">Send Link</button></center>
                            </form>
                        </div>
                    </div>  
                </div>
            </div>
        </div>

        <!-- profile Modal -->
        @if(empty(session()->get('web_username')))

        @else
        @if(session()->get('type') == 'student')
        <div class="modal fade mt-5" id="profileModal"  role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog mt-5" role="document">
                <div class="modal-content bg-blue rounded-modal shadow p-3" style="margin-top: 4rem;">
                    <center>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h3 class="text-white mb-3 mt-3" id="exampleModalLabel">Student Profile</h3>
                    </center>
                    <div class="modal-body bg-white top-rounded mt-3">
                        <a href="{{ url('Logout') }}" class="text-blue"><i class="bi bi-power float-right h3"></i></a>
                        <form  class="mt-3"><center>
                                <div class="mb-5">
                                    <img src="{{ (isset($getdata)) ? ((empty($getdata[0]->image)) ? asset('public/assets/img/avatar.png') : asset($getdata[0]->image) ) : asset('public/assets/img/avatar.png') }}" id="profileImage" height="100px" width="100px" class="shadow bg-white rounded-circle" alt="">
                                    <input id="imageUpload" type="file" name="profile_photo" placeholder="Photo" required="" onchange="student_image()" capture>
                                    <h6 class="text-blue mt-2">{{ session()->get('web_username')}}</h6>
                                    <p id="uploaded_image"></p>
                                </div>
                                <div class="form-group input-group w-75">
                                    <input type="text" class="form-control textField-bg border-0 p-3 mb-2 zIndex-1" id="usernames" value="{{ (isset($getdata)) ? $getdata[0]->username : '' }}">
                                </div>

                                <div class="form-group input-group w-75">
                                    <input type="text" class="form-control textField-bg border-0 p-3 mb-2 zIndex-1" id="mob_no" placeholder="Mobile Number" value="{{ (isset($getdata)) ? $getdata[0]->mobile_no : '' }}">
                                </div>

                                <div class="form-group input-group w-75">
                                    <input type="text" class="form-control textField-bg border-0 p-2 mb-2 zIndex-1" id="std" placeholder="Standard" value="{{ (isset($getdata)) ? $getdata[0]->standard : '' }}">
                                </div>

                                <div class="form-group input-group w-75">
                                    <input type="text" class="form-control textField-bg border-0 p-3 mb-5 zIndex-1" id="location" placeholder="Location" value="{{ (isset($getdata)) ? $getdata[0]->location : '' }}">
                                </div>
                            </center>

                            <center><button type="button" class="orange-btn w-75 mb-4" onclick="student_update()">Update</button></center>

                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endif
        @endif

        @include('footer')


        <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
        <link href="{{ asset('assets/css/stackpath.css') }}" rel="stylesheet">
        <script src="{{ asset('assets/js/stackpath.js') }}"></script>

        <!-- Vendor JS Files -->
        <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.js') }}"></script>
        <script src="{{ asset('assets/vendor/aos/aos.js') }}"></script>
        <script src="{{ asset('assets/vendor/php-email-form/validate.js') }}"></script>
        <!--<script src="{{ asset('public/assets/vendor/swiper/swiper-bundle.min.js') }}"></script>-->
        <script src="{{ asset('assets/vendor/glightbox/js/glightbox.min.js') }}"></script>
        <script src="{{ asset('swiper/swiper.min.js') }}"></script>
        <!-- Template Main JS File -->
        <script src="{{ asset('assets/js/main.js') }}"></script>
        <!-- Firebase App (the core Firebase SDK) is always required and must be listed first -->
        <script src="https://www.gstatic.com/firebasejs/8.6.1/firebase-app.js"></script>

        <!-- If you enabled Analytics in your project, add the Firebase SDK for Analytics -->
        <script src="https://www.gstatic.com/firebasejs/8.6.1/firebase-analytics.js"></script>

        <!-- Add Firebase products that you want to use -->
        <script src="https://www.gstatic.com/firebasejs/8.6.1/firebase-auth.js"></script>
        <script src="https://www.gstatic.com/firebasejs/8.6.1/firebase-firestore.js"></script>
        <script src="{{ asset('js/firebase_config.js') }}"></script>

        <script src="{{ asset('js/facebook.js') }}"></script>
        <script src="{{ asset('js/google.js') }}"></script>
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
        <!-- Left Side Bar -->
        @if(session()->get('web_username'))
        <script>
            $(document).ajaxStart(function () {
                $(".loader").show();
            });
            $(document).ajaxComplete(function () {
                $(".loader").hide();
            });
            window.addEventListener('mouseup', function (event) {
                var box = document.getElementById('mySidenav');
                if (event.target != box && event.target.parentNode != box) {
                    box.style.display = 'none';
                }
            });
            $(document.body).on('click', "#profileImage", function (e) {
                $("#imageUpload").click();
            });
            function fasterPreview(uploader) {

                if (uploader.files && uploader.files[0]) {
                    $('#profileImage').attr('src', window.webkitURL.createObjectURL(uploader.files[0]));
                }
                var image = $('#imageUpload').prop('files')[0];
            }

            $(document.body).on('change', "#imageUpload", function (e) {
                fasterPreview(this);
            });
        </script>
        <script>
            function openNav() {
                document.getElementById("mySidenav").style.cssText = "width:270px; box-shadow: 1px 8px 8px 8px rgba(73,21,155,0.3); -webkit-box-shadow: 1px 8px 8px 8px rgba(73,21,155,0.3);  -moz-box-shadow: 1px 8px 8px 8px rgba(73,21,155,0.3);";
                var element = document.getElementById("mySidenav");
                element.classList.add("animated wow bounceInLeft slow");
            }

            function closeNav() {
                document.getElementById("mySidenav").style.cssText = "width:0; border:none; box-shadow: none;";
            }
        </script>
        @else
        <script type="text/javascript">
            document.getElementById("opennav").style.display = 'none';
        </script>
        @endif
        <!-- For Login -->
        <script type="text/javascript">
            document.querySelector("#forgot").addEventListener("click", function () {
                document.querySelector("#loginModal").style.display = "none";
            })
            $('#forgotModal').on('hidden.bs.modal', function () {
                location.reload();
            })
            $('#loginModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget) // Button that triggered the modal
                var recipient = button.data('whatever') // Extract info from data-* attributes
                // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
                // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
                var modal = $(this)
                modal.find('.modal-title').text('New message to ' + recipient)
//                modal.find('.modal-body input').val(recipient)
            })
        </script>

        <!-- For SignUp -->
        <script type="text/javascript">
            $('#signUpModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget) // Button that triggered the modal
                var recipient = button.data('whatever') // Extract info from data-* attributes
                // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
                // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
                var modal = $(this)
                modal.find('.modal-title').text('New message to ' + recipient)
//                modal.find('.modal-body input').val(recipient)
            })
        </script>

        <!-- For profile -->
        <script type="text/javascript">
            $('#profileModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget) // Button that triggered the modal
                var recipient = button.data('whatever') // Extract info from data-* attributes
                // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
                // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
                var modal = $(this)
                modal.find('.modal-title').text('New message to ' + recipient)
//                modal.find('.modal-body input').val(recipient)
            })
        </script>
        <script>
            $.ajaxSetup({

                headers: {

                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

                }

            });
            $(document).ready(function () {
                var oldMatched = 0;
                var bothMatched = 0;
                $('#con_password').on('blur', function () {
                    if ($('#r_password').val() != $('#con_password').val())
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
            function register() {
                var username = document.getElementById('username').value;
                var email = document.getElementById('r_email').value;
                var password = document.getElementById('r_password').value;
                var type = document.getElementById('types').checked;
//                alert(type);
                var dataString = 'username=' + username + '&email=' + email + '&password=' + password + '&type=' + type;

                firebase.auth().createUserWithEmailAndPassword(email, password)

                        .then((userCredential) => {
//                            console.log(userCredential);
                            var user = userCredential.user;
//                            var uid = user.uid;
//                            saveUId(uid, email);
                            user.sendEmailVerification();
                            console.log(user.emailVerified);
                            $.ajax({
                                url: "<?php echo URL('register') ?>",
                                type: "post",
                                data: dataString,
                                dataType: "json",
                                cache: false,
                                success: function (data) {
                                    if (data.status == true) {
                                        $('#signUpModal').hide();
                                        $('#loginModal').modal('show');
                                    }
                                }
                            });
                        })
                        .catch((error) => {
//                                        alert("sdsdf");
                            var errorCode = error.code;
                            var errorMessage = error.message;
                            alert(errorMessage);
                            // ..
                        });
            }

            function Login() {
//            import { getAuth, signInWithEmailAndPassword } from "firebase/auth";
                var email = document.getElementById('email').value;
                var password = document.getElementById('password').value;
                var type = document.getElementById('type').checked;
//                alert(type);
                var dataString = 'email=' + email + '&type=' + type;

                //--------------Firebase Authentication-------------------//
                firebase.auth().signInWithEmailAndPassword(email, password)

                        .then((userCredential) => {
                            // Signed in 
                            var user = userCredential.user;
                            // ...
                            var emailverified = user.emailVerified;
//                            console.log(emailverified);
                            if (emailverified == true) {
                                $.ajax({
                                    url: "<?php echo URL('login') ?>",
                                    type: "post",
                                    data: dataString,
                                    dataType: "json",
                                    success: function (data) {
                                        console.log(data);
                                        if (data.type == 'tutor') {
                                            alert("Login Successfully..!!");
                                            if (data.tutor == '1') {
                                                location.reload();
                                            } else {
                                                window.location.href = '<?php echo URL('Tutor_registration') ?>';
                                            }

                                        } else {
                                            alert("Please check Login Details..!!Wrong Credentials");
                                        }
                                    }
                                });
                            } else {
                                alert("your email is not verified! Please check your email for verification & then login..");
                                user.sendEmailVerification();
                            }
                        })
                        .catch((error) => {
                            var errorCode = error.code;
                            var errorMessage = error.message;
                            alert(errorMessage);
                            // ..
                        });
            }
        </script>
        <script>
            function student_update() {
                var username = document.getElementById('usernames').value;
                var mob_no = document.getElementById('mob_no').value;
                var location = document.getElementById('location').value;
                var std = document.getElementById('std').value;
//                alert(username + " " + mob_no + " " + location + " " + std);
                var dataString = 'username=' + username + '&mob_no=' + mob_no + '&location=' + location + '&std=' + std;
                $.ajax({
                    url: "<?php echo URL('student_update') ?>",
                    type: "post",
                    data: dataString,
                    cache: false,
                    success: function (data) {
                        alert("Update Successfully..!!");
                        window.location.reload(true);
                    }
                });
            }
            function check_email() {
                var email = document.getElementById('r_email').value;
                var type = document.getElementById('types').checked;
                var dataString = 'email=' + email + '&type=' + type;
                $.ajax({
                    url: "<?php echo URL('check_email') ?>",
                    type: "post",
                    data: dataString,
                    cache: false,
                    success: function (data) {
//                        alert(data);
                        if (data == '1') {
                            document.getElementById('email_message').innerHTML = 'This Email Already Exist..!!';
                            $("#registers").prop("disabled", true);
                        } else {
                            document.getElementById('email_message').innerHTML = '';
                            $('#registers').prop('disabled', false);
                        }
                    }
                });
            }
        </script>
        <script>
            function forgot_pass() {
                var email = document.getElementById('f_email').value;
                var type = document.getElementById('type').checked;
                firebase.auth().sendPasswordResetEmail(email)
                        .then(() => {
                            // Password reset email sent!
                            // ..
                            document.getElementById('forgot_email').innerHTML = 'Mail Send';
                        })
                        .catch((error) => {
                            var errorCode = error.code;
                            var errorMessage = error.message;
                            alert(errorMessage);
                            // ..
                        });
//                var email = document.getElementById('f_email').value;
//                var type = document.getElementById('type').checked;
//                if (type == false) {
//                    var types = 'tutor';
//                }
//                if (type == true) {
//                    var types = 'student';
//                }
//                var dataString = 'email=' + email + '&type=' + types;
//                $.ajax({
//                    url: "<?php echo URL('check_forgot_pass') ?>",
//                    type: "post",
//                    data: dataString,
//                    dataType: "html",
//                    success: function (data) {
//                        console.log(data);
//                        if (data == '1') {
//                            document.getElementById('forgot_email').innerHTML = 'This Email ID Not Registered..!!';
//                            $("#forgot_btn").prop("disabled", true);
//                        } else {
//                            document.getElementById('forgot_email').innerHTML = 'Mail Send';
//                            document.getElementById('forgot_email').style.color = 'green';
//                            $('#forgot_btn').prop('disabled', false);
//                        }
//
//                    }
//                });
            }
            function student_image() {
                var BaseURL = $('meta[name="baseURL"]').attr('content');
                var name = document.getElementById("imageUpload").files[0].name;
                var form_data = new FormData();
                var ext = name.split('.').pop().toLowerCase();
                if (jQuery.inArray(ext, ['png', 'jpg', 'jpeg', 'PNG', 'JPG', 'JPEG']) == -1)
                {
                    alert("Invalid Image File");
                }
                var oFReader = new FileReader();
                oFReader.readAsDataURL(document.getElementById("imageUpload").files[0]);
                var f = document.getElementById("imageUpload").files[0];
                var fsize = f.size || f.fileSize;
                if (fsize > 2000000)
                {
                    alert("Image File Size is very big");
                } else
                {
                    form_data.append("file", document.getElementById('imageUpload').files[0]);
                    $.ajax({
                        url: "<?php echo URL('student_image') ?>",
                        method: "POST",
                        data: form_data,
                        contentType: false,
                        cache: false,
                        processData: false,
                        beforeSend: function () {

                            $('#uploaded_image').html("<label class='text-success'>Image Uploading...</label>");
                        },
                        success: function (data)
                        {
//                            alert(data);
                            if (data == 1) {
                                $('#uploaded_image').html("Image Update Successfully..!!");
//                            document.getElementById("imagename").src = BaseURL + 'Images/' + data;
//                            document.getElementById("imagename_menu").src = BaseURL + 'Images/' + data
                            }
                        }
                    });
                }
            }

        </script>
        <script>
            //Hide Message After Few Seconds
            $(document).ready(function () {
                setTimeout(function () {
                    $('#uploaded_image').fadeOut('fast');
                }, 3000);
            });
        </script>
    </body>

</html>
