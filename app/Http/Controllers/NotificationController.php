<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Session;
use Validator;
use Auth;

class NotificationController extends Controller {

    function index(Request $request) {
        if (Session()->get('web_username')) {
            
        } else {
            return redirect('/');
        }
        $username = session()->get('web_username');
        $type = session()->get('type');
        $data = DB::select('select * from notifications where (find_in_set(?,user_id) OR user_id = ?) AND type = ?', [$username, 'all', $type]);
        if ($type == 'student') {
            $request = DB::table('request')
                    ->select('request.*',DB::raw("IFNULL(users.username, 'Unnamed Tutor') as `username`") ,DB::raw('group_concat(DISTINCT(subject.subject_name)) as sname'))
                    ->join('subject', DB::raw('find_in_set(subject.id, request.subject)'), '>', DB::raw("'0'"))
                    ->join('users','users.email','request.tutor_email')
                    ->where('status', 'accept')
                    ->where('student_email', $username)
                    ->get();
        } else {
            $request = array();
        }
        return view('notification', ['getdata' => $data, 'request' => $request]);
    }

}
