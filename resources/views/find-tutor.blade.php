<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta content="width=device-width, initial-scale=1.0" name="viewport">
        <title>Tutor Finder</title>
        <meta content="" name="description">
        <meta content="" name="keywords">
        <!-- Favicons -->
        <link href="{{ asset('public/assets/img/favicon.png') }}" rel="icon">
        <link href="{{ asset('public/assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">
        <!-- Google Fonts -->
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
        <style>

        </style>
    </head>
    <body>
        <div class="loader"></div>
        @include('sidebar')
        @include('header')
        <input type="hidden" name="loc_latitude" id="latitude" value="0">
        <input type="hidden" name="loc_longitude" id="longitude" value="0">
        <input type="hidden" name="email" id="email" value="{{ session()->get('web_username') }}">
        <div class="hero pt-5">
            <!-- profile Modal -->
            @if(empty(session()->get('web_username')))
            @else
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
                            <form  class="mt-3"><center>
                                    <div class="mb-5">
                                        <img src="{{ (isset($getdata)) ? asset($getdata[0]->image) : asset('public/assets/img/avatar.png') }}" id="profileImage" height="100px" width="100px" class="shadow bg-white rounded-circle" alt="">
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

            <!-- ======= Tab Section ======= -->
            <section class="container mt-5" id="filter-tab">
                <div class="">
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <!--<div class="tab-header col-md-12">-->
                        <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true"><i class="bi bi-sliders mr-2"></i>All</button>
                        <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false"><i class="bi bi-geo-alt-fill mr-2"></i>Nearby</button>
                        <button class="nav-link" id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#nav-contact" type="button" role="tab" aria-controls="nav-contact" aria-selected="false"><i class="bi bi-star-fill mr-2"></i>Popular</button>
                        <!--</div>-->
                        <section class="d-flex align-items-center testimonials" id="nav-subject-tab" type="button" >
                            <div class="container">
                                <div class="row d-flex justify-content-center subject">
                                    <!-- Slider main container -->
                                    <div class="swiper-container">
                                        <!-- Additional required wrapper -->
                                        <div class="swiper-wrapper">
                                            @foreach($subject as $sub)
                                            <div class="swiper-slide">
                                                <div class="col-centered">
                                                    <label>
                                                        <input type="radio" class="card-input-element radio d-none" name="sub" id="{{ $sub->id}}" value="{{ $sub->id}}" onclick="get_subject_tutor(this.id)">
                                                        <div class="box-part bg-blue text-center shadow subjects">
                                                            <img src="{{ asset($sub->image ) }}" class="img-fluid mx-auto d-block mt-3" alt="...">
                                                            <div class="title mt-2">
                                                                <p>{{ $sub->subject_name }}</p>
                                                            </div>
                                                        </div>
                                                    </label>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                        <!-- If we need navigation buttons -->
                                        <div class="swiper-button-prev"><i class="bi bi-chevron-left"></i></div>
                                        <div class="swiper-button-next"><i class="bi bi-chevron-right"></i></div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>

            </section>


            <!-- ======= Hero Section ======= -->

            <!--            <div class="tab-content text-center" id="nav-tabContent">
                            <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">All Tutor List</div>
                            <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">Nearby Tutor</div>
                             popular tutor list 
                             end of popular tutor list 
                            <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">Popular Tutors</div>
                        </div> -->
            <div class="tab-content text-center" id="nav-tabContent">

                <section class="container-fluid bg-white tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                    <div class="container">
                        <h5 class="text-secondary">All Tutors</h5>
                        <div class="row d-flex justify-content-center">
                            @if(count($all_tutor) == 0)
                            <div class="col-auto col-centered mr-4">
                                <center>
                                    <img src="{{ asset('public/assets/img/no-data.png') }}" class="rounded shadow-sm">
                                </center>
                            </div>
                            @else
                            @foreach($all_tutor as $all)
                            <?php
                            $name = (strlen($all->username) > 13) ? substr($all->username, 0, 10) . '...' : $all->username;
                            ?>
                            <div class="col-auto col-centered mr-4">
                                <a href="{{ url('Tutor_details',$all->id) }}">
                                    <div class="box-part text-center shadow bg-white tutor-img">
                                        <img src="{{ (isset($all)) ? ((empty($all->image)) ? asset('public/assets/img/avatar.png') : asset($all->image)) : asset('public/assets/img/avatar.png') }}" class="img-fluid mx-auto d-block rounded-circle" alt="...">
                                        <div class="title mt-1">
                                            <span class="text-dark h5">{{ $name }}</span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            @endforeach
                            @endif
                        </div>
                    </div>
                </section> 
                <section class="container-fluid bg-white tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                    <div class="container">
                        <h5 class="text-secondary">Nearby Tutors</h5>
                        <div class="row d-flex justify-content-center">
                            @if(count($nearby) == 0)
                            <div class="col-auto col-centered mr-4">
                                <center>
                                    <img src="{{ asset('public/assets/img/no-data.png') }}" class="rounded shadow-sm">
                                </center>
                            </div>
                            @else
                            @foreach($nearby as $near)
                            <?php
                            $name = (strlen($near->username) > 13) ? substr($near->username, 0, 10) . '...' : $near->username;
                            ?>
                            <div class="col-auto col-centered mr-4">
                                <a href="{{ url('Tutor_details',$near->id) }}">
                                    <div class="box-part text-center shadow bg-white tutor-img">
                                        <img src="{{ (isset($nearby)) ? ((empty($near->image)) ? asset('public/assets/img/avatar.png') : asset($near->image)) : asset('public/assets/img/avatar.png') }}" class="img-fluid mx-auto d-block rounded-circle" alt="...">
                                        <div class="title mt-1">
                                            <span class="text-dark h5">{{ $name }}</span>
                                        </div>
                                        <div class="mt-1">
                                            <span class="text-dark h5"><i class="bi bi-geo-fill"></i>{{ $near->distance }} Km</span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            @endforeach
                            @endif
                        </div>
                    </div>
                </section>                
                <!-- popular tutor list -->
                <section class="container-fluid bg-white tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
                    <div class="container">
                        <h5 class="text-secondary">Popular Tutors</h5>
                        <div class="row d-flex justify-content-center">
                            @if(count($popular) == 0)
                            <div class="col-auto col-centered mr-4">
                                <center>
                                    <img src="{{ asset('public/assets/img/no-data.png') }}" class="rounded shadow-sm">
                                </center>
                            </div>
                            @else
                            @foreach($popular as $pop)
                            <?php
                            $string = (strlen($pop->username) > 13) ? substr($pop->username, 0, 10) . '...' : $pop->username;
                            ?>
                            <div class="col-auto col-centered mr-4">
                                <a href="{{ url('Tutor_details',$pop->iid) }}">
                                    <div class="box-part text-center shadow bg-white tutor-img">
                                        <img src="{{ (isset($popular)) ? ((empty($pop->image)) ? asset('public/assets/img/avatar.png') : asset($pop->image)) : asset('public/assets/img/avatar.png') }}" class="img-fluid mx-auto d-block rounded-circle" alt="...">
                                        <div class="title mt-1">
                                            <span class="text-dark h5">{{ $string }}</span><br>
                                            <div class="rate  text-secondary text-center pl-0 star-yellow h6">
                                                <input type="checkbox" id="star5" name="rate" value="5" class="submit_star d-inline" {{ ($pop->rating >= 5) ? 'checked="checked"' : '' }} />
                                                <label for="star5" title="text">5 stars</label>
                                                <input type="checkbox" id="star4" name="rate" value="4" class="submit_star" {{ ($pop->rating >= 4) ? 'checked="checked"' : '' }} />
                                                <label for="star4" title="text">4 stars</label>
                                                <input type="checkbox" id="star3" name="rate" value="3" class="submit_star" {{ ($pop->rating >= 3) ? 'checked="checked"' : '' }} />
                                                <label for="star3" title="text">3 stars</label>
                                                <input type="checkbox" id="star2" name="rate" value="2" class="submit_star" {{ ($pop->rating >= 2) ? 'checked="checked"' : '' }} />
                                                <label for="star2" title="text">2 stars</label>
                                                <input type="checkbox" id="star1" name="rate" value="1" class="submit_star" {{ ($pop->rating >= 1) ? 'checked="checked"' : '' }} />
                                                <label for="star1" title="text">1 star</label>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            @endforeach
                            @endif
                        </div>
                    </div>
                </section>
                <!-- end of popular tutor list -->
                <section class="container-fluid bg-white tab-pane fade" id="nav-subject" role="tabpanel" aria-labelledby="nav-subject-tab">
                    <div class="container">
                        <h5 class="text-secondary">Subject wise Tutor</h5>
                        <div class="row d-flex justify-content-center " id="subject_tutor">
                            @foreach($pop_tutor as $tutor)
                            <?php
                            $string = (strlen($tutor->username) > 13) ? substr($tutor->username, 0, 10) . '...' : $tutor->username;
                            ?>
                            <div class="col-auto col-centered mr-4">
                                <a href="{{ url('Tutor_details',$tutor->id) }}">
                                    <div class="box-hori shadow bg-white">
                                        <ul class="pl-0 mb-1">
                                            <li class="d-inline-block"><img src="{{ (isset($tutor)) ? ((empty($tutor->image)) ? asset('public/assets/img/avatar.png') : asset($tutor->image)) : asset('public/assets/img/avatar.png') }}" class="img-fluid ml-3 d-block rounded-circle" alt="..."></li>
                                            <li class="d-inline-block align-top ml-3 mt-4"><span class="text-dark h5">{{ $string }}</span></li>
                                        </ul>
                                        <ul class="text-secondary text-center h6 font-weight-light">
                                            @php
                                            $myString = $tutor->sname;
                                            $subject = str_replace(",", " | ", $myString);
                                            @endphp
                                            <li class="d-inline">{{ $subject }}</li>
                                            <!-- <p class="text-black-50">Online</p> --> <!-- for all -->
                                            <!-- <p class="text-black-50"><i class="bi bi-geo"></i> 4 km</p> --> <!-- for nearby -->
                                            <!-- <p class="text-black-50 col-1"><i class="bi bi-star-fill pl-1"></i>4.5</p>  --> <!-- for popular -->
                                        </ul>
                                    </div>
                                </a>
                            </div>
                            @endforeach
                        </div>
                    </div>

                </section>
                <!--<div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">Popular Tutors</div>-->
            </div> 
            <!-- ======= Footer ======= -->
            @include('footer')
            <!-- End Footer -->
        </div>
        <!-- <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a> -->
        <script src="{{ asset('public/assets/js/jquery.min.js') }}"></script>
        <link href="{{ asset('public/assets/css/stackpath.css') }}" rel="stylesheet">
        <script src="{{ asset('public/assets/js/stackpath.js') }}"></script>
        <!-- Vendor JS Files -->
        <script src="{{ asset('public/assets/vendor/bootstrap/js/bootstrap.bundle.js') }}"></script>
        <script src="{{ asset('public/assets/vendor/aos/aos.js') }}"></script>
        <script src="{{ asset('public/assets/vendor/php-email-form/validate.js') }}"></script>
        <!--<script src="{{ asset('public/assets/vendor/swiper/swiper-bundle.min.js') }}"></script>-->
        <script src="{{ asset('public/assets/vendor/glightbox/js/glightbox.min.js') }}"></script>
        <script src="{{ asset('public/swiper/swiper.min.js') }}"></script>
        <!-- Template Main JS File -->
        <script src="{{ asset('public/assets/js/main.js') }}"></script>
        <!-- single selectable category -->
        <script>

                                                            window.onload = function () {
                                                                if (navigator.geolocation) {
                                                                    navigator.geolocation.getCurrentPosition(showPosition, showError);
                                                                } else {
                                                                    alert("Geolocation is not supported by this browser.");
                                                                }
                                                            }
                                                            function showError(error) {
                                                                switch (error.code) {
                                                                    case error.PERMISSION_DENIED:
                                                                        alert("User denied the request for Geolocation.");
                                                                        break;
                                                                    case error.POSITION_UNAVAILABLE:
                                                                        alert("Location information is unavailable.");
                                                                        break;
                                                                    case error.TIMEOUT:
                                                                        alert("The request to get user location timed out.");
                                                                        break;
                                                                    case error.UNKNOWN_ERROR:
                                                                        alert("An unknown error occurred.");
                                                                        break;
                                                                }
                                                            }
                                                            function showPosition(position) {
                                                                document.getElementById('latitude').value = position.coords.latitude;
                                                                document.getElementById('longitude').value = position.coords.longitude;
                                                                var email = document.getElementById('email').value;
                                                                var latitude = document.getElementById('latitude').value;
                                                                var longitude = document.getElementById('longitude').value;
                                                                var dataString = 'latitude=' + latitude + '&longitude=' + longitude + '&email=' + email;
                                                                $.ajax({
                                                                    url: "<?php echo URL('update_lat_long') ?>",
                                                                    type: "post",
                                                                    data: dataString,
                                                                    cache: false,
                                                                    success: function (data) {
                                                                        // alert(data);

                                                                    }
                                                                });

                                                            }
        </script>
        <script>
            $(window).on('load', function () {
                $('.loader').fadeOut();
            });
        </script>
        <script type="text/javascript">
            window.addEventListener('mouseup', function (event) {
                var box = document.getElementById('mySidenav');
                if (event.target != box && event.target.parentNode != box) {
                    box.style.display = 'none';
                }
            });
            $('input[type="checkbox"]').on('change', function () {
                $('input[type="checkbox"]').not(this).prop('checked', false);
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
        <!-- Left Side Bar -->
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
        <link href="{{ asset('public/assets/css/stackpath.css') }}" rel="stylesheet">
        <script src="{{ asset('public/assets/js/stackpath.js') }}"></script>
        <script>
            $(".nav-link").click(function () {
                $('input[type="radio"]').prop('checked', false);
//                $('#nav-subject').css('display', 'none');
                $('.tab-content>#nav-subject').removeClass('active show');

            });
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            })
            $('#subject_tutor').html('');
            function get_subject_tutor(id) {
                $('#subject_tutor').html('');
                var ref_this = $('#nav-tab>.nav-link.active').attr('id');

                var check_val = document.getElementById(id).checked;
                var val = document.querySelector('input[name="sub"]:checked').value;
//                var dataString = 'id=' + val + '&check_val=' + id + 'type=' + ref_this;
//                alert(dataString);
                $.ajax({
                    url: "<?php echo URL('get_subject_tutor') ?>",
                    type: "post",
                    data: {
                        id: val,
                        check_val: id,
                        type: ref_this
                    },
                    cache: false,
                    success: function (data) {
//                        alert(data);

                        $("#nav-tabContent>section.active").removeClass("active");

                        $('#subject_tutor').html(data);
                        $('.tab-content>#nav-subject').addClass('active show');

//                        $('#nav-subject').css('display', 'none');

//                        $('#nav-home').hide();
//                        $('#nav-profile').hide();
//                        $('#nav-contact').hide();
//                       


                    }
                });
            }
            $(document).ready(function () {
                // Swiper: Slider
                new Swiper('.swiper-container', {
                    //                    loop: true,
                    nextButton: '.swiper-button-next',
                    prevButton: '.swiper-button-prev',
                    slidesPerView: 4,
                    paginationClickable: true,
                    spaceBetween: 30,
                    breakpoints: {
                        1920: {
                            slidesPerView: 5,
                            spaceBetween: 20
                        },
                        1028: {
                            slidesPerView: 3,
                            spaceBetween: 20
                        },
                        480: {
                            slidesPerView: 1,
                            spaceBetween: 5
                        }
                    }
                });
            });
        </script>
    </body>
</html>