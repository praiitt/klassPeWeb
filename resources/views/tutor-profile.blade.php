<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta content="width=device-width, initial-scale=1.0" name="viewport">

        <title>Tutor Finder</title>
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
        <meta name="csrf-token" content="{{ csrf_token() }}" />


    </head>

    <body class="bg-blue">
        <div class="loader"></div>
        <!-- ======= Header ======= -->
        <header id="header" class="header fixed-top container-fluid text-white mt-3">
            <div class="d-flex align-items-center justify-content-between container">
                <a href="{{ url('/') }}"><span class="menu" onclick=""><i class="bi bi-chevron-left h1 text-white"></i></span></a>
                <h2>Tutor Detail</h2>

                <div class="d-flex flex-row-reverse">
                    <a class="nav-link p-2" href="{{ url('Logout') }}"><i class="bi bi-power text-white h2"></i></a>
                    <a class="nav-link p-2" href="{{ url('Notification') }}"><i class="bi bi-bell-fill text-white h2"></i></a>

                </div>
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

                                    <img src="{{ (isset($getdata)) ? ((empty($getdata[0]->image)) ? asset('assets/img/avatar.png') : asset($getdata[0]->image)) : asset('assets/img/avatar.png') }}" id="profileImage" height="200px" width="200px" class="shadow bg-white rounded-circle" alt="">
                                    <input id="imageUpload" type="file" name="profile_photo" placeholder="Photo" required="" onchange="tutor_image()" capture>

                                </div>
                                <p id="uploaded_image"></p>
                            </div>
                            <div class="p-2 h6 text-secondary font-weight-light mt-3"><span>{{ session()->get('web_username')}}</span></div>
                            <div class="rate">
                                <input type="checkbox" id="star5" name="rate" value="5" class="submit_star" {{ ($rate[0]->rating >= 5) ? 'checked="checked"' : '' }} disabled="disabled"/>
                                <label for="star5" title="text">5 stars</label>
                                <input type="checkbox" id="star4" name="rate" value="4" class="submit_star" {{ ($rate[0]->rating >= 4) ? 'checked="checked"' : '' }} disabled="disabled"/>
                                <label for="star4" title="text">4 stars</label>
                                <input type="checkbox" id="star3" name="rate" value="3" class="submit_star" {{ ($rate[0]->rating >= 3) ? 'checked="checked"' : '' }} disabled="disabled"/>
                                <label for="star3" title="text">3 stars</label>
                                <input type="checkbox" id="star2" name="rate" value="2" class="submit_star" {{ ($rate[0]->rating >= 2) ? 'checked="checked"' : '' }} disabled="disabled"/>
                                <label for="star2" title="text">2 stars</label>
                                <input type="checkbox" id="star1" name="rate" value="1" class="submit_star" {{ ($rate[0]->rating >= 1) ? 'checked="checked"' : '' }} disabled="disabled"/>
                                <label for="star1" title="text">1 star</label>
                            </div>
                            <center><button type="button" class="blue-btn w-100 mb-1" data-toggle="modal" data-target="#changePasswordModal" data-whatever="">Change Password</button></center>

                        </div>

                        <div class="col-lg-9">
                            <div class="portfolio-info">
                                <div class="row d-flex">
                                    <form class="mt-3 textField-bg rounded p-5 col-lg-12">
                                        <center>
                                            <div class="form-group input-group w-100">
                                                <input type="text" class="form-control bg-white border-0 p-3 mb-2 zIndex-1 text-left" id="username" placeholder="Username" value="{{ (isset($getdata)) ? $getdata[0]->username : '' }}">
                                            </div>

                                            <div class="form-group input-group w-100">
                                                <input type="text" class="form-control bg-white border-0 p-3 mb-2 zIndex-1" id="mob_no" placeholder="Mobile Number" value="{{ (isset($getdata)) ? $getdata[0]->mobile_no : '' }}">
                                            </div>

                                            <div class="form-group input-group w-100">
                                                <input type="text" class="form-control bg-white border-0 p-3 mb-2 zIndex-1" id="location" placeholder="Location" value="{{ (isset($getdata)) ? $getdata[0]->location : '' }}">
                                            </div>

                                            <div class="form-group input-group w-100">
                                                <input type="text" class="form-control bg-white border-0 p-3 zIndex-1" id="year_of_experience" placeholder="Year of Experience" value="{{ (isset($getdata)) ? $getdata[0]->year_of_experience : '' }}">
                                            </div>

                                            <!-- online offline radio group -->
                                            <div class="text-left mt-3 tution-type">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="tuition_type" id="inlineRadio1" value="1" {{ (isset($getdata)) ? ($getdata[0]->tuition_type == '1' ? 'checked' : '') : '' }} >
                                                    <label class="form-check-label" for="inlineRadio1">Online Tution</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="tuition_type" id="inlineRadio2" value="2" {{ (isset($getdata)) ? ($getdata[0]->tuition_type == '2' ? 'checked' : '') : '' }}>
                                                    <label class="form-check-label" for="inlineRadio2">Offline Tution</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="tuition_type" id="inlineRadio3" value="3" {{ (isset($getdata)) ? ($getdata[0]->tuition_type == '3' ? 'checked' : '') : '' }}>
                                                    <label class="form-check-label" for="inlineRadio3">Both</label>
                                                </div>
                                            </div>
                                        </center>
                                    </form>
                                </div>
                                <div class="row gy-4 mt-2">
                                    <div class="col-lg-6 textField-bg rounded p-3 mt-4 m-3">
                                        <h5 class="text-secondary mt-2">Subjects</h5>
                                        <?php
                                        $i = 0;
                                        $subj = $getdata[0]->subject;

                                        $myString1 = !empty($getdata[0]->monthly_fees) ? $getdata[0]->monthly_fees : '0';
                                        $myArray1 = explode(',', $myString1);

                                        $fess = '0';
                                        ?>
                                        @for($i=0; $i< count($subject); $i++)
                                        <?php
                                        $myString = $subj;
                                        $myArray = explode(',', $myString);
                                        $arr = array_flip($myArray);
                                        ?>
                                        <div class="d-flex mt-3 mb-n3">
                                            <ul class="mr-auto">
                                                <li class="d-inline">
                                                    <fieldset class="fees">
                                                        @if(isset($getdata))
                                                        <?php
                                                        ?>
                                                        <input type="checkbox" id="mobile" class="checkmark" name="subject[]" <?= (in_array($subject[$i]->id, $myArray)) ? 'checked="checked"' : '' ?> value="{{ $subject[$i]->id }}"/>
                                                        <label for="mobile"><span class="ml-3">{{ $subject[$i]->subject_name }}</span></label>
                                                        @else
                                                        <input type="checkbox" id="mobile" class="checkmark" name="subject[]" value="{{ $subject[$i]->id }}"/>
                                                        <label for="mobile"><span class="ml-3">{{ $subject[$i]->subject_name }}</span></label>
                                                        @endif
                                                    </fieldset>
                                                </li>
                                            </ul>

                                            <div class="form-group input-group w-25">
                                                <input type="text" class="form-control bg-white border-0 zIndex-1 fees" placeholder="Fees" id="fees" min="1" name="fees[]" value="<?= (in_array($subject[$i]->id, $myArray)) ? $myArray1[$arr[$subject[$i]->id]] : '' ?>">
                                            </div>
                                        </div>
                                        @endfor

                                    </div>
                                    <!-- <div class="col-lg-1"></div> -->
                                    <div class="col-lg-5">
                                        <div class="textField-bg rounded p-3">
                                            <h5 class="text-secondary mt-2">Standard</h5>
                                            <div class="mt-3">
                                                @foreach($standard as $std)
                                                @if(isset($getdata))
                                                <?php
                                                $myString = $getdata[0]->standard;
                                                $myArray = explode(',', $myString);
                                                ?>
                                                <span class="button-checkbox">
                                                    <button type="button" class="btn" data-color="primary">{{ $std->std }}</button>
                                                    <input type="checkbox" class="hidden" name="std[]" value="{{ $std->id }}" <?= (in_array($std->id, $myArray)) ? 'checked="checked"' : '' ?>/>
                                                </span>
                                                @else
                                                <span class="button-checkbox">
                                                    <button type="button" class="btn" data-color="primary">{{ $std->std }}</button>
                                                    <input type="checkbox" class="hidden" name="std[]" value="{{ $std->id }}"/>
                                                </span>
                                                @endif
                                                @endforeach

                                            </div>
                                        </div>

                                        <!-- Hours of Availability -->
                                        <div class="textField-bg rounded p-3 mt-4">
                                            <h5 class="text-secondary mt-2">Hours of Availability</h5>
                                            <div class="mt-3">
                                                <p class="text-lighter font-weight-light">Morning Hours</p>
                                                @foreach($m_hours as $hour)
                                                @if(isset($getdata))
                                                <?php
                                                $myString = $getdata[0]->m_hours;
                                                $myArray = explode(',', $myString);
                                                ?>
                                                <span class="button-checkbox">
                                                    <button type="button" class="btn" data-color="primary">{{ $hour->hours }}</button>
                                                    <input type="checkbox" class="hidden" name="m_hours[]" value="{{ $hour->id }}" <?= (in_array($hour->id, $myArray)) ? 'checked="checked"' : '' ?>/>
                                                </span>
                                                @else
                                                <span class="button-checkbox">
                                                    <button type="button" class="btn" data-color="primary">{{ $hour->hours }}</button>
                                                    <input type="checkbox" class="hidden" name="m_hours[]" value="{{ $hour->id }}"/>
                                                </span>
                                                @endif
                                                @endforeach
                                                <hr style="border: 1px dashed white !important;" />
                                                <p class="text-lighter font-weight-light">Afternoon Hours</p>
                                                @foreach($a_hours as $hour)
                                                @if(isset($getdata))
                                                <?php
                                                $myString = $getdata[0]->a_hours;
                                                $myArray = explode(',', $myString);
                                                ?>
                                                <span class="button-checkbox">
                                                    <button type="button" class="btn" data-color="primary">{{ $hour->hours }}</button>
                                                    <input type="checkbox" class="hidden" name="a_hours[]" value="{{ $hour->id }}" <?= (in_array($hour->id, $myArray)) ? 'checked="checked"' : '' ?>/>
                                                </span>
                                                @else
                                                <span class="button-checkbox">
                                                    <button type="button" class="btn" data-color="primary">{{ $hour->hours }}</button>
                                                    <input type="checkbox" class="hidden" name="a_hours[]" value="{{ $hour->id }}"/>
                                                </span>
                                                @endif
                                                @endforeach

                                            </div>
                                        </div>
                                    </div>

                                    <center><button type="button" id="submit" class="orange-btn w-75" onclick="tutor_update();">Update</button></center>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section><!-- End Details Section -->

            <div class="modal fade" id="requestModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content p-5 shadow rounded-modal border-0">
                        <div class="">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
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
            <!--Change Password Model-->
            <div class="modal fade mt-5" id="changePasswordModal"  role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog mt-5" role="document">
                    <div class="modal-content bg-blue rounded-modal shadow p-3" style="margin-top: 4rem;">
                        <center>
                            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close" onClick="window.location.reload();">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <h3 class="text-white mb-5 mt-3" id="exampleModalLabel">Change Password</h3>
                        </center>
                        <div class="bg-white top-rounded pt-4">
                            <div class="modal-body bg-white top-rounded mt-3">
                                <form class="mt-3" id="forgot_form"><center>
                                        <div class="form-group input-group w-75">
                                            <input type="password" class="form-control textField-bg border-0 p-3 mb-2 zIndex-1" id="password" placeholder="Password" required="">
                                        </div>
                                        <p class="text-danger" id="change_pass"></p>
                                    </center>
                                    <center><button type="button" id="change_btn" class="blue-btn w-75" onclick="change_pass()">Update</button></center>
                                </form>
                            </div>
                        </div>  
                    </div>
                </div>
            </div>
        </main><!-- End #main -->

        <!-- ======= Footer ======= -->
        @include('footer')

        <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

        <script src="{{ asset('assets/js/jquery.min.js') }}"></script>

        <link href="{{ asset('assets/css/stackpath.css') }}" rel="stylesheet">
        <script src="{{ asset('assets/js/stackpath.js') }}"></script>


        <!-- Template Main JS File -->
        <script src="{{ asset('swiper/swiper.min.js') }}"></script>
        <script src="{{ asset('assets/js/main.js') }}"></script>
        <!-- Vendor JS Files -->
        <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.js') }}"></script>
        <script src="{{ asset('assets/vendor/aos/aos.js') }}"></script>
        <script src="{{ asset('assets/vendor/php-email-form/validate.js') }}"></script>
        <script src="{{ asset('assets/vendor/swiper/swiper-bundle.min.js') }}"></script>
        <script src="{{ asset('assets/vendor/purecounter/purecounter.js') }}"></script>
        <script src="{{ asset('assets/vendor/isotope-layout/isotope.pkgd.min.js') }}"></script>
        <script src="{{ asset('assets/vendor/glightbox/js/glightbox.min.js') }}"></script>
        <!-- Firebase App (the core Firebase SDK) is always required and must be listed first -->
        <script src="https://www.gstatic.com/firebasejs/8.6.1/firebase-app.js"></script>
        <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/firebase/8.2.2/firebase-app.min.js"></script>-->
        <!-- If you enabled Analytics in your project, add the Firebase SDK for Analytics -->
        <script src="https://www.gstatic.com/firebasejs/8.6.1/firebase-analytics.js"></script>

        <!-- Add Firebase products that you want to use -->
        <script src="https://www.gstatic.com/firebasejs/8.6.1/firebase-auth.js"></script>
        <script src="https://www.gstatic.com/firebasejs/8.6.1/firebase-firestore.js"></script>
        <script src="{{ asset('js/firebase_config.js') }}"></script>

        <script type="text/javascript">
                                        $('#requestModal').on('shown.bs.modal', function () {
                                            $('#requestModal').trigger('focus')
                                        })
                                        $('.fees').keypress(function (e) {
                                            if (this.value.length == 0 && e.which == 48) {
                                                alert("Please! Zero fees not Allowed..!!");
                                                return false;
                                            }
                                        });
        </script>
        <script>
            $(window).on('load', function () {
                $('.loader').fadeOut();
            });
        </script>
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
        <script>
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
            function tutor_image() {
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
                        url: "<?php echo URL('tutor_image') ?>",
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
            $.ajaxSetup({

                headers: {

                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

                }

            });
            function tutor_update() {
                var username = document.getElementById('username').value;
                var mob_no = document.getElementById('mob_no').value;
                var location = document.getElementById('location').value;
                var year_of_experience = document.getElementById('year_of_experience').value;
                var subject = document.getElementsByName('subject[]');
                var tuition_type = $("input:radio[name=tuition_type]:checked").val();
                var vals = "";
                for (var i = 0, n = subject.length; i < n; i++)
                {
                    if (subject[i].checked)
                    {
                        vals += subject[i].value + ",";
                    }
                }
                var std = document.getElementsByName('std[]');
                var val = "";
                for (var i = 0, n = std.length; i < n; i++)
                {
                    if (std[i].checked)
                    {
                        val += std[i].value + ",";
                    }
                }
                var fees = document.getElementsByName('fees[]');
                var val1 = "";
                for (var i = 0, n = fees.length; i < n; i++)
                {
                    if (fees[i].value != '') {
                        val1 += fees[i].value + ',';
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
				
				var MHours_count = document.querySelectorAll('input[name="m_hours[]"]:checked').length;
                var AHours_count = document.querySelectorAll('input[name="a_hours[]"]:checked').length;

                var subject = document.querySelectorAll('input[name="subject[]"]:checked').length;
				
//                alert(hour);
                var fees = document.getElementsByName('fees[]');
                var dataString = 'username=' + username + '&mob_no=' + mob_no + '&location=' + location + '&year_of_experience=' + year_of_experience + '&subject=' + vals + '&std=' + val + '&fees=' + val1 + '&tuition_type=' + tuition_type + '&m_hours=' + m_hour + '&a_hours=' + a_hour;
                if (subject >= 1) {
                    if (MHours_count >= 1 || AHours_count >= 1) {
                        $.ajax({
                            url: "<?php echo URL('tutor_update') ?>",
                            type: "post",
                            data: dataString,
                            cache: false,
                            success: function (data) {
                                if (data == 1) {
                                    alert("please check subject checkbox and fill up their fees.");

                                } else {
                                    alert("Update Successfully..!!");
                                    window.location.reload(true);
                                }
                            }
                        });
                    } else {
                        alert("Please select at least one Hours of Availability");
                    }
                } else {
                    alert("Please select at least one Subject");
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
        <script>
            function change_pass() {
                var password = document.getElementById('password').value;

                firebase.auth().onAuthStateChanged(function (user) {
                    if (user) {
                        // User is available now
                        var user = firebase.auth().currentUser;
                        var newPassword = password;

                        user.updatePassword(newPassword).then(function () {
                            // Update successful.
                           alert("Your Password is Changed..!!");
                           location.reload();
                           
                        }).catch(function (error) {
                            // An error happened.
                            var errorCode = error.code;
                            var errorMessage = error.message;
                            alert(errorMessage)
                        });
                    } else {
                        console.log("no");
                        // No user is signed in.
                    }
                });
            }
        </script>
    </body>

</html>
