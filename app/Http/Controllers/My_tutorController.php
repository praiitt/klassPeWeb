<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Session;
use Validator;
use Auth;

class My_tutorController extends Controller {

    function index(Request $request) {
        if (Session()->get('web_username')) {
            
        } else {
            return redirect('/');
        }
        $username = session()->get('web_username');
        $stripe_key = DB::table('setting')
                ->select("stripe_client_key", "stripe_public_key")
                ->first();
        $stripe_client_key = 'sk_test_C2CqMfoav2GD8UdMjLDvdghx00PwrJibHL';
        $stripe_public_key = 'pk_test_kfsr3luyMDMdh8xNwDmxNJNS00CIROHuDs';
//        \DB::enableQueryLog();
        $data = DB::table('users')
                ->select('request.*', DB::raw("IFNULL(users.username, 'Unnamed Student') as `username`"), 'users.image', 'payment_transaction.transaction_id', 'payment_transaction.amount', 'payment_transaction.datetime', DB::raw('group_concat(DISTINCT(subject.subject_name)) as sname'), 'tutor_registration.location', 'tutor_registration.mobile_no', DB::raw('group_concat(DISTINCT(standard.std)) as std_name'), DB::raw('(SELECT case when (COUNT(pt.id) = 1) THEN "Paid" ELSE "Pending" END FROM payment_transaction pt WHERE pt.tutor_email=request.tutor_email AND pt.student_email=request.student_email AND MONTH(pt.datetime) = MONTH(CURRENT_DATE())) as status'))
                ->leftjoin('tutor_registration', 'users.email', 'tutor_registration.email')
                ->rightjoin('request', 'users.email', 'request.tutor_email')
                ->join('subject', DB::raw('find_in_set(subject.id, request.subject)'), '>', DB::raw("'0'"))
                ->join('standard', DB::raw('find_in_set(standard.id, tutor_registration.standard)'), '>', DB::raw("'0'"))
                ->leftjoin('payment_transaction', 'payment_transaction.tutor_email', 'users.email')
                ->where('users.type', 'tutor')
                ->where('request.student_email', $username)
                ->where('request.status', 'accept')
                ->groupBy('request.id')
                ->get();
//        dd(\DB::getQueryLog());
        return view('my-tutor', ['getdata' => $data, 'stripe_client_key' => $stripe_client_key, 'stripe_public_key' => $stripe_public_key]);
    }

}
