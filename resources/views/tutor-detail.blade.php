<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta content="width=device-width, initial-scale=1.0" name="viewport">

        <title>KlassPe</title>
        <meta content="" name="description">
        <meta content="" name="keywords">

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
        <style>

        </style>
    </head>

    <body class="bg-blue">
        <div class="loader"></div>
        <!-- ======= Header ======= -->
        <header id="header" class="header fixed-top container-fluid text-white mt-3">
            <div class="d-flex align-items-center justify-content-between container">
                <a href="{{ url('Find_tutor') }}"><span class="menu" onclick=""><i class="bi bi-chevron-left h1 text-white"></i></span></a>
                <h2>Tutor Detail</h2>
                <a class="nav-link" href="{{ url('Notification') }}"><i class="bi bi-bell-fill text-white h2"></i></a>
            </div>
        </header><!-- End Header -->
        <section> </section>
        <main class="mt-5 bg-white top-rounded">

            <!-- =======  Details Section ======= -->
            <section id="portfolio-details" class="portfolio-details d-flex justify-content-center">
                <div class="container">
                    <div class="row gy-4">
                        <div class="col-lg-3 shadow rounded text-center">
                            <div class="mt-3">
                                <div class="swiper-wrapper d-flex justify-content-center">
                                    <img src="{{ (isset($getdata)) ? ((empty($getdata[0]->image)) ? asset('public/assets/img/avatar.png') : asset($getdata[0]->image)) : asset('public/assets/img/avatar.png') }}" height="200px" width="200px" class="shadow bg-white rounded-circle" alt="">
                                </div>
                            </div>
                            <div class="mt-4 border-bottom"><h3>{{ $getdata[0]->username }}</h3></div>
                            <input type="hidden" name="tutor_name" value="{{ $getdata[0]->email }}" id="tutor_name">
                            <div class="mb-2 mt-3">
                                <?php
                                $myString = $getdata[0]->sname;
                                $subject = str_replace(",", " | ", $myString);
                                ?>
                                <li class="d-inline text-secondary font-weight-light">{{ $subject }}</li>
                            </div>

                            <div class="rate pl-5 float-left">
                                <input type="checkbox" id="star5" name="rate" value="5" class="submit_star" {{ ($rate[0]->rating >= 5) ? 'checked="checked"' : '' }} />
                                <label for="star5" title="text">5 stars</label>
                                <input type="checkbox" id="star4" name="rate" value="4" class="submit_star" {{ ($rate[0]->rating >= 4) ? 'checked="checked"' : '' }} />
                                <label for="star4" title="text">4 stars</label>
                                <input type="checkbox" id="star3" name="rate" value="3" class="submit_star" {{ ($rate[0]->rating >= 3) ? 'checked="checked"' : '' }} />
                                <label for="star3" title="text">3 stars</label>
                                <input type="checkbox" id="star2" name="rate" value="2" class="submit_star" {{ ($rate[0]->rating >= 2) ? 'checked="checked"' : '' }} />
                                <label for="star2" title="text">2 stars</label>
                                <input type="checkbox" id="star1" name="rate" value="1" class="submit_star" {{ ($rate[0]->rating >= 1) ? 'checked="checked"' : '' }} />
                                <label for="star1" title="text">1 star</label>
                            </div>
                        </div>

                        <!-- <div class="col-lg-1"></div> -->

                        <div class="col-lg-9">
                            <div class="portfolio-info">
                                <div class="row d-flex">
                                    <div class="col-auto col-centered">
                                        <div class="box-part bg-orange shadow subjects">
                                            <h6 class="text-white text-left font-weight-light">Year of Experience</h6>
                                            <div class="title mt-2">
                                                <p class="text-left text-white h4" style="padding-left: 15px !important;">{{ (empty($getdata[0]->year_of_experience)) ? '--' : $getdata[0]->year_of_experience }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-auto col-centered">
                                        <div class="box-part bg-sky shadow subjects">
                                            <h6 class="text-white text-left font-weight-light">Teaching to</h6>
                                            <div class="title mt-2">
                                                <p class="text-left text-white h4" style="padding-left: 15px !important;">
                                                    @foreach($getdata as $tutor)
                                                    <?php
//print_r($tutor);
                                                    $std_id = explode(',', $tutor->standard);
                                                    $std_name = explode(',', $tutor->std_name);
                                                    for ($j = 0; $j < count($std_name); $j++) {
                                                        ?>
                                                        {{ str_replace(",","-",$std_name[$j]) }} Std <br>
                                                    <?php } ?>
                                                    @endforeach
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-auto col-centered">
                                        <div class="box-part bg-purple shadow subjects">
                                            <h6 class="text-white text-left font-weight-light">Distance</h6>
                                            <div class="title mt-2">
                                                <?php
                                                if ((!empty($getdata[0]->distance))) {
                                                    if ($getdata[0]->distance > 500) {
                                                        $distance = 'Too far';
                                                    } else {
                                                        $distance = $getdata[0]->distance .' Km';
                                                    }
                                                } else {
                                                    $distance = '--';
                                                }
                                                ?>
                                                <p class="text-left text-white h4" style="padding-left: 15px !important;">{{ $distance }}</p>                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-auto col-centered">
                                        <div class="box-part bg-blue shadow subjects">
                                            <h6 class="text-white text-left font-weight-light">University</h6>
                                            <div class="title mt-2">
                                                <p class="text-left text-white h4" style="padding-left: 15px !important;">{{ (empty($getdata[0]->university)) ? '--' : $getdata[0]->university }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row gy-4 mt-2">
                                    <div class="col-lg-5 textField-bg rounded p-3 mt-4 m-3" id="subject">
                                        <h5 class="text-secondary mt-2">Monthly Fees</h5>
                                        @foreach($getdata as $tutor)
                                        <?php
//                                        print_r($tutor);
                                        $sub_id = explode(',', $tutor->subject);
                                        $t = explode(',', $tutor->sname);
                                        $f = explode(',', $tutor->monthly_fees);
                                        $ff = array_values(array_filter($f));
//                                        print_r($ff);
                                        for ($i = 0; $i < count($t); $i++) {
                                            ?>
                                            <div class="d-flex mt-3">
                                                <ul class="mr-auto p-2">
                                                    <li class="d-inline">
                                                        <fieldset class="fees">
                                                            <input type="checkbox"  class="checkmark" name="subject[]" value="{{ $sub_id[$i] }}" />
                                                            <label for="mobile"><span class="ml-3">{{ $t[$i] }}</span></label>
                                                        </fieldset>
                                                    </li>
                                                </ul>
                                                <div class="p-3 ml-auto mr-5 mr-sm-3"><h5 class="text-secondary">Rs.{{ $ff[$i] }} </h5></div>
                                                <input type="hidden" id="{{ $sub_id[$i] }}" name="fees[]" value="{{ $ff[$i] }}"/>
                                            </div>
                                            <?php
                                        }
                                        ?>

                                        @endforeach

                                        <hr style="border: 1px solid #fff !important;" />

                                        <p class="text-black-50">Lorem ipsum dolor sit amet, consectetur
                                            adipiscing elit. Quisque varius odio nibh ultrices tincidunt dapibus. Diam vulputate tincidunt lacus, volutpat sit nibh. 
                                        </p>

                                        <!--<button type="button" class="blue-btn w-75"  data-toggle="modal" data-target="#paymenttypeModal"><li class="d-inline">Pay Fees</li>-->
                                        </button>
                                    </div>
                                    <!-- <div class="col-lg-1"></div> -->
                                    <div class="col-lg-6">
                                        <div class="textField-bg rounded p-3">
                                            <h5 class="text-secondary mt-2">Contact Information</h5>
                                            <div class="p-2 mt-3">
                                                <div class="d-flex flex-row mb-2">
                                                    <div class="p-2"><i class="bi bi-envelope-fill h4 text-lighter"></i></div>
                                                    <input type="hidden" value="{{ $getdata[0]->email }}" name="t_email" id="t_email">
                                                    <div class="p-2 h5 text-dark font-weight-light email_css h-auto"><span>{{ $getdata[0]->email }}</span></div>
                                                </div>
                                                @if(empty($getdata[0]->mobile_no))

                                                @else
                                                <div class="d-flex flex-row">
                                                    <div class="p-2"><i class="bi bi-telephone-fill h4 text-lighter"></i></div>
                                                    <div class="p-2 h5 text-dark font-weight-light email_css">{{ $getdata[0]->mobile_no }}</div>
                                                </div>
                                                @endif
                                            </div>
                                        </div>

                                        <!-- availability -->
                                        <div class="textField-bg rounded p-3 mt-4">
                                            <!-- online offline radio group -->
                                            <div class="text-left mt-3 tution-type" id="tuition">
                                                <h5 class="text-secondary mt-2">Tuition Type</h5>
                                                @if($getdata[0]->tuition_type == '1')
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input"  type="radio" name="tuition_type" id="inlineRadio1" value="1">
                                                    <label class="form-check-label" for="inlineRadio1">Online Tuition</label>
                                                </div>
                                                @elseif($getdata[0]->tuition_type == '2')
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="tuition_type" id="inlineRadio2" value="2">
                                                    <label class="form-check-label" for="inlineRadio2">Offline Tuition</label>
                                                </div>
                                                @elseif($getdata[0]->tuition_type == '3')
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="tuition_type" id="inlineRadio1" value="1">
                                                    <label class="form-check-label" for="inlineRadio1">Online Tuition</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="tuition_type" id="inlineRadio2" value="2">
                                                    <label class="form-check-label" for="inlineRadio2">Offline Tuition</label>
                                                </div>
                                                @endif
                                            </div>

                                            <hr style="border: 1px solid orange !important;" />
                                            <h5 class="text-secondary mt-1">Hours of Availability</h5>
                                            <div class="p-2 mt-3" id="hours">
                                                <p class="text-lighter font-weight-light">Morning Hours</p>
                                                <?php
                                                $string = $getdata[0]->m_hour;
                                                $string_id = $getdata[0]->m_hours;
                                                $str_arr = explode(",", $string);
                                                $hour_id = explode(",", $string_id);
                                                ?>
                                                @for ($i = 0; $i < count($str_arr); $i++)
                                                <span class="button-checkbox">
                                                    <button type="button" class="btn" data-color="primary">{{ $str_arr[$i] }}</button>
                                                    <input type="checkbox" class="hidden" name="m_hours[]" value="{{ $hour_id[$i] }}" />
                                                </span>
                                                @endfor
                                                <hr style="border: 1px solid white !important;" />

                                                <p class="text-lighter font-weight-light">Afternoon Hours</p>
                                                <?php
                                                $string = $getdata[0]->a_hour;
                                                $string_id = $getdata[0]->a_hours;
                                                $str_arr = explode(",", $string);
                                                $hour_id = explode(",", $string_id);
                                                ?>
                                                @for ($i = 0; $i < count($str_arr); $i++)
                                                <span class="button-checkbox">
                                                    <button type="button" class="btn" data-color="primary">{{ $str_arr[$i] }}</button>
                                                    <input type="checkbox" class="hidden" name="a_hours[]" value="{{ $hour_id[$i] }}" />
                                                </span>
                                                @endfor
                                            </div>
                                        </div>

                                        <div class="d-flex justify-content-end mt-3">
                                            <button type="button" class="blue-btn w-100" onclick="request_tutor();"><li class="d-inline">Send Request</li>
                                                <li class="d-inline p-2"><i class="bi bi-cursor h5"></i></li>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section><!-- End Details Section -->

            <div class="modal fade" id="requestModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content p-5 top-50 shadow rounded-modal border-0">
                        <div class="">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="close_model()">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <svg class="checkmark1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52">
                            <circle class="checkmark__circle" cx="26" cy="26" r="25" fill="none"/>
                            <path class="checkmark__check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8"/>
                            </svg>
                            <p class="h5 text-center text-secondary">Request Sent Succesfully!</p>
                        </div>
                    </div>
                </div>
            </div>

        </main><!-- End #main -->

        <!-- ======= Footer ======= -->
        @include('footer')

        <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
        <script src="{{ asset('public/assets/js/jquery.min.js') }}"></script>
        <script type="text/javascript">
                                $(function () {
                                    $('.button-checkbox').each(function () {
                                        // Settings
                                        var $widget = $(this),
                                                $button = $widget.find('button'),
                                                $checkbox = $widget.find('input:checkbox'),
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

        <link href="{{ asset('public/assets/css/stackpath.css') }}" rel="stylesheet">
        <script src="{{ asset('public/assets/js/stackpath.js') }}"></script>


        <!-- Template Main JS File -->
        <script src="{{ asset('public/swiper/swiper.min.js') }}"></script>
        <script src="{{ asset('public/assets/js/main.js') }}"></script>
        <!-- Vendor JS Files -->
        <script src="{{ asset('public/assets/vendor/bootstrap/js/bootstrap.bundle.js') }}"></script>
        <script src="{{ asset('public/assets/vendor/aos/aos.js') }}"></script>
        <script src="{{ asset('public/assets/vendor/php-email-form/validate.js') }}"></script>
        <script src="{{ asset('public/assets/vendor/swiper/swiper-bundle.min.js') }}"></script>
        <script src="{{ asset('public/assets/vendor/purecounter/purecounter.js') }}"></script>
        <script src="{{ asset('public/assets/vendor/isotope-layout/isotope.pkgd.min.js') }}"></script>
        <script src="{{ asset('public/assets/vendor/glightbox/js/glightbox.min.js') }}"></script>
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
        <script type="text/javascript">
            $('#requestModal').on('shown.bs.modal', function () {
                $('#requestModal').trigger('focus')
            })
        </script>
        <script>
            $(window).on('load', function () {
                $('.loader').fadeOut();
            });
        </script>
        <script>
            function close_model() {
                $('#requestModal').modal('hide');
                window.location.href = window.location.href
            }
            $.ajaxSetup({

                headers: {

                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

                }

            })
            function request_tutor() {
                if ($('#subject input:checkbox').filter(':checked').length < 1) {
                    alert("Please Check at least one Subject");
                    return false;
                }
                if ($('#tuition input:radio').filter(':checked').length < 1) {
                    alert("Please Check at least one Tuition Type");
                    return false;
                }
                if ($('#hours input:checkbox').filter(':checked').length < 1) {
                    alert("Please Check at least one Hours");
                    return false;
                }
                var subject = document.getElementsByName('subject[]');
                var tutor = document.getElementById('tutor_name').value;
                var tuition_type = $("input:radio[name=tuition_type]:checked").val();
                var vals = "";
                var sub_fees = new Array();
                for (var i = 0, n = subject.length; i < n; i++)
                {
                    if (subject[i].checked)
                    {
                        vals += subject[i].value + ",";
                        var fees = document.getElementById(subject[i].value).value;
                        sub_fees.push(fees);
                        var str = sub_fees.join(",");
                    }
                }
                var m_hours = document.getElementsByName('m_hours[]');
                var m_hour = "";
                for (var i = 0, n = m_hours.length; i < n; i++)
                {
                    if (m_hours[i].checked)
                    {
                        m_hour += m_hours[i].value + ",";
                    }
                }
                var a_hours = document.getElementsByName('a_hours[]');
                var a_hour = "";
                for (var i = 0, n = a_hours.length; i < n; i++)
                {
                    if (a_hours[i].checked)
                    {
                        a_hour += a_hours[i].value + ",";
                    }
                }
                var dataString = 'subject=' + vals + '&fees=' + str + '&tutor_name=' + tutor + '&tuition_type=' + tuition_type + '&m_hours=' + m_hour + '&a_hours=' + a_hour;
                $.ajax({
                    url: "<?php echo URL('request_tutor') ?>",
                    type: "post",
                    data: dataString,
                    cache: false,
                    success: function (data) {
//                        alert(data);
                        if (data == 1) {
                            $('#requestModal').modal('show');
                        } else {
                            alert('Please..!!Select Subject..');
                        }
                    }
                });
            }

            $(document).on('click', '.submit_star', function () {
                var rating_data = 0;
                rating_data = $(this).val();
                var t_email = document.getElementById('t_email').value;

                var dataString = 'rating=' + rating_data + '&t_email=' + t_email;
                $.ajax({
                    url: "<?php echo URL('update_rating') ?>",
                    type: "post",
                    data: dataString,
                    cache: false,
                    success: function (data) {
                        if (data == '1') {
                            alert('Rate Updated..!!');
                            location.reload();
                        }
                    }
                });

            });
        </script>
    </body>

</html>