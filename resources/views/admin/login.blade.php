<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Login</title>

        <!-- Custom fonts for this template-->
        <link rel="stylesheet" href="{{ asset('public/vendor/fontawesome-free/css/all.min.css') }}" />
        <!-- Custom styles for this template-->
        <link rel="stylesheet" href="{{ asset('public/css/sb-admin.css') }}" />

    </head>

    <body class="bg-dark">

        <div class="container">
            <div class="card card-login mx-auto mt-5">
                <div class="card-header">Login</div>
                <div class="card-body">
                    <form method="post" action="{{ URL::to('admin/checklogin') }}">
                        <input name="_token" type="hidden" value="{{ csrf_token() }}"/>
                        <div class="form-group">
                            <div class="form-label-group">
                                <input type="text" id="inputEmail" class="form-control" name="username" placeholder="Email address" required="required" autofocus="autofocus">
                                <label for="inputEmail">Username</label>                                                
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-label-group">
                                <input type="password" id="inputPassword" class="form-control" name="password" placeholder="Password" required="required">
                                <label for="inputPassword">Password</label>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary btn-block">Login</button>
                        <div id="errormsg"><br>
                            <center><?php if (session()->has('message')) { ?>
                                <div class="alert alert-danger">
                                        <?php echo session()->get('message') ?>
                                    </div>
                                <?php } ?>
                            </center>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Bootstrap core JavaScript-->
        <script type="text/javascript" src="{{ asset('public/vendor/jquery/jquery.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('public/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

        <!-- Core plugin JavaScript-->
        <script type="text/javascript" src="{{ asset('public/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    </body>

</html>
