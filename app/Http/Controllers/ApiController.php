<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Session;
use Validator;
use Auth;
use Stripe;

class ApiController extends Controller {

    function index(Request $request) {

        $request_auth = getallheaders();
        if (!empty($request_auth['token'])) {
            if (empty($request->input('email'))) {
                $response['status'] = false;
                $response['msg'] = "Unknown user request";
                echo json_encode($response);
                die();
            }
            if (empty($request->input('name'))) {
                $response['status'] = false;
                $response['msg'] = "Unknown requested name..";
                echo json_encode($response);
                die();
            }
            $tmp = $this->Auth($request->input('name'), $request->input('email'));

            if (!$tmp) {
                $response['status'] = false;
                $response['msg'] = "Unauthorised request";
                echo json_encode($response);
                die();
            }
            $name = $request->input('name');
//-------------- LOGIN ---------------------//
            if ($name == 'login') {
                $email = $request->input('email');
                $type = $request->input('type');
                $check_user = DB::table('users')->where('email', $email)->where('type', $type)->get();
                if (count($check_user) >= 1) {
                    if ($request->input('user_type') == 'apple' || $request->input('user_type') == 'google' || $request->input('user_type') == 'facebook') {
                        $data = array(
                            'username' => $request->input('username'),
                            'user_type' => $request->input('user_type'),
                            'type' => $request->input('type'),
                        );
                        try {
                            $result = DB::table('users')->where('email', $email)->where('type', $type)->update($data);
                            echo json_encode(array("status" => TRUE, "msg" => "Update Successfully", "username" => $request->input('username'), "type" => $check_user[0]->type));
                        } catch (\Illuminate\Database\QueryException $e) {

                            echo json_encode(array("status" => FALSE, "msg" => "Something Wrong"));
                        }
                    } else {
                        $name = $request->input('email');
                        // $pass = md5($request->input('password'));
                        $type = $request->input('type');
                        $data = DB::select('select id,username,image,type from users where email=? and type=?', [$name, $type]);
                        if (!empty($data)) {
                            if (empty($data[0]->username) && $data[0]->type == 'tutor') {
                                $username = 'Unnamed Tutor';
                            } elseif (empty($data[0]->username) && $data[0]->type == 'student') {
                                $username = 'Unnamed Student';
                            } else {
                                $username = $data[0]->username;
                            }
                        }
                        if (count($data)) {
                            echo json_encode(array("status" => TRUE, "msg" => "Login Successfully", "username" => $username, "type" => $data[0]->type, "image" => $data[0]->image));
                        } else {
                            echo json_encode(array("status" => FALSE, "msg" => "Authentication Fail..!!"));
                        }
                    }
                } else {
//Post Data
                    $check_user = DB::table('users')->where('email', $email)->where('type', $type)->get();
                    if (count($check_user) == 0) {
                        $data = array(
                            'username' => $request->input('username'),
                            'email' => $request->input('email'),
                            'image' => $request->input('image'),
                            'user_type' => $request->input('user_type'),
                            "firebase_id" => $request->input('firebase_id'),
                            "fcm_token" => $request->input('fcm_token'),
                            // "password" => md5($request->input('password')),
                            'type' => $request->input('type'),
                        );
                        $result = DB::table('users')->insert($data);
                        if ($result) {
                            echo json_encode(array("status" => TRUE, "msg" => "Insert Successfully", 'username' => $request->input('username'), 'ImageUrl' => $request->input('image'), 'email' => $request->input('email'), "type" => $request->input('type')));
                        } else {
                            echo json_encode(array("status" => FALSE, "msg" => "Something Wrong"));
                        }
                    } else {
                        echo json_encode(array("status" => FALSE, "msg" => "Something Wrong.."));
                    }
//Insert Data
                }
                die();
            }
//-------------- Get Subject  ---------------------//
            if ($name == 'subject') {
                $email = $request->input('email');

                $data = DB::table('subject')
                        ->select("*")
                        ->get();
                if (count($data) >= 1) {
                    echo json_encode(array("status" => TRUE, "data" => $data, "msg" => "data get Sucessfully"));
                } else {
                    echo json_encode(array("status" => TRUE, "msg" => "Data Not Found"));
                }
                die();
            }
//-------------- Get Standard  ---------------------//
            if ($name == 'standard') {
                $email = $request->input('email');

                $data = DB::table('standard')
                        ->select("*")
                        ->get();
                if (count($data) >= 1) {
                    echo json_encode(array("status" => TRUE, "data" => $data, "msg" => "data get Sucessfully"));
                } else {
                    echo json_encode(array("status" => TRUE, "msg" => "Data Not Found"));
                }
                die();
            }
//-------------- Add Tutor Registration Details  ---------------------//
            if ($name == 'tutor_registration') {
                $email = $request->input('email');
                $check_user = DB::table('tutor_registration')->where('email', $email)->get();
                if (count($check_user) >= 1) {
//Update Data
                    $data = array(
                        'standard' => $request->input('standard'),
                        'subject' => $request->input('subject'),
                        'monthly_fees' => $request->input('monthly_fees'),
                        'university' => $request->input('university'),
                        "location" => $request->input('location'),
                        "year_of_experience" => $request->input('year_of_experience'),
                        "mobile_no" => $request->input('mobile_no'),
                        "tuition_type" => $request->input('tuition_type'),
                        "m_hours" => $request->input('m_hours'),
                        "a_hours" => $request->input('a_hours')
                    );
                    $datas = array(
                        'username' => $request->input('username')
                    );
                    try {
                        $result1 = DB::table('users')->where('email', $email)->update($datas);
                        $result = DB::table('tutor_registration')->where('email', $email)->update($data);
						$data = DB::table('tutor_registration')
                        ->select("users.*", "tutor_registration.*", "subject.subject_name", DB::raw("IFNULL(users.username, 'Unnamed Tutor') as `username`"))
                        ->selectRaw('(SELECT IFNULL(FORMAT(((round(2*avg(rate),0))/2),1),0)*1 FROM ratings WHERE ratings.tutor_email=tutor_registration.email AND ratings.rate!=0) as rate')
                        ->join('users', 'users.email', '=', 'tutor_registration.email')
                        ->join('subject', 'subject.id', '=', 'tutor_registration.subject')
                        ->where('tutor_registration.email', $email)
                        ->where('users.type', 'tutor')
                        ->get();
                        echo json_encode(array("status" => TRUE, "msg" => "Update Successfully", "data" => $data, "email" => $email));
                    } catch (\Illuminate\Database\QueryException $e) {
                        echo json_encode(array("status" => FALSE, "msg" => "Something Wrong"));
                    }
                } else {
//Post Data
                    $data = array(
                        'email' => $email,
                        'standard' => $request->input('standard'),
                        'subject' => $request->input('subject'),
                        'monthly_fees' => $request->input('monthly_fees'),
                        'university' => $request->input('university'),
                        "location" => $request->input('location'),
                        "year_of_experience" => $request->input('year_of_experience'),
                        "mobile_no" => $request->input('mobile_no'),
                        "latitude" => $request->input('latitude'),
                        "longitude" => $request->input('longitude'),
                        "tuition_type" => $request->input('tuition_type')
                    );
//Insert Data
                    $result = DB::table('tutor_registration')->insert($data);
                    if ($result) {
						$data = DB::table('tutor_registration')
                        ->select("users.*", "tutor_registration.*", "subject.subject_name", DB::raw("IFNULL(users.username, 'Unnamed Tutor') as `username`"))
                        ->selectRaw('(SELECT IFNULL(FORMAT(((round(2*avg(rate),0))/2),1),0)*1 FROM ratings WHERE ratings.tutor_email=tutor_registration.email AND ratings.rate!=0) as rate')
                        ->join('users', 'users.email', '=', 'tutor_registration.email')
                        ->join('subject', 'subject.id', '=', 'tutor_registration.subject')
                        ->where('tutor_registration.email', $email)
                        ->where('users.type', 'tutor')
                        ->get();
                        echo json_encode(array("status" => TRUE, "msg" => "Insert Successfully", "data" => $data,'email' => $request->input('email')));
                    } else {
                        echo json_encode(array("status" => FALSE, "msg" => "Something Wrong"));
                    }
                }
            }
//-------------- Update Fcm Token  ---------------------//
            if ($name == 'update_fcm_token') {

                $email = $request->input('email');
                $type = $request->input('type');
                $record = array(
                    "fcm_token" => $request->input('fcm_token')
                );
                try {
                    $result = DB::table('users')->where('email', $email)->where('type', $type)->update($record);
                    echo json_encode(array("status" => TRUE, "msg" => "Update Successfully"));
                } catch (\Illuminate\Database\QueryException $e) {

                    echo json_encode(array("status" => FALSE, "msg" => "Something Wrong"));
                }
                die();
            }
//-------------- Set Tutor Profile Image  ---------------------//
            if ($name == 'set_tutor_profile_image') {

                $email = $request->input('email');
                $check_user = DB::table('users')->where('email', $email)->get();
                if (count($check_user) >= 1) {
//                    upload image
                    $image = $request->file('image');
                    $ext = $image->getClientOriginalExtension();
                    if (empty($check_user[0]->id)) {
                        $imageName = '1-' . time() . '.' . $image->getClientOriginalExtension();
                    } else {
                        $imageName = $check_user[0]->id . '-' . time() . '.' . $image->getClientOriginalExtension();
                    }

                    $imgefolder = "public/TutorImages/" . ($imageName);
                    $file = array("jpg", "jpeg", "png", "JPEG", "PNG", "JPG");
                    if ($ext != 'png') {

                        $pic1 = $this->compress_image($_FILES["image"]["tmp_name"], $imgefolder, 80);
                    } else {
                        $tmp = $_FILES['image']['tmp_name'];
                        move_uploaded_file($tmp, $imgefolder);
                    }
//
                    $data = array(
                        'image' => url('public/TutorImages/' . $imageName),
                    );
                    $image = url('public/TutorImages/' . $imageName);
                    try {
                        $result = DB::table('users')->where('email', $email)->update($data);
                        echo json_encode(array("status" => TRUE, "msg" => "Update Successfully", "imageurl" => $image));
                    } catch (\Illuminate\Database\QueryException $e) {
                        echo json_encode(array("status" => FALSE, "msg" => "Something Wrong"));
                    }
                } else {
                    echo json_encode(array("status" => FALSE, "msg" => "No Data Avilable"));
                }
            }
//-------------- Add Student Registration Details  ---------------------//
            if ($name == 'student_registration') {
                $email = $request->input('email');
                $check_user = DB::table('student_registration')->where('email', $email)->get();
                if (count($check_user) >= 1) {
//Update Data
                    $data = array(
                        'standard' => $request->input('standard'),
                        // 'subject' => $request->input('subject'),
                        "location" => $request->input('location'),
                        "mobile_no" => $request->input('mobile_no'),
                    );
                    $datas = array(
                        'username' => $request->input('username')
                    );
                    try {
                        $result1 = DB::table('users')->where('email', $email)->update($datas);
                        $result = DB::table('student_registration')->where('email', $email)->update($data);
                        echo json_encode(array("status" => TRUE, "msg" => "Update Successfully", "email" => $email));
                    } catch (\Illuminate\Database\QueryException $e) {
                        echo json_encode(array("status" => FALSE, "msg" => "Something Wrong"));
                    }
                } else {
//Post Data
                    $data = array(
                        'email' => $email,
                        'standard' => $request->input('standard'),
                        // 'subject' => $request->input('subject'),
                        "location" => $request->input('location'),
                        "mobile_no" => $request->input('mobile_no'),
                    );
//Insert Data
                    $result = DB::table('student_registration')->insert($data);
                    if ($result) {
                        echo json_encode(array("status" => TRUE, "msg" => "Insert Successfully", 'email' => $request->input('email')));
                    } else {
                        echo json_encode(array("status" => FALSE, "msg" => "Something Wrong"));
                    }
                }
                die();
            }
//-------------- Set Student Profile Image  ---------------------//
            if ($name == 'set_student_profile_image') {

                $email = $request->input('email');
                $check_user = DB::table('users')->where('email', $email)->get();
                if (count($check_user) >= 1) {
//                    upload image
                    $image = $request->file('image');
                    $ext = $image->getClientOriginalExtension();
                    if (empty($check_user[0]->id)) {
                        $imageName = '1-' . time() . '.' . $image->getClientOriginalExtension();
                    } else {
                        $imageName = $check_user[0]->id . '-' . time() . '.' . $image->getClientOriginalExtension();
                    }

                    $imgefolder = "public/StudentImages/" . ($imageName);
                    $file = array("jpg", "jpeg", "png", "JPEG", "PNG", "JPG");
                    if ($ext != 'png') {

                        $pic1 = $this->compress_image($_FILES["image"]["tmp_name"], $imgefolder, 80);
                    } else {
                        $tmp = $_FILES['image']['tmp_name'];
                        move_uploaded_file($tmp, $imgefolder);
                    }
//
                    $data = array(
                        'image' => url('public/StudentImages/' . $imageName),
                    );
                    $image = url('public/StudentImages/' . $imageName);
                    try {
                        $result = DB::table('users')->where('email', $email)->update($data);
                        echo json_encode(array("status" => TRUE, "msg" => "Update Successfully", "imageurl" => $image));
                    } catch (\Illuminate\Database\QueryException $e) {
                        echo json_encode(array("status" => FALSE, "msg" => "Something Wrong"));
                    }
                } else {
                    echo json_encode(array("status" => FALSE, "msg" => "No Data Avilable"));
                }
            }
//--------------------Notification List---------------------------------//            
            if ($name == 'notification_list') {
                $email = $request->input('email');
                $type = $request->input('type');
                $data = DB::select('select * from notifications where (find_in_set(?,user_id) OR user_id = ?) AND type = ?', [$email, 'all', $type]);
                if ($type == 'student') {
					// \DB::enableQueryLog();
                    $request = DB::table('request')
                            ->select('request.*', DB::raw('COALESCE(subject.subject_name) as sname'),DB::raw("IFNULL(username, 'Unnamed Student') as `username`"))
                            ->join('subject', DB::raw('find_in_set(subject.id, request.subject)'), '>', DB::raw("'0'"))
							->join('users', 'users.email', '=', 'request.student_email')
                            ->where('request.status', 'accept')
                            ->where('request.student_email', $email)
                            ->get();
							// dd(\DB::getQueryLog());
							// print_r($request);
                } else {
                    $request = array();
                }
                if (count($data) >= 1 || count($request) >= 1) {
                    echo json_encode(array("status" => TRUE, "data" => $data, "request" => $request, "msg" => "data get Sucessfully"));
                } else {
                    echo json_encode(array("status" => TRUE, "msg" => "Data Not Found"));
                }
                die();
            }
//--------------  Add Rating  ---------------------//
            if ($name == 'add_rating') {
                $s_email = $request->input('email');
                $t_email = $request->input('tutor_email');
                $rate = DB::table('ratings')
                        ->where('email', $s_email)
                        ->where('tutor_email', $t_email)
                        ->get();

                if (count($rate) >= 1) {
                    $data = array(
                        'rate' => $request->input('rate'),
                        'email' => $s_email,
                        'tutor_email' => $t_email
                    );
                    try {
                        $result = DB::table('ratings')->where('id', $rate[0]->id)->update($data);

                        echo json_encode(array("status" => TRUE, "msg" => "data Update Sucessfully"));
                    } catch (\Illuminate\Database\QueryException $e) {

                        echo json_encode(array("status" => FALSE, "msg" => "Something Wrong"));
                    }
                } else {
                    $data = array(
                        'rate' => $request->input('rate'),
                        'email' => $s_email,
                        'tutor_email' => $t_email
                    );

                    $result = DB::table('ratings')->insert($data);

                    if ($result) {
                        echo json_encode(array("status" => TRUE, "msg" => "data Insert Sucessfully"));
                    } else {
                        echo json_encode(array("status" => FALSE, "msg" => "Something Wrong"));
                    }
                }
                die();
            }
//--------------  Send Request  ---------------------//
            if ($name == 'send_request') {
                $t_email = $request->input('tutor_email');
                $s_email = $request->input('email');
                $subject = $request->input('subject');
                $fees = $request->input('fees');
                $tuition_type = $request->input('tuition_type');
                $m_hours = $request->input('m_hours');
                $a_hours = $request->input('a_hours');
                $request = DB::table('request')
                        ->where('student_email', $s_email)
                        ->where('tutor_email', $t_email)
                        ->get();

                if (count($request) >= 1) {
                    $data = array(
                        'tutor_email' => $t_email,
                        'student_email' => $s_email,
                        'subject' => rtrim($subject, ','),
                        'fees' => $fees,
                        'status' => NULL,
                        'tuition_type' => $tuition_type,
                        'm_hours' => $m_hours,
                        'a_hours' => $a_hours
                    );
                    try {
                        $result = DB::table('request')->where('id', $request[0]->id)->where('tutor_email', $t_email)->update($data);
                        // if ($result) {
                        echo json_encode(array("status" => TRUE, "msg" => "data Update Sucessfully"));
                        $notification = DB::table('setting')
                                ->select('notification_status')
                                ->get();
                        $status = $notification[0]->notification_status;
                        if ($status == 'true') {
                            $data = DB::table('users')
                                    ->select('fcm_token,username')
                                    ->where('email', $t_email)
                                    ->where('type', 'tutor')
                                    ->first();
                            //print_r($data);
                            $username = $data->username;
                            if (!empty($data)) {

                                $notification = ["body" => "Request",
                                    "title" => $username . " tuition request received",
                                    "content_available" => true,
                                    "sound" => "default",
                                    "priority" => "high",
                                    "notification_name" => "tuition request",
                                    "subjects" => rtrim($subject, ','),
                                    'm_hours' => $m_hours,
                                    'a_hours' => $a_hours];
                                $data = array($data->fcm_token);

                                $jsonString = $this->sendPushNotificationToGCMSever($data, $notification, "Send Request", "Student Request");
                                $jsonObject = json_decode($jsonString);
                                $jsonObject = json_decode(json_encode($jsonObject), TRUE);

                                $fcmResult = array("fcm_multicast_id" => $jsonObject['multicast_id'],
                                    "fcm_success" => $jsonObject['success'],
                                    "fcm_failure" => $jsonObject['failure'],
                                    "fcm_error" => json_encode(array_column($jsonObject['results'], 'error')),
                                    "fcm_type" => "Send Request",
                                );
                                DB::table('firebase_results')->insert($fcmResult);
                            }
                        }
                    } catch (\Illuminate\Database\QueryException $e) {

                        //echo json_encode(array("status" => FALSE, "msg" => "Something Wrong"));
                    }
                } else {
                    $datas = array(
                        'tutor_email' => $t_email,
                        'student_email' => $s_email,
                        'subject' => rtrim($subject, ','),
                        'fees' => $fees,
                        'tuition_type' => $tuition_type,
                        'm_hours' => $m_hours,
                        'a_hours' => $a_hours
                    );

                    $result = DB::table('request')->insert($datas);

                    if ($result) {
                        echo json_encode(array("status" => TRUE, "msg" => "data Insert Sucessfully"));
                        $notification = DB::table('setting')
                                ->select('notification_status')
                                ->get();
                        $status = $notification[0]->notification_status;
                        if ($status == 'true') {
							// \DB::enableQueryLog();
                            $data = DB::table('users')
                                    ->select('fcm_token', 'username')
                                    ->where('email', $t_email)
                                    ->where('type', 'tutor')
                                    ->first();
									// dd(\DB::getQueryLog()); // Show results of log
                            // print_r($data);
                            $username = $data->username;
                            if (!empty($data)) {

                                $notification = ["body" => "Request",
                                    "title" => $username . " tuition request received",
                                    "content_available" => true,
                                    "sound" => "default",
                                    "priority" => "high",
                                    "notification_name" => "tuition request"];
                                $data = array($data->fcm_token);

                                $jsonString = $this->sendPushNotificationToGCMSever($data, $notification, "Send Request", "Student Request");
                                $jsonObject = json_decode($jsonString);
                                $jsonObject = json_decode(json_encode($jsonObject), TRUE);

                                $fcmResult = array("fcm_multicast_id" => $jsonObject['multicast_id'],
                                    "fcm_success" => $jsonObject['success'],
                                    "fcm_failure" => $jsonObject['failure'],
                                    "fcm_error" => json_encode(array_column($jsonObject['results'], 'error')),
                                    "fcm_type" => "Send Request",
                                );
                                DB::table('firebase_results')->insert($fcmResult);
                            }
                        }
                    } else {
                        echo json_encode(array("status" => FALSE, "msg" => "Something Wrong"));
                    }
                }
                die();
            }
//--------------  Get Tutors  ---------------------//
            if ($name == 'get_tutor') {
                $email = $request->input('email');

                $data = DB::table('tutor_registration')
                        ->select("*", DB::raw("IFNULL(username, 'Unnamed Tutor') as `username`"))
                        ->join('users', 'users.email', '=', 'tutor_registration.email')
                        ->where('users.type', 'tutor')
                        ->get();
                if (count($data) >= 1) {
                    echo json_encode(array("status" => TRUE, "data" => $data, "msg" => "data get Sucessfully"));
                } else {
                    echo json_encode(array("status" => TRUE, "msg" => "Data Not Found"));
                }
                die();
            }
//--------------  Get particular Tutors Details  ---------------------//
            if ($name == 'get_particular_tutor_details') {
                $email = $request->input('email');
                $t_email = $request->input('tutor_email');
                //\DB::enableQueryLog();
                $tutor_data = DB::table('student_registration')
                        ->select("latitude", "longitude")
                        ->where('email', $email)
                        ->first();
                $latitude = !empty($tutor_data->latitude) ? $tutor_data->latitude : '0';
                $longitude = !empty($tutor_data->longitude) ? $tutor_data->longitude : '0';

                //\DB::enableQueryLog();
                // if(!empty($latitude) && !empty($longitude)){
                $haversine = "round(
    6371 * acos(
        cos(radians(" . $latitude . "))
        * cos(radians(`latitude`))
        * cos(radians(`longitude`) - radians(" . $longitude . "))
        + sin(radians(" . $latitude . ")) * sin(radians(`latitude`))
    )
,2)";
                // }else{
                // $haversine = "";
                // }
                // print_r($haversine);
                // \DB::enableQueryLog();
                $data = DB::table('tutor_registration')
                        ->select("users.*", "tutor_registration.*", "subject.subject_name", DB::raw("IFNULL(username, 'Unnamed Tutor') as `username`"))
                        ->selectRaw('(SELECT IFNULL(FORMAT(((round(2*avg(rate),0))/2),1),0)*1 FROM ratings WHERE ratings.tutor_email=tutor_registration.email AND ratings.rate!=0) as rate')
                        ->selectRaw("$haversine AS distance")
                        ->join('users', 'users.email', '=', 'tutor_registration.email')
                        ->join('subject', 'subject.id', '=', 'tutor_registration.subject','left')
                        ->where('tutor_registration.email', $t_email)
                        ->where('users.type', 'tutor')
                        ->get();
                // dd(\DB::getQueryLog());
                if (count($data) >= 1) {
                    echo json_encode(array("status" => TRUE, "data" => $data, "msg" => "data get Sucessfully"));
                } else {
                    echo json_encode(array("status" => TRUE, "msg" => "Data Not Found"));
                }
                die();
            }
//--------------  Setting  ---------------------//
            if ($name == 'setting') {
                $email = $request->input('email');

                $data = DB::table('setting')
                        ->select("*")
                        ->get();
                if (count($data) >= 1) {
                    echo json_encode(array("status" => TRUE, "data" => $data, "msg" => "data get Sucessfully"));
                } else {
                    echo json_encode(array("status" => TRUE, "msg" => "Data Not Found"));
                }
                die();
            }
//--------------  Home Rate Tutor  ---------------------//
            if ($name == 'home_rate_tutor') {
                $email = $request->input('email');
//\DB::enableQueryLog();
                $data = DB::table('ratings')
                        ->select('ratings.*', DB::raw("IFNULL(username, 'Unnamed Tutor') as `username`"), 'users.image', 'tutor_registration.id as iid', DB::raw('ROUND(AVG(rate),1) as rating'), DB::raw('group_concat(DISTINCT(subject.subject_name)) as sname'), 'tutor_registration.standard', 'tutor_registration.subject')
                        ->join('users', 'ratings.tutor_email', 'users.email')
                        ->join('tutor_registration', 'ratings.tutor_email', 'tutor_registration.email')
                        ->join('subject', DB::raw('find_in_set(subject.id, tutor_registration.subject)'), '>', DB::raw("'0'"))
                        ->where('users.type', 'tutor')
                        ->groupby('tutor_email')
                        ->orderby('ratings.rate', 'DESC')
                        ->get();
                //	dd(\DB::getQueryLog());
                if (count($data) >= 1) {
                    echo json_encode(array("status" => TRUE, "data" => $data, "msg" => "data get Sucessfully"));
                } else {
                    echo json_encode(array("status" => TRUE, "msg" => "Data Not Found"));
                }
                die();
            }
//--------------  Home subject tutor  ---------------------//
            if ($name == 'home_subject_tutor') {
                $email = $request->input('email');
                $subject = $request->input('subject');
                $ids = explode(',', $subject);
                $count = count($ids);
                $find = '';
                for ($i = 0; $i < $count; $i++) {
                    $find .= 'find_in_set(' . $ids[$i] . ',subject)';
                    $find .= ' OR ';
                }
                $finds = rtrim($find, " OR ");

                $data = DB::table('tutor_registration')
                        ->select('tutor_registration.*', DB::raw("IFNULL(users.username, 'Unnamed Tutor') as `username`"), 'users.image', DB::raw('group_concat(DISTINCT(subject.subject_name)) as sname'))
                        ->join('subject', DB::raw('find_in_set(subject.id, tutor_registration.subject)'), '>', DB::raw("'0'"))
                        ->join('users', 'users.email', 'tutor_registration.email')
                        ->where('users.type', 'tutor')
                        ->whereRaw($finds)
                        ->groupBy('tutor_registration.id')
                        ->get();
                if (count($data) >= 1) {
                    echo json_encode(array("status" => TRUE, "data" => $data, "msg" => "data get Sucessfully"));
                } else {
                    echo json_encode(array("status" => TRUE, "msg" => "Data Not Found"));
                }
                die();
            }
//--------------  Get Request  ---------------------//
            if ($name == 'get_request') {
                $email = $request->input('email');
                // \DB::enableQueryLog();
                // $data = DB::table('users')
                // ->select('request.*', DB::raw("IFNULL(users.username, 'Unnamed Student') as `username`"), 'users.image', DB::raw('group_concat(DISTINCT(subject.subject_name)) as sname'), 'student_registration.location', 'student_registration.standard', 'student_registration.mobile_no')
                // ->leftjoin('student_registration', 'users.email', 'student_registration.email')
                // ->rightjoin('request', 'users.email', 'request.student_email')
                // ->join('subject', DB::raw('find_in_set(subject.id, request.subject)'), '>', DB::raw("'0'"))
                // ->where('users.type', 'student')
                // ->where('request.tutor_email', $email)
                // ->where('request.status', '!=', 'delete')
                // ->orWhereNull('request.status')
                // ->groupBy('request.id')
                // ->get();
// dd(\DB::getQueryLog());
                $data = DB::select('select `request`.*, IFNULL(users.username, "Unnamed Student") as `username`, `users`.`image`, group_concat(DISTINCT(subject.subject_name)) as sname, `student_registration`.`location`, `student_registration`.`standard`, `student_registration`.`mobile_no`,(SELECT case when (COUNT(pt.id) = 1) THEN "Paid" ELSE "Pending" END FROM payment_transaction pt WHERE pt.tutor_email=request.tutor_email AND pt.student_email=request.student_email) as p_status from `users` left join `student_registration` on `users`.`email` = `student_registration`.`email` right join `request` on `users`.`email` = `request`.`student_email` inner join `subject` on find_in_set(subject.id, request.subject) > "0" LEFT JOIN payment_transaction pt ON student_registration.email=pt.student_email where `users`.`type` = "student" and `request`.`tutor_email` = "' . $email . '" and (`request`.`status` != "delete" or `request`.`status` is null) group by `request`.`id`');
                // dd(\DB::getQueryLog());
                if (count($data) >= 1) {
                    echo json_encode(array("status" => TRUE, "data" => $data, "msg" => "data get Sucessfully"));
                } else {
                    echo json_encode(array("status" => TRUE, "msg" => "Data Not Found"));
                }
                die();
            }
//-------------- Request Status  ---------------------//
            if ($name == 'request_status') {
                $email = $request->input('email');
                $s_email = $request->input('student_email');
                $status = $request->input('status');
                if ($status == 'accept') {
//Update Data
                    $data = array(
                        'status' => $request->input('status')
                    );
                    try {
                        $result = DB::table('request')->where('student_email', $s_email)->update($data);
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
                                    "priority" => "high",
                                    "notification_name" => "tutor request accepted"];
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
                        echo json_encode(array("status" => TRUE, "msg" => "Update Successfully", "email" => $email));
                    } catch (\Illuminate\Database\QueryException $e) {
                        echo json_encode(array("status" => FALSE, "msg" => "Something Wrong"));
                    }
                } elseif ($status == 'delete') {
//Delete Data
                    $result = DB::table('request')->where('student_email', $s_email)->delete();
                    if ($result) {
                        echo json_encode(array("status" => TRUE, "msg" => "Delete Successfully", 'email' => $request->input('email')));
                    } else {
                        echo json_encode(array("status" => FALSE, "msg" => "Something Wrong"));
                    }
                }
                die();
            }
//-------------- Get Tutor Details  ---------------------//
            if ($name == 'get_tutor_details') {
                $email = $request->input('email');
                $data = DB::table('tutor_registration')
                        ->select("users.*", "tutor_registration.*", "subject.subject_name", DB::raw("IFNULL(users.username, 'Unnamed Tutor') as `username`"))
                        ->selectRaw('(SELECT IFNULL(FORMAT(((round(2*avg(rate),0))/2),1),0)*1 FROM ratings WHERE ratings.tutor_email=tutor_registration.email AND ratings.rate!=0) as rate')
                        ->join('users', 'users.email', '=', 'tutor_registration.email')
                        ->join('subject', 'subject.id', '=', 'tutor_registration.subject')
                        ->where('tutor_registration.email', $email)
                        ->where('users.type', 'tutor')
                        ->get();
                if ($data) {
                    echo json_encode(array("status" => TRUE, "data" => $data, "msg" => "data get Successfully"));
                } else {
                    echo json_encode(array("status" => FALSE, "msg" => "Something Wrong"));
                }
                die();
            }
//-------------- Get Student Details  ---------------------//
            if ($name == 'get_student_details') {
                $email = $request->input('email');
                $data = DB::table('users')
                        ->select('student_registration.mobile_no', DB::raw("IFNULL(users.username, 'Unnamed Student') as `username`"), 'student_registration.standard', 'student_registration.location', 'users.*')
                        ->leftjoin('student_registration', 'student_registration.email', 'users.email')
                        ->where('users.email', $email)
                        ->where('users.type', 'student')
                        ->get();
                if ($data) {
                    echo json_encode(array("status" => TRUE, "data" => $data, "msg" => "data get Successfully"));
                } else {
                    echo json_encode(array("status" => FALSE, "msg" => "Something Wrong"));
                }
                die();
            }
//-------------- Forgot Password  ---------------------//
            if ($name == 'forgot_password') {
                $email = $request->input('email');
                $type = $request->input('type');
                $data = array(
                    'password' => md5($request->input('password'))
                );
                try {
                    $result = DB::table('users')->where('email', $email)->where('type', $type)->update($data);

                    echo json_encode(array("status" => TRUE, "msg" => "data Update Sucessfully"));
                } catch (\Illuminate\Database\QueryException $e) {

                    echo json_encode(array("status" => FALSE, "msg" => "Something Wrong"));
                }
                die();
            }
//--------------  My Tutor  ---------------------//
            if ($name == 'my_tutor') {
                $email = $request->input('email');
                $data = DB::table('users')
                        ->select('request.*', DB::raw("IFNULL(users.username, 'Unnamed Student') as `username`"), 'users.image', 'payment_transaction.transaction_id', 'payment_transaction.amount', 'payment_transaction.datetime', DB::raw('group_concat(DISTINCT(subject.subject_name)) as sname'), 'tutor_registration.location', 'tutor_registration.mobile_no', DB::raw('group_concat(DISTINCT(standard.std)) as std_name'), DB::raw('(SELECT case when (COUNT(pt.id) = 1) THEN "Paid" ELSE "Pending" END FROM payment_transaction pt WHERE pt.tutor_email=request.tutor_email AND pt.student_email=request.student_email AND MONTH(pt.datetime) = MONTH(CURRENT_DATE())) as status'))
                        ->leftjoin('tutor_registration', 'users.email', 'tutor_registration.email')
                        ->rightjoin('request', 'users.email', 'request.tutor_email')
                        ->join('subject', DB::raw('find_in_set(subject.id, request.subject)'), '>', DB::raw("'0'"))
                        ->join('standard', DB::raw('find_in_set(standard.id, tutor_registration.standard)'), '>', DB::raw("'0'"))
                        ->leftjoin('payment_transaction', 'payment_transaction.tutor_email', 'users.email')
                        ->where('users.type', 'tutor')
                        ->where('request.student_email', $email)
                        ->where('request.status', 'accept')
                        ->groupBy('request.id')
                        ->get();
                if (count($data) >= 1) {
                    echo json_encode(array("status" => TRUE, "data" => $data, "msg" => "data get Sucessfully"));
                } else {
                    echo json_encode(array("status" => TRUE, "msg" => "Data Not Found"));
                }
                die();
            }
//--------------  My Student  ---------------------//
            if ($name == 'my_student') {
                $email = $request->input('email');
                // \DB::enableQueryLog();
                $data = DB::table('users')
                        ->select('request.*', DB::raw("IFNULL(users.username, 'Unnamed Student') as `username`"), 'users.image', DB::raw('group_concat(DISTINCT(subject.subject_name)) as sname'), 'student_registration.location', 'student_registration.standard', 'student_registration.mobile_no', DB::raw('(SELECT case when (COUNT(pt.id) = 1) THEN "Paid" ELSE "Pending" END FROM payment_transaction pt WHERE pt.tutor_email=request.tutor_email AND pt.student_email=request.student_email) as status'))
                        ->leftjoin('student_registration', 'users.email', 'student_registration.email')
                        ->rightjoin('request', 'users.email', 'request.student_email')
                        ->join('subject', DB::raw('find_in_set(subject.id, request.subject)'), '>', DB::raw("'0'"))
                        ->leftjoin('payment_transaction', 'payment_transaction.student_email', 'users.email')
                        ->where('users.type', 'student')
                        ->where('request.tutor_email', $email)
                        ->where('request.status', 'accept')
                        ->groupBy('request.id')
                        ->get();
                // dd(\DB::getQueryLog());
                if (count($data) >= 1) {
                    echo json_encode(array("status" => TRUE, "data" => $data, "msg" => "data get Sucessfully"));
                } else {
                    echo json_encode(array("status" => TRUE, "msg" => "Data Not Found"));
                }
                die();
            }
//--------------  My Request  ---------------------//
            if ($name == 'my_request') {
                $email = $request->input('email');

                $data = DB::select('select `request`.*, IFNULL(users.username, "Unnamed Student") as `username`, `users`.`image`, group_concat(DISTINCT  subject.subject_name) as sname, `tutor_registration`.`location`, `tutor_registration`.`mobile_no` from `users` left join `tutor_registration` on `users`.`email` = `tutor_registration`.`email` right join `request` on `users`.`email` = `request`.`tutor_email` inner join `subject` on find_in_set(subject.id, request.subject) > "0" where `users`.`type` = "tutor" and `request`.`student_email` = "' . $email . '" and (`request`.`status` != "accpet" or `request`.`status` is null) group by `request`.`id`');

                if (count($data) >= 1) {
                    echo json_encode(array("status" => TRUE, "data" => $data, "msg" => "data get Sucessfully"));
                } else {
                    echo json_encode(array("status" => TRUE, "msg" => "Data Not Found"));
                }
                die();
            }
//-------------- Update Student Lat Long  ---------------------//
            if ($name == 'update_student_lat_long') {
                $email = $request->input('email');
                $latitude = $request->input('latitude');
                $longitude = $request->input('longitude');
//Update Data
                $data = array(
                    'email' => $email,
                    'latitude' => $latitude,
                    'longitude' => $longitude
                );
                $get_data = DB::table('student_registration')
                        ->where('email', $email)
                        ->get();

                $count = count($get_data);
                if ($count == 0) {
                    $results = DB::table('student_registration')->insert($data);
                    echo json_encode(array("status" => TRUE, "msg" => "Insert Successfully", "email" => $email));
                } else {
                    try {
                        $results = DB::table('student_registration')->where('email', $email)->update($data);
                        echo json_encode(array("status" => TRUE, "msg" => "Update Successfully", "email" => $email));
                    } catch (\Illuminate\Database\QueryException $e) {
                        echo json_encode(array("status" => FALSE, "msg" => "Something Wrong"));
                    }
                }
                die();
            }
//--------------  Nearby Tutor  ---------------------//
            if ($name == 'nearby_tutor') {
                $email = $request->input('email');
                $latitude = $request->input('latitude');
                $longitude = $request->input('longitude');
                $distance = DB::table('setting')
                        ->select("distance")
                        ->first();
                $dis = $distance->distance;
				// print_r($dis);
                //\DB::enableQueryLog();
                $haversine = "round(
    6371 * acos(
        cos(radians(" . $latitude . "))
        * cos(radians(`latitude`))
        * cos(radians(`longitude`) - radians(" . $longitude . "))
        + sin(radians(" . $latitude . ")) * sin(radians(`latitude`))
    )
,2)";

                $data = DB::table("tutor_registration")->select("tutor_registration.*", DB::raw("IFNULL(users.username, 'Unnamed Tutor') as `username`"), 'users.image')
                        ->selectRaw("$haversine AS distance")
                        ->join('users', 'users.email', 'tutor_registration.email')
						->where('users.type','=','tutor')
                        ->having("distance", "<=", $dis)
                        ->orderby("distance", "desc")
                        ->limit(10)
                        ->get();
                //dd(\DB::getQueryLog());    

                if (count($data) >= 1) {
                    echo json_encode(array("status" => TRUE, "data" => $data, "msg" => "data get Sucessfully"));
                } else {
                    echo json_encode(array("status" => TRUE, "msg" => "Data Not Found"));
                }
                die();
            }
//-------------- Get Hours Availability  ---------------------//
            if ($name == 'get_hours_availability') {
                $email = $request->input('email');

                $data = DB::table('hours_availability')
                        ->select('*')
                        ->get();
                if (count($data) >= 1) {
                    echo json_encode(array("status" => TRUE, "data" => $data, "msg" => "data get Sucessfully"));
                } else {
                    echo json_encode(array("status" => TRUE, "msg" => "Data Not Found"));
                }
                die();
            }
//-------------- Get Payment Details ------------------------//
            if ($name == 'get_payment_details') {
                $student_email = $request->input('email');
                $tutor_email = $request->input('tutor_email');
                $data = DB::table('request')
                        ->select('fees')
                        ->where('tutor_email', $tutor_email)
                        ->where('student_email', $student_email)
                        ->get();
                $fees = 100;
                $arr = explode(',', $fees);
				$stripe_key = DB::table('setting')
                        ->select("stripe_client_key", "stripe_public_key")
                        ->first();
                $stripe_client_key = $stripe_key->stripe_client_key;
                $stripe_public_key = $stripe_key->stripe_public_key;

                $stripe = new \Stripe\StripeClient($stripe_client_key);
                $customer = $stripe->customers->create();
                // creating setup intent
                $paymentIntent = $stripe->paymentIntents->create([
                    'payment_method_types' => ['card'],
                    'customer' => $customer->id,
                    // convert double to integer for stripe payment intent, multiply by 100 is required for stripe
                    'amount' => array_sum($arr),
                    'currency' => 'usd',
                ]);
                echo json_encode(array("status" => TRUE, "data" => [
                        'paymentIntent' => $paymentIntent->client_secret,
                        'secretKey' => $stripe_client_key,
                        'customer' => $customer->id,
                        'publishableKey' => $stripe_public_key
                    ], "msg" => "data get Sucessfully")
                );
                die();
            }
//-------------- Set Payment Details ------------------------//
            if ($name == 'set_payment_details') {
                $student_email = $request->input('email');
                $tutor_email = $request->input('tutor_email');
                $transaction_id = $request->input('transaction_id');
                $data1 = DB::table('request')
                        ->select('fees', 'subject')
                        ->where('tutor_email', $tutor_email)
                        ->where('student_email', $student_email)
                        ->get();
                $fees = $data1[0]->fees;
                $arr = explode(',', $fees);
                $subject = $data1[0]->subject;
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

                $notification = DB::table('setting')
                        ->select('notification_status')
                        ->get();
                $status = $notification[0]->notification_status;
                if ($status == 'true') {
                    $data = DB::table('users')
                            ->select('fcm_token', 'username')
                            ->where('email', $tutor_email)
                            ->where('type', 'tutor')
                            ->first();
                    //print_r($data);
                    $username = $data->username;
                    if (!empty($data)) {

                        $notification = ["body" => "Request",
                            "title" => $username . " tuition fees Paid",
                            "content_available" => true,
                            "sound" => "default",
                            "priority" => "high",
                            "notification_name" => "payment successful",
                            "fees" => array_sum($arr)];
                        $data = array($data->fcm_token);

                        $jsonString = $this->sendPushNotificationToGCMSever($data, $notification, "You Student Pay Fees", "Fees Payment");
                        $jsonObject = json_decode($jsonString);
                        $jsonObject = json_decode(json_encode($jsonObject), TRUE);

                        $fcmResult = array("fcm_multicast_id" => $jsonObject['multicast_id'],
                            "fcm_success" => $jsonObject['success'],
                            "fcm_failure" => $jsonObject['failure'],
                            "fcm_error" => json_encode(array_column($jsonObject['results'], 'error')),
                            "fcm_type" => "Fees Payment",
                        );
                        DB::table('firebase_results')->insert($fcmResult);
                    }
                }
                if ($result) {
                    echo json_encode(array("status" => TRUE, "msg" => "Insert Successfully"));
                } else {
                    echo json_encode(array("status" => FALSE, "msg" => "Something Wrong"));
                }
                die();
            }
//-------------- Send Payment Request ------------------------// 
            if ($name == 'send_payment_request') {
                $tutor_email = $request->input('email');
                $student_email = $request->input('student_email');
                $notification = DB::table('setting')
                        ->select('notification_status')
                        ->get();
                $data1 = DB::table('request')
                        ->select('fees', 'subject')
                        ->where('tutor_email', $tutor_email)
                        ->where('student_email', $student_email)
                        ->get();

                $fees = $data1[0]->fees;
                $arr = explode(',', $fees);
                $status = $notification[0]->notification_status;
                if ($status == 'true') {
                    $data = DB::table('users')
                            ->select('fcm_token', 'username')
                            ->where('email', $student_email)
                            ->where('type', 'student')
                            ->first();
                    //print_r($data);
                    $username = $data->username;
                    if (!empty($data)) {

                        $notification = ["body" => "Request",
                            "title" => $username . " has requested tuition fees payment",
                            "content_available" => true,
                            "sound" => "default",
                            "priority" => "high",
                            "data" => $tutor_email,
                            "notification_name" => "request payment",
                            "fees" => array_sum($arr)];
                        $data = array($data->fcm_token);

                        $jsonString = $this->sendPushNotificationToGCMSever($data, $notification, "You Tutor Send Payment Request", "Student Request");
                        $jsonObject = json_decode($jsonString);
                        $jsonObject = json_decode(json_encode($jsonObject), TRUE);

                        $fcmResult = array("fcm_multicast_id" => $jsonObject['multicast_id'],
                            "fcm_success" => $jsonObject['success'],
                            "fcm_failure" => $jsonObject['failure'],
                            "fcm_error" => json_encode(array_column($jsonObject['results'], 'error')),
                            "fcm_type" => "Send Request",
                        );
                        DB::table('firebase_results')->insert($fcmResult);
                    }
                }
                if ($fcmResult) {
                    echo json_encode(array("status" => TRUE, "msg" => "Send Notification.."));
                } else {
                    echo json_encode(array("status" => FALSE, "msg" => "Something Wrong"));
                }
                die();
            }
        } else {
            $response['status'] = false;
            $response['msg'] = "Unknown request";
            echo json_encode($response);
            die();
        }
    }

    function Auth($apiname, $email) {
        $request_auth = getallheaders();
        $request_auth = $request_auth['token'];
        $Id = '260898';
        $jwt = hash('sha256', $Id . $apiname . $email);
       // echo $jwt;
        if ($request_auth == $jwt) {
            return TRUE;
        } else {
            return FALSE;
        }
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

?>
