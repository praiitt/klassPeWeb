<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Setting</title>

        <!-- Custom fonts for this template-->
        <link href="{{ asset('public/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">

        <!-- Page level plugin CSS-->
        <link href="{{ asset('public/vendor/datatables/dataTables.bootstrap4.css') }}" rel="stylesheet">

        <!-- Custom styles for this template-->
        <link href="{{ asset('public/css/sb-admin.css') }}" rel="stylesheet">
        <meta name="csrf-token" content="{{ csrf_token() }}" />

    </head>

    <body id="page-top">

        @include('admin/topbar')

        <div id="wrapper">

            <!-- Sidebar -->
            @include('admin/sidebar')

            <div id="content-wrapper">

                <div class="container-fluid">

                    <!-- Breadcrumbs-->
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="">Setting</a>
                        </li>

                    </ol>
                    <div class="row">
                        <div class="col-xl-10">
                            <form action="" method="post" enctype="multipart/form-data">
                                <input name="_token" type="hidden" value="{{ csrf_token() }}"/>
                                <div class="form-group row">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">Notification Status</label>
                                    <div class="col-sm-4">
                                        <label class="switch">
                                            <?php
                                            if ($getdata[0]->notification_status == 'true') {
                                                echo "<input type='checkbox' name='notification_status' switch='none' data-status='false'  id=" . $getdata[0]->id . " onclick='changeStatus(this.id);' checked><span class='slider round'></span>";
                                            } else {
                                                echo "<input type='checkbox' name='notification_status' switch='none' data-status='true'  id=" . $getdata[0]->id . " onclick='changeStatus(this.id);' ><span class='slider round'></span>";
                                            }
                                            ?>
                                        </label>
                                    </div>
                                </div>
                            </form>
                            <form action="about_privacy" method="post" enctype="multipart/form-data">
                                <div class="form-group row">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">Distance</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id = "distance" name = "distance" placeholder="Subject Name" value="{{ (isset($getdata)) ? $getdata[0]->distance : '' }}" required=""/>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">Stripe Client Key</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id = "stripe_client_key" name = "stripe_client_key" placeholder="Stripe Client Key" value="{{ (isset($getdata)) ? $getdata[0]->stripe_client_key : '' }}" required=""/>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">Stripe Public Key</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id = "stripe_public_key" name = "stripe_public_key" placeholder="Stripe Public Key" value="{{ (isset($getdata)) ? $getdata[0]->stripe_public_key : '' }}" required=""/>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">Commission Percentage</label>
                                    <div class="col-sm-10">
                                        <input type="number" class="form-control" id = "percentage" name = "percentage" placeholder="Paid Percentage" value="{{ (isset($getdata)) ? $getdata[0]->percentage : '' }}" required=""/>
                                    </div>
                                </div>
                                <input name="_token" type="hidden" value="{{ csrf_token() }}"/>
                                <div class = "form-group row">
                                    <label for = "example-text-input" class = "col-sm-2 col-form-label">About Us</label>
                                    <div class="col-sm-10">
                                        <textarea name="about" id="elm1" class="form-control" placeholder="About Us">{{ (isset($getdata)) ? $getdata[0]->about : '' }}</textarea>
                                    </div>
                                </div>
                                <div class = "form-group row">
                                    <label for = "example-text-input" class = "col-sm-2 col-form-label">Privacy Policy</label>
                                    <div class="col-sm-10">
                                        <textarea name="privacy_policy" id="elm1" class="form-control" placeholder="Privacy Policy">{{ (isset($getdata)) ? $getdata[0]->privacy_policy : '' }}</textarea>
                                    </div>
                                </div>
                                <div class="form-group row">  
                                    <div class="col-sm-2"> </div>
                                    <div class="col-sm-10">
                                        <button id = "setting" class="btn btn-primary btn-block w-md waves-effect waves-light" type="submit">Submit</button>
                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>
                    <hr>
                </div>
                <!-- /.container-fluid -->

                <!-- Sticky Footer -->
                @include('admin/footer')

            </div>
            <!-- /.content-wrapper -->

        </div>
        <!-- /#wrapper -->


        <!-- Bootstrap core JavaScript-->
        <script src="{{ asset('public/vendor/jquery/jquery.min.js') }}"></script>
        <script src="{{ asset('public/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <!-- Core plugin JavaScript-->
        <script src="{{ asset('public/vendor/jquery-easing/jquery.easing.min.js') }}"></script>
        <!-- Page level plugin JavaScript-->
        <script src="{{ asset('public/vendor/datatables/jquery.dataTables.js') }}"></script>
        <script src="{{ asset('public/vendor/datatables/dataTables.bootstrap4.js') }}"></script>
        <!-- Custom scripts for all pages-->
        <script src="{{ asset('public/js/sb-admin.min.js') }}"></script>
        <!-- Demo scripts for this page-->
        <script src="{{ asset('public/js/demo/datatables-demo.js') }}"></script>
        <script src="{{ asset('public/vendor/select2/select2.min.js') }}"></script>
        <script src="{{ asset('public/js/sb-basic.js') }}"></script>
        <!-- Required datatable js -->
        <script src="{{ asset('public/vendor/datatables/jquery.dataTables.js') }}"></script>
        <script src="{{ asset('public/vendor/datatables/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('public/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
        <!-- Buttons examples -->
        <script src="{{ asset('public/vendor/datatables/dataTables.buttons.min.js') }}"></script>
        <script src="{{ asset('public/vendor/datatables/buttons.bootstrap4.min.js') }}"></script>
        <script src="{{ asset('public/vendor/datatables/jszip.min.js') }}"></script>
        <script src="{{ asset('public/vendor/datatables/pdfmake.min.js') }}"></script>
        <script src="{{ asset('public/vendor/datatables/vfs_fonts.js') }}"></script>
        <script src="{{ asset('public/vendor/datatables/buttons.html5.min.js') }}"></script>
        <script src="{{ asset('public/vendor/datatables/buttons.print.min.js') }}"></script>
        <script src="{{ asset('public/vendor/datatables/buttons.colVis.min.js') }}"></script>
        <!-- Responsive examples -->
        <script src="{{ asset('public/vendor/datatables/dataTables.responsive.min.js') }}"></script>
        <script src="{{ asset('public/vendor/datatables/responsive.bootstrap4.min.js') }}"></script>
        <script src="{{ asset('public/js/datatables.init.js') }}"></script>
        <script src="{{ asset('public/js/nav-heighlight.js') }}"></script>
        <script src="{{ asset('public/tinymce/tinymce.min.js') }}"></script>

        <script>
$.ajaxSetup({

    headers: {

        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

    }

});
function changeStatus(cid) {

    $.ajax({
        url: "<?php echo URL('admin/change_status') ?>",
        type: "POST",
        data: {
            cid: cid,
            notification_status: $("#" + cid).data('status')
        },
        dataType: "json",
        success: function (data) {
//            alert(data);
            if (data.status == true) {
                alert("Success");
                window.location.reload();
            } else {
                alert("fail");
            }
        },
        fail: function () {
            swal("Error!", "Error while performing operation!", "error");
        },
        error: function (data, status, jg) {
            swal("Error!", data.responseText, "error");
        }
    });
}

        </script>
        <script type="text/javascript">
            $(document).ready(function () {
                if ($("#elm1").length > 0) {
                    tinymce.init({
                        selector: "textarea#elm1",
                        theme: "modern",
                        height: 300,
                        plugins: [
                            "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
                            "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
                            "save table contextmenu directionality emoticons template paste textcolor"
                        ],
                        toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | print preview media fullpage | forecolor backcolor emoticons",
                        style_formats: [
                            {title: 'Bold text', inline: 'b'},
                            {title: 'Red text', inline: 'span', styles: {color: '#FF0000'}},
                            {title: 'Red header', block: 'h1', styles: {color: '#FF0000'}},
                            {title: 'Example 1', inline: 'span', classes: 'example1'},
                            {title: 'Example 2', inline: 'span', classes: 'example2'},
                            {title: 'Table styles'},
                            {title: 'Table row 1', selector: 'tr', classes: 'tablerow1'}
                        ]
                    });
                }
            });
        </script>
    </body>
</html>
