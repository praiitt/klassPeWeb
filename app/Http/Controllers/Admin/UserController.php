<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Session;
use Validator;
use Auth;

class UserController extends Controller {

    function user() {
        $data = DB::table('users')
            ->select('*')
            ->get();
        return view('admin/user', ['getdata' => $data]);
    }

}
