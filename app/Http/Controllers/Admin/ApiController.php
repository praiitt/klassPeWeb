<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Session;
use Validator;
use Auth;

class ApiController extends Controller {

    function index(Request $request) {

        $request_auth = getallheaders();
        if (!empty($request_auth['Authorization'])) {
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
                        $pass = md5($request->input('password'));
                        $type = $request->input('type');
                        $data = DB::select('select id,username,image,type from users where email=? and password=? and type=?', [$name, $pass, $type]);
                        if (empty($data[0]->username) && $data[0]->type == 'tutor') {
                            $username = 'Unnamed Tutor';
                        } elseif (empty($data[0]->username) && $data[0]->type == 'student') {
                            $username = 'Unnamed Student';
                        } else {
                            $username = $data[0]->username;
                        }
                        if (count($data)) {
                            echo json_encode(array("status" => TRUE, "msg" => "Login Successfully", "username" => $username, "type" => $data[0]->type, "image" => $data[0]->image));
                        } else {
                            echo json_encode(array("status" => FALSE, "msg" => "Authentication Fail..!!"));
                        }
                    }
                } else {
//Post Data
                    $data = array(
                        'username' => $request->input('username'),
                        'email' => $request->input('email'),
                        'image' => $request->input('image'),
                        'user_type' => $request->input('user_type'),
                        "firebase_id" => $request->input('firebase_id'),
                        "fcm_token" => $request->input('fcm_token'),
                        "password" => md5($request->input('password')),
                        'type' => $request->input('type'),
                    );
//Insert Data
                    $result = DB::table('users')->insert($data);
                    if ($result) {

                        echo json_encode(array("status" => TRUE, "msg" => "Insert Successfully", 'username' => $request->input('username'), 'ImageUrl' => $request->input('image'), 'email' => $request->input('email'), "type" => $request->input('type')));
                    } else {
                        echo json_encode(array("status" => FALSE, "msg" => "Something Wrong"));
                    }
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
                        "latitude" => $request->input('latitude'),
                        "longitude" => $request->input('longitude'),
                        "tuition_type" => $request->input('tuition_type')
                    );
                    $datas = array(
                        'username' => $request->input('username')
                    );
                    try {
                        $result1 = DB::table('users')->where('email', $email)->update($datas);
                        $result = DB::table('tutor_registration')->where('email', $email)->update($data);
                        echo json_encode(array("status" => TRUE, "msg" => "Update Successfully", "email" => $email));
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
                        echo json_encode(array("status" => TRUE, "msg" => "Insert Successfully", 'email' => $request->input('email')));
                    } else {
                        echo json_encode(array("status" => FALSE, "msg" => "Something Wrong"));
                    }
                }
            }
//-------------- Update Fcm Token  ---------------------//
            if ($name == 'update_fcm_token') {

                $email = $request->input('email');
                $record = array(
                    "fcm_token" => $request->input('fcm_token')
                );
                try {
                    $result = DB::table('users')->where('email', $email)->update($record);
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
                    $request = DB::table('request')
                            ->select('request.*', DB::raw('group_concat(DISTINCT(subject.subject_name)) as sname'))
                            ->join('subject', DB::raw('find_in_set(subject.id, request.subject)'), '>', DB::raw("'0'"))
                            ->where('status', 'accept')
                            ->where('student_email', $email)
                            ->get();
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
                        'status' => NULL
                    );
                    try {
                        $result = DB::table('request')->where('id', $request[0]->id)->where('tutor_email', $t_email)->update($data);

                        echo json_encode(array("status" => TRUE, "msg" => "data Update Sucessfully"));
                    } catch (\Illuminate\Database\QueryException $e) {

                        echo json_encode(array("status" => FALSE, "msg" => "Something Wrong"));
                    }
                } else {
                    $data = array(
                        'tutor_email' => $t_email,
                        'student_email' => $s_email,
                        'subject' => rtrim($subject, ','),
                        'fees' => $fees
                    );

                    $result = DB::table('request')->insert($data);

                    if ($result) {
                        echo json_encode(array("status" => TRUE, "msg" => "data Insert Sucessfully"));
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
                $data = DB::table('tutor_registration')
                        ->select("users.*", "tutor_registration.*", "subject.subject_name", DB::raw("IFNULL(username, 'Unnamed Tutor') as `username`"))
                        ->selectRaw('(SELECT IFNULL(FORMAT(((round(2*avg(rate),0))/2),1),0)*1 FROM ratings WHERE ratings.tutor_email=tutor_registration.email AND ratings.rate!=0) as rate')
                        ->join('users', 'users.email', '=', 'tutor_registration.email')
                        ->join('subject', 'subject.id', '=', 'tutor_registration.subject')
                        ->where('tutor_registration.email', $t_email)
                        ->where('users.type', 'tutor')
                        ->get();
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

                $data = DB::table('ratings')
                        ->select('ratings.*', DB::raw("IFNULL(username, 'Unnamed Tutor') as `username`"), 'users.image', 'tutor_registration.id as iid', DB::raw('ROUND(AVG(rate),1) as rating'))
                        ->join('users', 'ratings.tutor_email', 'users.email')
                        ->join('tutor_registration', 'ratings.tutor_email', 'tutor_registration.email')
                        ->where('users.type', 'tutor')
                        ->groupby('tutor_email')
                        ->orderby('ratings.rate', 'DESC')
                        ->get();
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
                        ->select('tutor_registration.*', DB::raw("IFNULL(users.username, 'Unnamed Tutor') as `username`"), 'users.image', DB::raw('group_concat(subject.subject_name) as sname'))
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

                $data = DB::table('users')
                        ->select('request.*', DB::raw("IFNULL(users.username, 'Unnamed Student') as `username`"), 'users.image', DB::raw('group_concat(subject.subject_name) as sname'), 'student_registration.location', 'student_registration.standard', 'student_registration.mobile_no')
                        ->leftjoin('student_registration', 'users.email', 'student_registration.email')
                        ->rightjoin('request', 'users.email', 'request.student_email')
                        ->join('subject', DB::raw('find_in_set(subject.id, request.subject)'), '>', DB::raw("'0'"))
                        ->where('users.type', 'student')
                        ->where('request.tutor_email', $email)
                        ->where('request.status', null)
                        ->groupBy('request.id')
                        ->get();

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
                        ->select('request.*', DB::raw("IFNULL(users.username, 'Unnamed Student') as `username`"), 'users.image', DB::raw('group_concat(subject.subject_name) as sname'), 'tutor_registration.location', 'tutor_registration.mobile_no')
                        ->leftjoin('tutor_registration', 'users.email', 'tutor_registration.email')
                        ->rightjoin('request', 'users.email', 'request.tutor_email')
                        ->join('subject', DB::raw('find_in_set(subject.id, request.subject)'), '>', DB::raw("'0'"))
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

                $data = DB::table('users')
                        ->select('request.*', DB::raw("IFNULL(users.username, 'Unnamed Student') as `username`"), 'users.image', DB::raw('group_concat(subject.subject_name) as sname'), 'student_registration.location', 'student_registration.standard', 'student_registration.mobile_no')
                        ->leftjoin('student_registration', 'users.email', 'student_registration.email')
                        ->rightjoin('request', 'users.email', 'request.student_email')
                        ->join('subject', DB::raw('find_in_set(subject.id, request.subject)'), '>', DB::raw("'0'"))
                        ->where('users.type', 'student')
                        ->where('request.tutor_email', $email)
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
//--------------  My Request  ---------------------//
            if ($name == 'my_request') {
                $email = $request->input('email');

                $data = DB::table('users')
                        ->select('request.*', DB::raw("IFNULL(users.username, 'Unnamed Student') as `username`"), 'users.image', DB::raw('group_concat(subject.subject_name) as sname'), 'tutor_registration.location', 'tutor_registration.mobile_no')
                        ->leftjoin('tutor_registration', 'users.email', 'tutor_registration.email')
                        ->rightjoin('request', 'users.email', 'request.tutor_email')
                        ->join('subject', DB::raw('find_in_set(subject.id, request.subject)'), '>', DB::raw("'0'"))
                        ->where('users.type', 'tutor')
                        ->where('request.student_email', $email)
                        ->where('request.status', NULL)
                        ->groupBy('request.id')
                        ->get();
                if (count($data) >= 1) {
                    echo json_encode(array("status" => TRUE, "data" => $data, "msg" => "data get Sucessfully"));
                } else {
                    echo json_encode(array("status" => TRUE, "msg" => "Data Not Found"));
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
        $request_auth = $request_auth['Authorization'];
        $Id = '260898';
        $jwt = hash('sha256', $Id . $apiname . $email);
        //echo $jwt;
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

}
