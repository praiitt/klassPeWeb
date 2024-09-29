<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Session;
use Validator;
use Auth;

class Send_requestController extends Controller {

    function index(Request $request) {
        if (Session()->get('web_username')) {
            
        } else {
            return redirect('/');
        }
        $username = session()->get('web_username');
//        \DB::enableQueryLog();
//        $data = DB::table('users')
//                ->select('request.*', DB::raw("IFNULL(users.username, 'Unnamed Student') as `username`"), 'users.image', DB::raw('group_concat(DISTINCT  subject.subject_name) as sname'), 'tutor_registration.location', 'tutor_registration.mobile_no')
//                ->leftjoin('tutor_registration', 'users.email', 'tutor_registration.email')
//                ->rightjoin('request', 'users.email', 'request.tutor_email')
//                ->join('subject', DB::raw('find_in_set(subject.id, request.subject)'), '>', DB::raw("'0'"))
//                ->where('users.type', 'tutor')
//                ->where('request.student_email', $username)
//                ->where('request.status', '!=', 'accpet')
//                ->orWhereNull('request.status')
//                ->groupBy('request.id')
//                ->get();
        $data = DB::select('select `request`.*, IFNULL(users.username, "Unnamed Student") as `username`, `users`.`image`, group_concat(DISTINCT  subject.subject_name) as sname, `tutor_registration`.`location`, `tutor_registration`.`mobile_no` from `users` left join `tutor_registration` on `users`.`email` = `tutor_registration`.`email` right join `request` on `users`.`email` = `request`.`tutor_email` inner join `subject` on find_in_set(subject.id, request.subject) > "0" where `users`.`type` = "tutor" and `request`.`student_email` = "' . $username . '" and (`request`.`status` != "accpet" or `request`.`status` is null) group by `request`.`id`');

//        dd(\DB::getQueryLog());
        return view('my-request', ['getdata' => $data]);
    }

    function send_payment_request(Request $request) {
        $student_email = $request->get('email');
        $notification = DB::table('setting')
                ->select('notification_status')
                ->get();
        $status = $notification[0]->notification_status;
        if ($status == 'true') {
            $data = DB::table('users')
                    ->select('fcm_token', 'username')
                    ->where('email', $student_email)
                    ->where('type', 'student')
                    ->first();
            $username = $data->username;
//            print_r($data);
            if (!empty($data)) {

                $notification = ["body" => "Request",
                    "title" => $username . " has requested tuition fees payment",
                    "content_available" => true,
                    "sound" => "default",
                    "priority" => "high"];
                $data = array($data->fcm_token);

                $jsonString = $this->sendPushNotificationToGCMSever($data, $notification, "Your Tutor Send Payment Request", "Payment Request");
                $jsonObject = json_decode($jsonString);
                $jsonObject = json_decode(json_encode($jsonObject), TRUE);

                $fcmResult = array("fcm_multicast_id" => $jsonObject['multicast_id'],
                    "fcm_success" => $jsonObject['success'],
                    "fcm_failure" => $jsonObject['failure'],
                    "fcm_error" => json_encode(array_column($jsonObject['results'], 'error')),
                    "fcm_type" => "Send Request",
                );
//                print_r($fcmResult);
                DB::table('firebase_results')->insert($fcmResult);
            }
            if ($fcmResult) {
                echo "Send Notification..";
            } else {
                echo "Something Wrong";
            }
        }
    }

    public function sendPushNotificationToGCMSever($tokenArray, $message, $title, $body) {



        $path_to_firebase_cm = 'https://fcm.googleapis.com/fcm/send';

        $fields = array(
            'registration_ids' => $tokenArray,
            'data' => $message,
            'notification' => $message,
        );
        //echo json_encode($fields);
        $headers = array(
            'Authorization:key=AAAACMnPbJs:APA91bH9ndPBDXSitryqhvi0_h7V2D3IqjGzopLEYaTu1cThGOov8JOj-vH9JtrwHLVlMwPJ1teSIcbQOijoU4fDVxTnzD5iLz6EOb1A3Tnc6Xa5IBsF6KNVPHEcnWBRA9NDucLJdRT3',
            'Content-Type:application/json'
        );
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $path_to_firebase_cm);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

        $result = curl_exec($ch);

        curl_close($ch);

        return $result;
    }

}
