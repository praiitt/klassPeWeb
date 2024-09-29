<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\user\Module;
use Hash;

class LogOutController extends Controller {

    public function index(request $request) {
        $username = Session()->get('username');
        $request->session()->forget('username');
        return redirect('admin/');
    }

}


