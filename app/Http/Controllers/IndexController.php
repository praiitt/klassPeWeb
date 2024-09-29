<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Session;
use Validator;
use Auth;

class IndexController extends Controller {

    function index(Request $request) {
        $username = session()->get('web_username');
//        DB::enableQueryLog();
        if (session()->get('type') == 'student') {
            $data = DB::table('users')
                    ->select('student_registration.mobile_no', 'student_registration.standard', 'student_registration.location', 'users.*')
                    ->leftjoin('student_registration', 'student_registration.email', 'users.email')
                    ->where('users.email', $username)
                    ->where('users.type', 'student')
                    ->get();
        }else{
            $data = '';
        }
        $side = DB::table('users')
                ->select('users.*')
                ->where('users.email', $username)
                ->where('users.type', session()->get('type'))
                ->first();
//        dd(DB::getQueryLog());
        return view('index', ['getdata' => $data, 'side' => $side]);
    }

}
