<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Session;
use Validator;
use Auth;

class Send_notification extends Controller {

    public function index() {
        $notification = DB::table('notifications')
                ->select('*')
                ->get();

        return view('admin/send_notification', ['notification' => $notification]);
    }

    function Send_notification(Request $request) {

        if ($request->input('user_id') == 'all') {
            $user_id = 'all';
        } else {
            $user_id = implode(',', $request->input('user_id'));
        }
        $data = array(
            'title' => $request->input('title'),
            'message' => $request->input('message'),
            'user_id' => $user_id,
            'type' => $request->input('type')
        );
        $result = DB::table('notifications')->insert($data);
        if ($result) {
            $notification = DB::table('setting')
                    ->select('notification_status')
                    ->get();
            $status = $notification[0]->notification_status;
            if ($status == 'true') {

                if ($user_id == 'all') {
                    $data = DB::select('select fcm_token from `users`');
                } else {
                    $user_id = $request->input('user_id');
                    $myArray = implode(',', $user_id);
                    $data = DB::select('select fcm_token from `users` where `email` in ("' . $myArray . '")');
                }
                $fcm_token = $data;

                if (!empty($fcm_token)) {
                    $notification = ["body" => $request->input('title'),
                        "title" => "Tutor Finder",
                        "content_available" => true,
                        "sound" => "default",
                        "priority" => "high"];
//                    print_r($notification);

                    $data = array_column($fcm_token, 'fcm_token');

                    $jsonString = $this->sendPushNotificationToGCMSever($data, $notification, "New Book", $request->input('title'));
                    $jsonObject = json_decode($jsonString);
                    $jsonObject = json_decode(json_encode($jsonObject), TRUE);

                    $fcmResult = array("fcm_multicast_id" => $jsonObject['multicast_id'],
                        "fcm_success" => $jsonObject['success'],
                        "fcm_failure" => $jsonObject['failure'],
                        "fcm_error" => json_encode(array_column($jsonObject['results'], 'error')),
                        "fcm_type" => "Notification",
                    );

                    DB::table('firebase_results')->insert($fcmResult);
                }
            } else {
                
            }
            return redirect('admin/Send_Notification')->with('message', '<div class="alert alert-success">Send Notification</div>');
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
            'Authorization:key=AAAATal48tE:APA91bFjVKqf5Uyhf4B7Dn42evPM1iPG79ZNYr_zkAM7G9mhsfWbbSjrshjW4kTXNfqg0gTD0G-a8xWR0FTgiaUWzu5SrclyCinx-jwkYoDAeT9OIqnyny30B5L-nFcTqs4vU8FhAYj2',
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

    function compress_image($source_url, $destination_url, $quality) {
        $info = getimagesize($source_url);
        if ($info['mime'] == 'image/jpeg')
            $image = imagecreatefromjpeg($source_url);
        elseif ($info['mime'] == 'image/gif')
            $image = imagecreatefromgif($source_url);
        elseif ($info['mime'] == 'image/png')
            $image = imagecreatefrompng($source_url);
        imagejpeg($image, $destination_url, $quality);
        return $destination_url;
    }

    function change_type(Request $request) {
        $type = $request->input('type');
        if ($type == 'tutor') {
            $tutor = DB::table('tutor_registration')
                    ->select('users.username', 'users.email')
                    ->join('users', 'users.email', '=', 'tutor_registration.email')
                    ->where('users.type', $type)
                    ->get();
            $output = '<option value="">Select Tutor</option>';
            $output .= '<option value="all">All</option>';
            foreach ($tutor as $tutors) {
                $output .= "<option value=" . $tutors->email . ">" . $tutors->username . "</option>";
            }
            echo $output;
        } elseif ($type == 'student') {
            $student = DB::table('student_registration')
                    ->select('users.username', 'users.email')
                    ->leftjoin('users', 'users.email', '=', 'student_registration.email')
                    ->where('users.type', $type)
                    ->get();
//            print_r($student);
            $outputs = '<option value="">Select Student</option>';
            $outputs .= '<option value="all">All</option>';
            foreach ($student as $students) {
                $outputs .= "<option value=" . $students->email . ">" . $students->username . "</option>";
            }
            echo $outputs;
        }
    }

}
