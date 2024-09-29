<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <style type='text/css'>
            body{
                font-size:15px; 
            }
            .container{
                width:500px;
                padding: 10px;
                line-height: 1.3;
                font-family: Verdana;
            } 
            .subhead{
                color: #434343;
            }
            span{
                color: #434343;
            }
            hr{
                border: 1px solid #00b99b;
            }
            .btn{
                color: #fff !important;
                background-color: #007bff;
                border-color: #007bff;
                display: block;
                width: 100%;
                height: 100%;
                cursor: pointer;
            }
        </style>
    </head>
    <body>
        <div class='container' style='width:600px;'>
            <form>
                <input name="_token" type="hidden" value="{{ csrf_token() }}"/>
                <table style='padding: 10px;border: 1px solid #d2d2d2; font-size: 17px;' width='100%' border='0' cellspacing='0' cellpadding='0'>
                    <tr> 
                        <td class='subhead'>
                            <h3><b><?php echo $data['subject']; ?></b></h3>
                            <p><b>Your Email:</b> <?php echo $data['email']; ?></p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <a href="{{ URL('forgot_password', $data['token'])}}" class="blue-btn" target="_blank">Reset Password</a>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </body>
</html>
