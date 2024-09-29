<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Session;
use Validator;
use Auth;

class AboutController extends Controller {

    function index(Request $request) {
        if (Session()->get('web_username')) {
            
        } else {
            return redirect('/');
        }
        $data = DB::table('setting')
                ->select('about')
                ->first();
        return view('about-us', ['getdata' => $data]);
    }

}
