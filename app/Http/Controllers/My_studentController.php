<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Session;
use Validator;
use Auth;

class My_studentController extends Controller {

    function index(Request $request) {
        if (Session()->get('web_username')) {
            
        } else {
            return redirect('/');
        }
        $username = session()->get('web_username');
//        \DB::enableQueryLog(); 
        $data = DB::table('users')
                ->select('request.*', DB::raw("IFNULL(users.username, 'Unnamed Student') as `username`"), 'users.image', DB::raw('group_concat(DISTINCT subject.subject_name) as sname'), 'student_registration.location', 'student_registration.standard', 'student_registration.mobile_no', 'student_registration.tuition_type', DB::raw('(SELECT case when (COUNT(pt.id) = 1) THEN "Paid" ELSE "Pending" END FROM payment_transaction pt WHERE pt.tutor_email=request.tutor_email AND pt.student_email=request.student_email AND (MONTH(pt.datetime) = month(curdate())) AND (YEAR(pt.datetime) = year(curdate()))) as status'), DB::raw('group_concat(DISTINCT hours_availability.hours) as m_hours'),DB::raw('group_concat(DISTINCT hour.hours) as a_hours'),'payment_transaction.transaction_id','payment_transaction.amount','payment_transaction.datetime')
                ->leftjoin('student_registration', 'users.email', 'student_registration.email')
                ->rightjoin('request', 'users.email', 'request.student_email')
                ->leftjoin('hours_availability', DB::raw('find_in_set(hours_availability.id, request.m_hours)'), '>', DB::raw("'0'"))
                ->leftjoin('hours_availability as hour', DB::raw('find_in_set(hour.id, request.a_hours)'), '>', DB::raw("'0'"))
                ->join('subject', DB::raw('find_in_set(subject.id, request.subject)'), '>', DB::raw("'0'"))
                ->leftjoin('payment_transaction', 'payment_transaction.student_email', 'users.email')
                ->where('users.type', 'student')
                ->where('request.tutor_email', $username)
                ->where('request.status', 'accept')
                ->groupBy('request.id')
                ->get();
//        dd(\DB::getQueryLog()); 
        return view('my-student', ['getdata' => $data]);
    }

    function send_payment_data(Request $request) {
        $student_email = $request->input('student_email');
        $tutor_email = $request->input('tutor_email');
        $transaction_id = $request->input('transaction_id');
        $data = DB::table('request')
                ->select('fees', 'subject')
                ->where('tutor_email', $tutor_email)
                ->where('student_email', $student_email)
                ->get();
        $fees = $data[0]->fees;
        $arr = explode(',', $fees);
        $subject = $data[0]->subject;
        $arr1 = explode(',', $subject);
        $jsonArray = array();
        foreach (array_combine($arr1, $arr) as $name => $value) {
            $jsonArray[] = array('subject' => $name, 'fees' => $value);
        }

        $datas = array(
            'tutor_email' => $tutor_email,
            'student_email' => $student_email,
            'amount' => array_sum($arr),
            'sub_fees' => json_encode($jsonArray),
            'transaction_id' => $transaction_id
        );
        $result = DB::table('payment_transaction')->insert($datas);
        if ($result) {
            echo json_encode(array("status" => TRUE, "msg" => "Insert Successfully"));
        } else {
            echo json_encode(array("status" => FALSE, "msg" => "Something Wrong"));
        }
    }

}
