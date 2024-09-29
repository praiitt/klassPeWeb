<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Mail\Mailable;
use App\Http\Requests;
use App\TestEmail;
use Session;
use Validator;
use Auth;

class ForgotPassController extends Controller {

    function index($token) {
        return view('Forgot_password', ['token' => $token]);
    }

    function change_forgot_pass(Request $request) {
        $token = $request->input('token');
        $data = array(
            'password' => md5($request->input('password'))
        );
        $result = DB::table('users')->where('forgot_pass_token', $token)->update($data);
        return view('/index');
    }

}
