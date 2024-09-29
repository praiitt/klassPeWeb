<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Session;
use Validator;
use Auth;

class LogoutController extends Controller {

    function index(Request $request) {
        $username = Session()->get('web_username');
        $type = Session()->get('type');
        $request->session()->forget('web_username');
        $request->session()->forget('type');
        return redirect('/');
    }

}
