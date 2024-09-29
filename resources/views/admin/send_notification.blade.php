<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Send Notification</title>
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
                            <a href="">Send Notification</a>
                        </li>

                    </ol>

                    <!-- Icon Cards-->
                    <div class="row">
                        <div class="col-xl-10">
                            <form action="{{ URL('admin/sendnotification') }}" method="post" enctype="multipart/form-data">
                                <div class="form-group row">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">Select Type</label>
                                    <div class="col-sm-10">
                                        <select type="text" class="form-control select2 chosen" id = "type" name = "type" required="" onchange="ChangeType()">
                                            <option value="">Select Type</option>
                                            <option value="tutor">Tutor</option>
                                            <option value="student">Student</option>
                                        </select>
                                    </div>
                                </div>
                                <input name="_token" type="hidden" value="{{ csrf_token() }}"/>
                                <div class="form-group row">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">title</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id = "title" name = "title" placeholder="Title" required=""/>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">Message</label>
                                    <div class="col-sm-10">
                                        <textarea type="text" class="form-control" id = "name" name = "message" placeholder="Message"  required=""></textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">Select User</label>
                                    <div class="col-sm-10">
                                        <select type="text" class="form-control select2 chosen" id = "user_id" name = "user_id[]" required="" multiple="">
                                            
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">  
                                    <div class="col-sm-2"> </div>
                                    <div class="col-sm-10">
                                        <button  type="submit" id='submit-button' class="btn btn-primary btn-block w-md waves-effect waves-light">Send Notification</button>
                                    </div>
                                </div>
                                <div class="form-group row" id="Message">  
                                    <div class="col-sm-2"> </div>
                                    <div class="col-sm-10 text-center">
                                        <?php
                                        if (session()->has('message')) {

                                            echo session()->get('message');
                                        }
                                        ?>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <hr>
                    <div class="card mb-3">
                        <div class="card-header">
                            <i class="fas fa-table"></i>&nbsp;View Notification</div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>title</th>
                                            <th>Message</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $i=1;  @endphp
                                        @foreach($notification as $datas)
                                        <tr>
                                            <td>{{ $i }}</td>
                                            <td>{{ $datas->title }}</td>
                                            <td>{{ $datas->message }}</td>

                                        </tr>
                                        @php $i++;  @endphp
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>

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
        <script type="text/javascript">
                                            $.ajaxSetup({

                                                headers: {

                                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

                                                }

                                            });
                                            $(document).ready(function () {
                                                $('.chosen').select2();
                                            });
                                            function ChangeType() {
                                                var type = document.getElementById('type').value;
                                                $.ajax({
                                                    url: "<?php echo URL('admin/change_type') ?>",
                                                    type: "POST",
                                                    data: {
                                                        type: type
                                                    },
                                                    dataType: "html",
                                                    success: function (data) {
//                                                        alert(data);
                                                        $("#user_id").html(data);
                                                    }
                                                });
                                            }
        </script>
    </body>
</html>
