<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta content="width=device-width, initial-scale=1.0" name="viewport">

        <title>KlassPe</title>
        <meta content="" name="description">

        <meta content="" name="keywords">

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
        <link href="{{ asset('swiper/swiper.min.css') }}" rel="stylesheet">



        <!-- Template Main CSS File -->
        <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/choice.css') }}">


    </head>

    <body>
        <div class="loader"></div>
        <!-- ======= Header ======= -->
        <header id="header" class="header fixed-top container-fluid">
            <div class="d-flex align-items-center justify-content-between">
                <span class="menu ml-5" onclick="openNav()"></span>

                <a href="" class="logo d-flex align-items-center container-xl">
                    <img src="" class="img-scroll">
                    <span>KlassPe</span>
                </a>

                <nav id="navbar" class="navbar mr-5">
                </nav><!-- .navbar -->

            </div>
        </header><!-- End Header -->

        <div class="hero pt-5">


            <!-- ======= Hero Section ======= -->
            <section class="d-flex align-items-center mt-5 mb-n5">
                <div class="container">
                    <div class="row d-flex justify-content-center subject">
                        <div class="swiper-container">
                            <!-- Additional required wrapper -->
                            <div class="swiper-wrapper">

                                @foreach($subject as $sub)
                                <div class="swiper-slide">
                                    <div class="col-auto col-centered" id="subject_content">
                                        <label>
                                            <input type="checkbox" id="{{ $sub->id }}" name="subject_content" class="card-input-element d-none  radio" value="{{ $sub->subject_name }}" required="">
                                            <div class="box-part bg-blue text-center shadow subjects">
                                                <img src="{{ $sub->image }}" class="img-fluid mx-auto d-block mt-3" alt="...">
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
            </section><!-- End subjects -->


            <!-- subject wise tutor list -->
            <section class="container-fluid bg-white">
                <div class="container">
                    <div class="row d-flex justify-content-center">
                        <form class="mt-3 textField-bg rounded p-5 col-lg-9" action="{{ URL('insert_registration') }}" onsubmit="return validation_check()" method="post">
                            <input name="_token" type="hidden" value="{{ csrf_token() }}"/>
                            <center>
                                <!--Success Message-->
                                <div class="mt-4" id="Message">
                                    <div class="text-center">
                                        <?php
                                        if (session()->has('message')) {
                                            echo session()->get('message');
                                        }
                                        ?>
                                    </div>
                                </div>
                                <h5 class="text-secondary text-left mb-4">Tutor Registration</h5>

                                <select id="choices-multiple-remove-button" placeholder="Select Standard" name="standard[]" multiple required=""><i class="bi bi-chevron-up text-blue" ></i>
                                    @foreach($standard as $std)
                                    <option value="{{ $std->id }}">{{ $std->std }}</option>
                                    @endforeach
                                </select> 
                                <div  id="subject_with_fees">
                                </div>
                                <div class="form-group input-group w-100">
                                    <input type="hidden" class="form-control bg-white border-0 p-3 mb-2 zIndex-1" id="subject_id" placeholder="Select Subject">
                                </div>


                                <div class="form-group input-group w-100">
                                    <input type="text" class="form-control bg-white border-0 p-3 mb-2 zIndex-1" id="university" name="university" placeholder="Enter University">
                                </div>

                                <div class="form-group input-group w-100">
                                    <input type="text" class="form-control bg-white border-0 p-3 mb-2 zIndex-1" id="location" name="location" placeholder="Enter Location">
                                </div>
                                <input type="hidden" name="loc_latitude" id="latitude" value="0">
                                <input type="hidden" name="loc_longitude" id="longitude" value="0">

                                <div class="form-group input-group w-100">
                                    <input type="text" class="form-control bg-white border-0 p-3 mb-4 zIndex-1" id="year_of_experience" name="year_of_experience" placeholder="Year of Experience">
                                </div>
                                <!--<div class="form-group input-group">-->
                                <div class="text-left tution-type" id="tuition">
                                    <h5 class="text-secondary">Tuition Type</h5>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="tuition_type" id="inlineRadio1" value="1">
                                        <label class="form-check-label" for="inlineRadio1">Online Tuition</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="tuition_type" id="inlineRadio1" value="2">
                                        <label class="form-check-label" for="inlineRadio1">Offline Tuition</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="tuition_type" id="inlineRadio1" value="3">
                                        <label class="form-check-label" for="inlineRadio1">Both</label>
                                    </div>
                                </div>
                                <h5 class="text-secondary text-left mb-4 mt-4">Hours of Availability</h5>
                                <div class="form-group w-100 my-3 text-left" id="hours_availble">
                                    <div>
                                        <p class="text-lighter text-left font-weight-light">Morning Hours</p>
                                    </div>
                                    @foreach($m_hours as $hour)
                                    <span class="button-checkbox">
                                        <button type="button" class="btn"  data-color="primary">{{ $hour->hours }}</button>
                                        <input type="checkbox" class="hidden" id="Hours" name="m_hours[]" value="{{ $hour->id }}"/>
                                    </span>
                                    @endforeach
                                    <div>
                                        <p class="text-lighter text-left font-weight-light">Afternoon Hours</p>
                                    </div>
                                    @foreach($a_hours as $hour)
                                    <span class="button-checkbox">
                                        <button type="button" class="btn" data-color="primary">{{ $hour->hours }}</button>
                                        <input type="checkbox" class="hidden" id="Hours" name="a_hours[]" value="{{ $hour->id }}"/>
                                    </span>
                                    @endforeach
                                </div>

                                <br>
                            </center>

                            <center><button type="submit" id="submit" class="orange-btn w-75">Register</button></center>
                        </form>
                    </div>

                </div>
            </section> <!-- end of subject wise tutor list -->




            <!-- ======= Footer ======= -->
            @include('footer')
            <!-- End Footer -->
        </div>
        <!-- <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a> -->

        <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
        <!-- Template Main JS File -->

        <script src="{{ asset('assets/js/main.js') }}"></script>

        <script src="{{ asset('assets/js/choices.js') }}"></script>
        <script src="{{ asset('swiper/swiper.min.js') }}"></script>
                <!-- <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places&key=AIzaSyCv-KnZejOZj4lpHixEkvdUgwRsdMxarhg"></script> -->
        <script>
                            function validation_check() {

                                var tustion_len = document.querySelectorAll('#tuition input[type="radio"]:checked').length;
                                var avail_hours_len = document.querySelectorAll('#hours_availble input[type="checkbox"]:checked').length;

                                if (tustion_len <= 0) {
                                    alert("Please check at least one tuition type");
                                    return false;
                                } else if (avail_hours_len <= 0) {
                                    alert("Please Select at least one hours of availability");
                                    return false;
                                } else {
                                    return true;
                                }

                            }
                            function validate() {
                                var length = document.getElementsByClassName("fees").value; // get the value
                                var valid = length = 0;                               // if length is > 0 then valid will be true, otherwise it will be false
                                document.getElementById("submit").disabled = valid;  // disable if only valid is false
                            }
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
                            }


        </script>

        <script>

            // var searchInput = 'location';

            // $(document).ready(function () {
            // var autocomplete;
            // autocomplete = new google.maps.places.Autocomplete((document.getElementById(searchInput)), {
            // types: ['geocode'],
            // });

            // google.maps.event.addListener(autocomplete, 'place_changed', function () {
            // var near_place = autocomplete.getPlace();
            // document.getElementById('latitude').value = near_place.geometry.location.lat();
            // document.getElementById('longitude').value = near_place.geometry.location.lng();
            // });
            // });

            // $(document).on('change', '#' + searchInput, function () {
            // document.getElementById('latitude').value = '';
            // document.getElementById('longitude').value = '';
            // });
        </script>
        <script>
            $(window).on('load', function () {
                $('.loader').fadeOut();
            });
        </script>
        <script type="text/javascript">
            $(document).ready(function () {

                var multipleCancelButton = new Choices('#choices-multiple-remove-button', {
                    removeItemButton: true,
                    maxItemCount: 5,
                    searchResultLimit: 5,
                    renderChoiceLimit: 5
                });
            });
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
        <script type="text/javascript">
            $('select').selectpicker();
        </script>

        <script src="{{ asset('assets/js/choices.js') }}"></script>

        <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <link href="{{ asset('assets/css/stackpath.css') }}" rel="stylesheet">
        <script src="{{ asset('assets/js/stackpath.js') }}"></script>

        <!-- Vendor JS Files -->
        <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.js') }}"></script>
        <script src="{{ asset('assets/vendor/aos/aos.js') }}"></script>
        <script src="{{ asset('assets/vendor/php-email-form/validate.js') }}"></script>
        <script src="{{ asset('assets/vendor/swiper/swiper-bundle.min.js') }}"></script>
        <script src="{{ asset('assets/vendor/purecounter/purecounter.js') }}"></script>
        <script src="{{ asset('assets/vendor/isotope-layout/isotope.pkgd.min.js') }}"></script>
        <script src="{{ asset('assets/vendor/glightbox/js/glightbox.min.js') }}"></script>
        <script type="text/javascript">
            $(function () {
                $('.button-checkbox').each(function () {

                    // Settings
                    var $widget = $(this),
                            $button = $widget.find('button'),
                            $checkbox = $widget.find('#Hours'),
                            color = $button.data('color'),
                            settings = {
                                on: {
                                    icon: 'glyphicon glyphicon-check'
                                },
                                off: {
                                    icon: 'glyphicon glyphicon-unchecked'
                                }
                            };
                    // Event Handlers
                    $button.on('click', function () {
                        $checkbox.prop('checked', !$checkbox.is(':checked'));
                        $checkbox.triggerHandler('change');
                        updateDisplay();
                    });
                    $checkbox.on('change', function () {
                        updateDisplay();
                    });
                    // Actions
                    function updateDisplay() {
                        var isChecked = $checkbox.is(':checked');
                        // Set the button's state
                        $button.data('state', (isChecked) ? "on" : "off");
                        // Set the button's icon
                        $button.find('.state-icon')
                                .removeClass()
                                .addClass('state-icon ' + settings[$button.data('state')].icon);
                        // Update the button's color
                        if (isChecked) {
                            $button
                                    .removeClass('btn-default')
                                    .addClass('btn-' + color + ' active');
                        } else {
                            $button
                                    .removeClass('btn-' + color + ' active')
                                    .addClass('btn-default');
                        }
                    }

                    // Initialization
                    function init() {

                        updateDisplay();
                        // Inject the icon if applicable
                        if ($button.find('.state-icon').length == 0) {
                            $button.prepend('<i class="state-icon ' + settings[$button.data('state')].icon + '"></i> ');
                        }
                    }
                    init();
                });
            });
        </script>
        <script>


            $("#subject_content input[type='checkbox']").change(function () {
                var limit = 3;
                var newRow = $("#subject_with_fees");
                var cols = '';
                var numberOfChecked = $('input[name="subject_content"]:checkbox:checked').length;
                if (numberOfChecked <= limit) {
                    if (this.checked) {

                        cols += '<div class="row" subject_id=' + this.id + '><div class="form-group col-6 input-group w-100"><input type="hidden" id=' + this.id + '  value=' + this.id + ' name="subject_id[]"><input type="text" class="form-control bg-white border-0 p-3 mb-2 zIndex-1" id=' + this.id + '  value=' + this.value + ' name="subject[]" placeholder="Select Subject" readonly></div><div class="form-group col-6 input-group w-100"><input type="number" class="form-control bg-white border-0 p-3 mb-2 zIndex-1 fees" name="fees[]" placeholder="Fees"  min="1" oninput="validate()" required></div></div>';
                        newRow.append(cols);
                    } else {
                        $("div[subject_id='" + this.id + "']").remove();


                    }

                } else if (numberOfChecked > limit) {
                    $('#' + this.id).not(this).prop('checked', false);
                    this.checked = false;
                    alert("Maximum 3 Subject Select..!!");

                }
            });
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
        <script>
//Hide Message After Few Seconds
            $(document).ready(function () {
                setTimeout(function () {
                    $('#Message').fadeOut('fast');
                }, 3000);
            });
        </script>
    </body>

</html>