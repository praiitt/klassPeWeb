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

class LoginController extends Controller {

    function index(Request $request) {
        $name = $request->input('email');
//        $pass = md5($request->input('password'));
        if ($request->input('type') == 'true') {
            $type = 'student';
        } elseif ($request->input('type') == 'false') {
            $type = 'tutor';
        }
        $data = DB::table('users')
                ->select('*')
                ->where('email', $name)
//                ->where('password', $pass)
                ->where('type', $type)
                ->get();
        $tutor = DB::table('tutor_registration')
                ->select('*')
                ->where('email', $name)
                ->get();
        if (count($data) == 0) {
            echo json_encode(array("status" => FALSE));
        } else {
            $request->session()->put('web_username', $request->input('email'));
            $request->session()->put('type', $type);
            $session = $request->session()->get('email');
            echo json_encode(array("status" => TRUE, "image" => $data[0]->image, 'username' => $name, 'type' => $type, 'tutor' => count($tutor)));
        }
    }

//Google login
    function Login_with_google(Request $request) {
        if ($request->input('type') == 'true') {
            $type = 'student';
        } else {
            $type = 'tutor';
        }
        $userdata = array(
            'username' => $request->input('displayName'),
            'email' => $request->input('email'),
            'user_type' => 'google',
//            'password' => md5($request->input('password')),
            'image' => $request->input('photoURL'),
            'type' => $type,
        );
        $name = $request->input('email');
//        $pass = md5($request->input('password'));
        $data = DB::table('users')
                ->select('*')
                ->where('email', $name)
                ->where('type', $type)
                ->get();
        $count = count($data);
        if ($count >= 1) {
            if ($data[0]->email == $name) {
                DB::table('users')->where('email', $name)->where('type', $type)->update($userdata);
            } else {
                $result = DB::table('users')->insert($userdata);
            }
        } else {
            $result = DB::table('users')->insert($userdata);
        }

        $request->session()->put('web_username', $request->input('email'));
        $request->session()->put('type', $type);
        $session = $request->session()->get('email');
        $datas = DB::select('select id from users where email=? and type=?', [$name, $type]);
        $tutor = DB::table('tutor_registration')
                ->select('*')
                ->where('email', $name)
                ->get();
        echo json_encode(array("status" => TRUE, 'type' => $type, 'tutor' => count($tutor)));
    }

//Facebook login
    function web_facebook_login(Request $request) {
        if ($request->input('type') == 'true') {
            $type = 'student';
        } else {
            $type = 'tutor';
        }
        $userdata = array(
            'username' => $request->input('displayName'),
            'email' => $request->input('email'),
            'user_type' => 'facebook',
//            'password' => md5($request->input('password')),
            'image' => file_get_contents('https://graph.facebook.com/' . $request->input('uid') . '/picture?type=large'),
            'type' => $type,
        );
        $name = $request->input('email');
//        $pass = md5($request->input('password'));
        $data = DB::table('users')
                ->select('*')
                ->where('email', $name)
                ->where('type', $type)
                ->get();
        $count = count($data);
        if ($count >= 1) {
            if ($data[0]->email == $name) {
                DB::table('users')->where('email', $name)->where('type', $type)->update($userdata);
            } else {
                $result = DB::table('users')->insert($userdata);
            }
        } else {
            $result = DB::table('users')->insert($userdata);
        }

        $request->session()->put('web_username', $request->input('email'));
        $request->session()->put('type', $type);
        $session = $request->session()->get('email');
        $datas = DB::select('select id from users where email=? and type=?', [$name, $type]);
        $tutor = DB::table('tutor_registration')
                ->select('*')
                ->where('email', $name)
                ->get();
        echo json_encode(array("status" => TRUE, 'type' => $type, 'tutor' => count($tutor)));
    }

// check duplicate email
    function check_email(Request $request) {
        $email = $request->input('email');
        if ($request->input('type') == 'true') {
            $type = 'student';
        } else {
            $type = 'tutor';
        }
        $data = DB::table('users')
                ->select('*')
                ->where('email', $email)
                ->where('type', $type)
                ->get();
        if (count($data) >= 1) {
            echo "1";
        } else {
            echo "0";
        }
    }

//Check Forgot Password
    function check_forgot_pass(Request $request) {
        $email = $request->input('email');
        $type = $request->input('type');
        $datas = DB::table('users')
                ->select('*')
                ->where('email', $email)
                ->where('type', $type)
                ->get();
        $token = rand();
        if (count($datas) >= 1) {
            $data1 = array(
                'forgot_pass_token' => $token
            );
            DB::table('users')->where('email', $email)->where('type', $type)->update($data1);
            $data = [
                'from' => 'lpktechnosoft01@gmail.com',
                'subject' => 'Reset Password',
                'email' => $email,
                'token' => $token
            ];
            Mail::to($email)->send(new TestEmail($data));
        } else {
            echo "1";
        }
    }

}
