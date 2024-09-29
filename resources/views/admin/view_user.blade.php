<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>View User</title>

        <!-- Custom fonts for this template-->
        <link href="{{ asset('public/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">

        <!-- Page level plugin CSS-->
        <link href="{{ asset('vendor/datatables/dataTables.bootstrap4.css') }}" rel="stylesheet">
        <link href="{{ asset('public/vendor/datatables/buttons.bootstrap4.min.css') }}" rel="stylesheet">
        <!-- Custom styles for this template-->
        <link href="{{ asset('public/css/sb-admin.css') }}" rel="stylesheet">
        <link href="{{ asset('public/css/bootstrap3-wysihtml5.min.css') }}" rel="stylesheet">
        <link href="{{ asset('public/js/select2/css/select2.min.css') }}" rel="stylesheet">
    </head>

    <body id="page-top">

        @include('topbar')
        <div id="wrapper">

            <!-- Sidebar -->
            @include('sidebar')
            <div id="content-wrapper">

                <div class="container-fluid">

                    <!-- Breadcrumbs-->
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="">View User</a>
                        </li>

                    </ol>

                    <!-- Icon Cards-->
                    <div class="card mb-3">
                        <div class="card-header">
                            <i class="fas fa-table"></i>&nbsp;View User</div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>

                                            <th>#</th>
                                            <th>Email ID</th>
                                            <th>Name</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                        $i = 1;
                                        @endphp
                                        @foreach ($getdata as $vote)
                                            <tr>
                                                <td>{{ $i }}</td>
                                                <td>{{ $vote->email_id }}</td>
                                                <td>{{ $vote->firstname . " " . $vote->lastname }}</td>
                                                <td>
                                                    @if ($vote->status == 'true')
                                                        <label class='switch'><input type='checkbox' name='status' switch='none' data-status='false'  id="{{ $vote->id }}" onclick='changeStatus(this.id);' checked><span class='slider round'></span></lable>";
                                                    @else
                                                        <label class='switch'><input type='checkbox' name='status' switch='none' data-status='true'  id="{{ $vote->id }}" onclick='changeStatus(this.id);' ><span class='slider round'></span></lable>";
                                                    @endif
                                                </td>
                                            </tr>
                                        @php
                                        $i++;
                                        @endphp
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>


                </div>
                <!-- /.container-fluid -->

                <!-- Sticky Footer -->
                @include('footer')
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

        <script src="{{ asset('public/js/datatables.init.js') }}"></script>
        <!-- Custom scripts for all pages-->
        <script src="{{ asset('public/js/sb-admin.min.js') }}"></script>

        <!-- Demo scripts for this page-->
        <script src="{{ asset('public/js/demo/datatables-demo.js') }}"></script>
        <script src="{{ asset('public/js/select2/select2.min.js') }}"></script>
        <script src="{{ asset('public/js/nav-heighlight.js') }}"></script>
        <script>
function changeStatus(cid) {
//    alert($("#" + cid).data('status'));
    $.ajax({
        url: "\changestatus",
        type: "POST",
        data: {
            "_token": "{{ csrf_token() }}",
            cid: cid,
            status: $("#" + cid).data('status'),
            action: "changeStatus"
        },
//        dataType: "json",
        success: function (data) {
//            alert(data);
            if (data == 1) {
                alert("sucess");
                window.location.reload();
            } else {
                alert("fail");
            }
        },

    });
}
        </script>
    </body>

</html>
