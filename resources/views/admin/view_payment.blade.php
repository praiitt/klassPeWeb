<!DOCTYPE html>
<html lang="en">
    <!-- Head-->
    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="In This Web Inventory(Web Apps) in Admin can create multiple roles & permissions for users. ">
        <meta name="author" content="Web Inventory">
        <meta http-equiv="X-Frame-Options" content="deny">
        <meta http-equiv="X-XSS-Protection" content="0">
        <meta content="text/html; charset=UTF-8; X-Content-Type-Options=nosniff" http-equiv="Content-Type" />
        <title>Payment List</title>

        <!-- Custom fonts for this template-->
        <link href="{{ asset('public/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ asset('public/vendor/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
        <!-- Page level plugin CSS-->
        <link href="{{ asset('public/vendor/datatables/dataTables.bootstrap4.css') }}" rel="stylesheet">
        <link href="{{ asset('public/vendor/datatables/buttons.bootstrap4.min.css') }}" rel="stylesheet">
        <!-- Custom styles for this template-->
        <link href="{{ asset('public/css/sb-admin.css') }}" rel="stylesheet">

    </head>
    <!-- //Head-->
    <body id="page-top">
        <!-- Topbar -->
        @include('admin/topbar')
        <div id="wrapper">

            <!-- Sidebar -->
            @include('admin/sidebar')
            <!-- content-wrapper -->
            <div id="content-wrapper">

                <div class="container-fluid mb-5">

                    <!-- Breadcrumbs-->
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="">Student Payment List</a>
                        </li>

                    </ol>
                    <!-- Icon Cards-->
                    <div class="card mb-5 mt-5">
                        <div class="card-header">
                            <i class="fas fa-table"></i>&nbsp;View Payment List
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Tutor Email</th>
                                            <th>Student Email</th>
                                            <th>Amount</th>
                                            <th>Transaction ID</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
//                                        $userAgent = $_SERVER['HTTP_USER_AGENT'];
//                                        
//
//                                        print_r($userAgent);
                                        ?>
                                        @if(!empty($getdata))
                                        @php
                                        $i = 1;
                                        @endphp
                                        @foreach ($getdata as $request)
                                        <tr>
                                            <td>{{ $i }}</td>
                                            <td>{{ $request->tutor_email }}</td>
                                            <td>{{ $request->student_email }}</td>
                                            <td>{{ $request->amount }}</td>
                                            <td>{{ $request->transaction_id }}</td>
                                        </tr>
                                        @php
                                        $i++;
                                        @endphp
                                        @endforeach
                                        @endif

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

        <script src="{{ asset('public/js/datatable-buttons.js') }}"></script>
        <!-- Custom scripts for all pages-->
        <script src="{{ asset('public/js/sb-admin.min.js') }}"></script>
        <script src="{{ asset('public/vendor/chart.js/Chart.min.js') }}"></script>

        <!-- Demo scripts for this page-->
        <script src="{{ asset('public/js/demo/datatables-demo.js') }}"></script>
        <script src="{{ asset('public/vendor/select2/select2.min.js') }}"></script>
        <script src="{{ asset('public/js/nav-heighlight.js') }}"></script>
        <script src="{{ asset('public/js/datatables.init.js') }}"></script>
        <script>
//console.log(navigator.userAgent);

        </script>
    </body>

</html>
