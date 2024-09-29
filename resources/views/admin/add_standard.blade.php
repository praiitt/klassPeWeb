<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Standard</title>

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
                            <a href="">Standard</a>
                        </li>

                    </ol>

                    <form action="{{ (isset($getdata)) ? URL('admin/update_standard', $getdata[0]->id) : URL('admin/insert_standard') }}" method="post" enctype="multipart/form-data">
                        <input name="_token" type="hidden" value="{{ csrf_token() }}"/>
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-1 col-form-label">Standard</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id = "std" name = "std" placeholder="Standard" value="{{ (isset($getdata)) ? $getdata[0]->std : '' }}" required=""/>
                            </div>
                        </div>
                        <div class="form-group row">  
                            <div class="col-sm-2"> </div>
                            <div class="col-sm-10">
                                <button  type="submit" id='submit-button' class="btn btn-primary btn-block w-md waves-effect waves-light">{{ (isset($editdata)) ? 'Update' : 'Save' }}</button>
                            </div>
                        </div>
                    </form>
                    <!-- Icon Cards-->
                    <div class="card mb-3">
                        <div class="card-header">
                            <i class="fas fa-table"></i>&nbsp;View Standard

                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                        $i = 1;
                                        @endphp
                                        @foreach ($data as $datas)
                                        <tr>
                                            <td>{{ $i }}</td>
                                            <td>{{ $datas->std }}</td>
                                            <td><a class="btn btn-primary" href="{{ url('admin/edit_standard',$datas->id) }}">Edit</a>
                                                <a class="btn btn-danger text-white" href="{{ url('admin/delete_standard',$datas->id) }}" onclick="return confirm('Are you sure you want to delete this Standard?');">Delete</a>
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

</body>
</html>
