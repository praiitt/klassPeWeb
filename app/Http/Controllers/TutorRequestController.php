<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Session;
use Validator;
use Auth;

class TutorRequestController extends Controller {

    function index(Request $request) {
        if (Session()->get('web_username')) {
            
        } else {
            return redirect('/');
        }
        $username = session()->get('web_username');
//        \DB::enableQueryLog();
//        $data =DB::table('users')  
//                ->select('request.*', DB::raw("IFNULL(users.username, 'Unnamed Student') as `username`"), 'users.image', DB::raw('group_concat(DISTINCT subject.subject_name) as sname'), 'student_registration.location','student_registration.standard','student_registration.mobile_no')
//                ->leftjoin('student_registration','users.email','student_registration.email')
//                ->rightjoin('request', 'users.email','request.student_email')
//                ->join('subject',DB::raw('find_in_set(subject.id, request.subject)'), '>', DB::raw("'0'"))
//                ->where('users.type', 'student')
//                ->where('request.tutor_email', $username)
//                ->where('request.status', '!=','delete')
//                ->orWhereNull('request.status')
//                ->groupBy('request.id')
//                ->get();
//        dd(\DB::getQueryLog());
        $data = DB::select('select `request`.*, IFNULL(users.username, "Unnamed Student") as `username`, `users`.`image`, group_concat(DISTINCT(subject.subject_name)) as sname, `student_registration`.`location`, `student_registration`.`standard`, `student_registration`.`mobile_no`,group_concat(DISTINCT hours_availability.hours) as m_hours,group_concat(DISTINCT hour.hours) as a_hours,payment_transaction.transaction_id,payment_transaction.amount,payment_transaction.datetime,(SELECT case when (COUNT(pt.id) = 1) THEN "Paid" ELSE "Pending" END FROM payment_transaction pt WHERE pt.tutor_email=request.tutor_email AND pt.student_email=request.student_email AND (MONTH(pt.datetime) = month(curdate())) AND (YEAR(pt.datetime) = year(curdate()))) as pstatus from `users` left join `student_registration` on `users`.`email` = `student_registration`.`email` right join `request` on `users`.`email` = `request`.`student_email` inner join `subject` on find_in_set(subject.id, request.subject) > "0" left join `hours_availability` on find_in_set(hours_availability.id, request.m_hours) > "0" left join `hours_availability` hour on find_in_set(hour.id, request.a_hours) > "0" left join payment_transaction on payment_transaction.student_email=users.email where `users`.`type` = "student" and `request`.`tutor_email` = "' . $username . '" and (`request`.`status` != "delete" or `request`.`status` is null) group by `request`.`id`');

        $subject = DB::table('subject')
                ->select('*')
                ->get();
        $standard = DB::table('standard')
                ->select('*')
                ->get();
        return view('request-list', ['getdata' => $data, 'subject' => $subject, 'standard' => $standard]);
    }

    function tutor_registration(Request $request) {
        if (Session()->get('web_username')) {
            
        } else {
            return redirect('/');
        }
        $subject = DB::table('subject')
                ->select('*')
                ->get();
        $standard = DB::table('standard')
                ->select('*')
                ->get();
        return view('tutor-registration', ['subject' => $subject, 'standard' => $standard]);
    }

    function request_tutor_details(Request $request) {
//        \DB::enableQueryLog();
        $data = DB::table('users')
                ->select('request.*', DB::raw("IFNULL(users.username, 'Unnamed Student') as `username`"), 'users.image', DB::raw('group_concat(subject.subject_name) as sname'), 'student_registration.location', 'student_registration.standard', 'student_registration.mobile_no')
                ->leftjoin('student_registration', 'users.email', 'student_registration.email')
                ->rightjoin('request', 'users.email', 'request.student_email')
                ->join('subject', DB::raw('find_in_set(subject.id, request.subject)'), '>', DB::raw("'0'"))
                ->where('users.type', 'student')
                ->where('request.id', $request->input('id'))
                ->groupBy('request.id')
                ->first();

//        dd(\DB::getQueryLog());
        $myString = $data->sname;
        $subject = str_replace(",", " | ", $myString);
        if (empty($data->image)) {
            $image = asset('public/assets/img/avatar.png');
        } else {
            $image = asset($data->image);
        }
        $output = '';
        $output .= '<img src="' . $image . '" class="rounded shadow-sm">';
        $output .= '<div class="ml-3">';
        $output .= '<h4 class="text-secondary">' . $data->username . '</h4>';
        $output .= '<li class="d-inline text-secondary font-weight-light">' . $subject . '</li>';
        $output .= '<h6 class="text-secondary font-weight-light mt-2">Std. ' . $data->standard . '</h6>';
        $output .= '<h6 class="text-secondary font-weight-light">' . $data->location . '</h6>';
        $output .= '<input type="hidden" name="id" id="r_id" value="' . $data->id . '"';
        $output .= '</div>';
        print_r($output);
    }

    function update_request(Request $request) {
        $id = $request->input('id');
        $data = array(
            'status' => 'accept'
        );
        $result = DB::table('request')->where('id', $id)->update($data);
        $notification = DB::table('setting')
                ->select('notification_status')
                ->get();
        $status = $notification[0]->notification_status;
        if ($status == 'true') {
            $data = DB::table('users')
                    ->select('fcm_token')
                    ->where('email', $s_email)
                    ->where('type', 'student')
                    ->first();
            //print_r($data);
            if (!empty($data)) {

                $notification = ["body" => "Request",
                    "title" => "Your Request Accept..",
                    "content_available" => true,
                    "sound" => "default",
                    "priority" => "high"];
                $data = array($data->fcm_token);

                $jsonString = $this->sendPushNotificationToGCMSever($data, $notification, "Your Tutor Accept the Request", "Accept Request");
                $jsonObject = json_decode($jsonString);
                $jsonObject = json_decode(json_encode($jsonObject), TRUE);

                $fcmResult = array("fcm_multicast_id" => $jsonObject['multicast_id'],
                    "fcm_success" => $jsonObject['success'],
                    "fcm_failure" => $jsonObject['failure'],
                    "fcm_error" => json_encode(array_column($jsonObject['results'], 'error')),
                    "fcm_type" => "Accept Request",
                );
                DB::table('firebase_results')->insert($fcmResult);
            }
        }
    }

    function delete_request(Request $request) {
        $id = $request->input('id');
        $data = array(
            'status' => 'delete'
        );
        $result = DB::table('request')->where('id', $id)->update($data);
    }

}
