<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Session;
use Validator;
use Auth;

class RegisterController extends Controller {

    function index(Request $request) {
        if ($request->input('type') == 'true') {
            $type = 'student';
        } else {
            $type = 'tutor';
        }
        $data = array(
            'username' => $request->input('username'),
            'email' => $request->input('email'),
            'user_type' => 'normal',
//            'password' => md5($request->input('password')),
            'type' => $type,
        );
//Insert Data
        $result = DB::table('users')->insert($data);
        if ($result == 1) {
            echo json_encode(array("status" => TRUE, 'username' => $request->input('email')));
        } else {
            echo json_encode(array("status" => FALSE));
        }
    }

}
