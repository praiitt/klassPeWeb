<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Session;
use Validator;
use Auth;

class LoginController extends Controller {

    function index() {
        return view('admin/login');
    }

    function checklogin(Request $request) {
        $name = $request->input('username');
        $pass = md5($request->input('password'));
        $request->session()->put('username', $request->input('username'));
        $session = $request->session()->get('username');
        $data = DB::select('select id from admin where username=? and password=?', [$name, $pass]);
        if (count($data)) {
            return redirect('admin/dashboard');
        } else {
            return redirect()->back()->with('message', 'Authentication Fail');
        }
    }

    function dashboard() {

        return view('admin/dashboard');
    }

    function change_password(Request $request) {
        return view('admin/change_password');
    }

    function change(Request $request) {
        $input = $request->all();
        $getdata = DB::table('admin')
                ->where('username', $input['id'])
                ->get();
        $user = '';
        foreach ($getdata as $g) {
            $user = $g->password;
        }
        if ($user == md5($input['old'])) {
            return "1";
        } else {
            return "0";
        }
    }

    function change_pass(Request $request) {
        $input = $request->all();
        $pass = DB::table('admin')->where('username', $input['change'])->update(['password' => md5($input['new'])]);
        if ($pass == TRUE) {
            return '1';
        } else {
            return '0';
        }
    }

}
