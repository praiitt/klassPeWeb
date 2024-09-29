<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Session;
use Validator;
use Auth;

class TutorController extends Controller {

    function index(Request $request) {
        if (Session()->get('web_username')) {
            
        } else {
            return redirect('/');
        }
        $username = session()->get('web_username');
//        DB::enableQueryLog();
        $data = DB::table('tutor_registration')
                ->select('tutor_registration.*', DB::raw("IFNULL(users.username, 'Unnamed Tutor') as `username`"), 'users.image', DB::raw('group_concat(subject.subject_name) as sname'))
                ->join('subject', DB::raw('find_in_set(subject.id, tutor_registration.subject)'), '>', DB::raw("'0'"))
                ->join('users', 'users.email', 'tutor_registration.email')
                ->where('users.email', $username)
                ->groupBy('tutor_registration.id')
                ->get();
//        dd(DB::getQueryLog());
        $subject = DB::table('subject')
                ->select('*')
                ->get();
        $standard = DB::table('standard')
                ->select('*')
                ->get();
        $rate = DB::table('ratings')
                ->select(DB::raw('ROUND(AVG(rate),1) as rating'))
                ->where('tutor_email', $username)
                ->get();
        $m_hours = DB::table('hours_availability')
                ->select('*')
                ->where('session', 'am')
                ->orderby('id', 'ASC')
                ->get();
        $a_hours = DB::table('hours_availability')
                ->select('*')
                ->where('session', 'pm')
                ->orderby('id', 'ASC')
                ->get();
        return view('tutor-profile', ['getdata' => $data, 'subject' => $subject, 'standard' => $standard, 'rate' => $rate, 'm_hours' => $m_hours, 'a_hours' => $a_hours]);
    }

    function tutor_update(Request $request) {
        $email = session()->get('web_username');
        $username = $request->input('username');
        $mob_no = $request->input('mob_no');
        $location = $request->input('location');
        $year_of_experience = $request->input('year_of_experience');
        $std = $request->input('std');
        $subject = $request->input('subject');
        $fees = $request->input('fees');
        $tuition_type = $request->input('tuition_type');
        $a_hours = $request->input('a_hours');
        $m_hours = $request->input('m_hours');
        $data = array(
            'username' => $username
        );
        $sub_count = preg_split("/\,/", rtrim($subject, ','));
        $fees_count = preg_split("/\,/", rtrim($fees, ','));

        if (count($fees_count) == count($sub_count)) {
            $student = array(
                'email' => $email,
                'mobile_no' => $mob_no,
                'location' => $location,
                'year_of_experience' => $year_of_experience,
                'standard' => rtrim($std, ','),
                'subject' => rtrim($subject, ','),
                'monthly_fees' => rtrim($fees, ','),
                'tuition_type' => $tuition_type,
                'a_hours' => rtrim($a_hours, ','),
                'm_hours' => rtrim($m_hours, ',')
            );
//        print_r($student);
            $result = DB::table('users')->where('email', $email)->update($data);
            $get_data = DB::table('tutor_registration')
                    ->where('email', $email)
                    ->get();
            $count = count($get_data);
            if ($count == 0) {
                $results = DB::table('tutor_registration')->insert($student);
            } else {
                $results = DB::table('tutor_registration')->where('email', $email)->update($student);
            }
        } else {
            echo "1";
        }
    }

    function tutor_image(Request $request) {
        $email = session()->get('web_username');
        $image = $request->file('file');
        $new_name = rand() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('TutorImages'), $new_name);
        $data = array(
            'image' => url('public/TutorImages/' . $new_name)
        );
        $result = DB::table('users')->where('email', $email)->update($data);
        echo $result;
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
        $m_hours = DB::table('hours_availability')
                ->select('*')
                ->where('session', 'am')
                ->orderby('id', 'ASC')
                ->get();
        $a_hours = DB::table('hours_availability')
                ->select('*')
                ->where('session', 'pm')
                ->orderby('id', 'ASC')
                ->get();
        return view('tutor-registration', ['subject' => $subject, 'standard' => $standard, 'm_hours' => $m_hours, 'a_hours' => $a_hours]);
    }

    function insert_registration(Request $request) {
        $tuition_type = $request->input('tuition_type');
        $a_hours = !empty($request->input('a_hours')) ? implode(",", $request->input('a_hours')) : '';
        $m_hours = !empty($request->input('m_hours')) ? implode(",", $request->input('m_hours')) : '';


        if (!empty($tuition_type)) {
            if (!empty($a_hours) || !empty($m_hours)) {
                if (!empty($request->input('subject_id')) && !empty($request->input('fees'))) {
                    if (!empty($request->input('fees'))) {
                        $std = $request->input('standard');
                        $subject = $request->input('subject_id');
                        $fees = $request->input('fees');
                        $university = $request->input('university');
                        $location = $request->input('location');
                        $year_of_experience = $request->input('year_of_experience');
                        $email = session()->get('web_username');
                        $loc_latitude = $request->input('loc_latitude');
                        $loc_longitude = $request->input('loc_longitude');
                        $data = array(
                            'email' => $email,
                            'standard' => implode(",", $std),
                            'subject' => implode(",", $subject),
                            'monthly_fees' => implode(",", $fees),
                            'university' => $university,
                            'location' => $location,
                            'longitude' => $loc_longitude,
                            'latitude' => $loc_latitude,
                            'year_of_experience' => $year_of_experience,
                            'tuition_type' => $tuition_type,
                            'a_hours' => $a_hours,
                            'm_hours' => $m_hours
                        );
//        print_r($data);
                        $results = DB::table('tutor_registration')->insert($data);
                        return redirect('Tutor_profile');
                    } else {
                        return redirect('Tutor_registration')->with('message', '<div class="alert alert-warning">Registration Fail..! Please Add Subject Fees.</div>');
                    }
                } else {
                    return redirect('Tutor_registration')->with('message', '<div class="alert alert-warning">Registration Fail..! Please Select Maximum 3 Subject!</div>');
                }
            } else {
                return redirect('Tutor_registration')->with('message', '<div class="alert alert-warning">Registration Fail..! Please Select Hours of Availability...</div>');
            }
        } else {
            return redirect('Tutor_registration')->with('message', '<div class="alert alert-warning">Registration Fail..! Please Select Tuition Type!</div>');
        }
    }

    function find_tutor(Request $request) {
        if (Session()->get('web_username')) {
            
        } else {
            return redirect('/');
        }
        $username = session()->get('web_username');
        $data = DB::table('users')
                ->select('student_registration.mobile_no', 'student_registration.standard', 'student_registration.location', 'users.*', 'student_registration.latitude', 'student_registration.longitude')
                ->leftjoin('student_registration', 'student_registration.email', 'users.email')
                ->where('users.email', $username)
                ->where('users.type', 'student')
                ->get();
//        print_r($data[0]->latitude);
        $subject = DB::table('subject')
                ->select('*')
                ->get();

        $popular = DB::table('ratings')
                ->select('ratings.*', DB::raw("IFNULL(users.username, 'Unnamed Tutor') as `username`"), 'users.image', 'tutor_registration.id as iid', DB::raw('ROUND(AVG(rate),1) as rating'))
                ->join('users', 'ratings.tutor_email', 'users.email')
                ->join('tutor_registration', 'ratings.tutor_email', 'tutor_registration.email')
                ->groupby('tutor_email')
                ->orderby('ratings.rate', 'DESC')
                ->limit('5')
                ->get();
        $pop_tutor = DB::table('tutor_registration')
                ->select('tutor_registration.*', DB::raw("IFNULL(users.username, 'Unnamed Tutor') as `username`"), 'users.image', DB::raw('group_concat(subject.subject_name) as sname'))
                ->join('subject', DB::raw('find_in_set(subject.id, tutor_registration.subject)'), '>', DB::raw("'0'"))
                ->join('users', 'users.email', 'tutor_registration.email')
                ->where('users.type', 'tutor')
                ->groupBy('tutor_registration.id')
                ->get();
        $side = DB::table('users')
                ->select('users.*')
                ->where('users.email', $username)
                ->first();
        $latitude = !empty($data[0]->latitude) ? $data[0]->latitude : '0';
        $longitude = !empty($data[0]->longitude) ? $data[0]->longitude : '0';
        $distance = DB::table('setting')
                ->select("distance")
                ->first();
        $dis = $distance->distance;
        $haversine = "round(
    6371 * acos(
        cos(radians(" . $latitude . "))
        * cos(radians(`latitude`))
        * cos(radians(`longitude`) - radians(" . $longitude . "))
        + sin(radians(" . $latitude . ")) * sin(radians(`latitude`))
    )
,2)";
//\DB::enableQueryLog();
        $nearby = DB::table("tutor_registration")->select(DB::raw("tutor_registration.*,IFNULL(users.username, 'Unnamed Tutor') as `username`"), 'users.image')
                ->selectRaw("$haversine AS distance")
                ->join('users', 'users.email', 'tutor_registration.email')
                ->having("distance", "<=", $dis)
                ->where('users.type', 'tutor')
                ->orderby("distance", "desc")
                ->limit(10)
                ->get();
//dd(\DB::getQueryLog());
        $all_tutor = DB::table('tutor_registration')
                ->select('tutor_registration.*', DB::raw("IFNULL(users.username, 'Unnamed Tutor') as `username`"), 'users.image')
                ->join('users', 'users.email', 'tutor_registration.email')
                ->where('users.type', 'tutor')
                ->get();

        return view('find-tutor', ['getdata' => $data, 'subject' => $subject, 'popular' => $popular, 'pop_tutor' => $pop_tutor, 'side' => $side, 'nearby' => $nearby, 'all_tutor' => $all_tutor]);
    }

    function request_tutor(Request $request) {
        $tutor_email = $request->input('tutor_name');
        $student_email = session()->get('web_username');
        $subject = $request->input('subject');
        $fees = $request->input('fees');
        $tuition_type = $request->input('tuition_type');
        $m_hours = $request->input('m_hours');
        $a_hours = $request->input('a_hours');
        $request = DB::table('request')
                ->select('request.*')
                ->where('request.tutor_email', $tutor_email)
                ->where('request.student_email', $student_email)
                ->first();
        //print_r($request);
        if (empty($request)) {
            $data = array(
                'tutor_email' => $tutor_email,
                'student_email' => $student_email,
                'subject' => rtrim($subject, ','),
                'fees' => $fees,
                'tuition_type' => $tuition_type,
                'a_hours' => rtrim($a_hours, ','),
                'm_hours' => rtrim($m_hours, ',')
            );
            $results = DB::table('request')->insert($data);
            if ($results) {
                echo "1";
            } else {
                echo "0";
            }
        } else {
            $data = array(
                'tutor_email' => $tutor_email,
                'student_email' => $student_email,
                'subject' => rtrim($subject, ','),
                'fees' => $fees,
                'tuition_type' => $tuition_type,
                'a_hours' => rtrim($a_hours, ','),
                'm_hours' => rtrim($m_hours, ',')
            );

            try {
                $results = DB::table('request')->where('id', $request->id)->update($data);
                echo "1";
            } catch (\Illuminate\Database\QueryException $e) {
                echo "0";
            }
        }
    }

    function get_subject_tutor(Request $request) {
        $type = $request->input('type');
        $username = session()->get('web_username');

        $id = $request->input('id');
        $ids = explode(',', $id);
        $count = count($ids);
        $find = '';
        for ($i = 0; $i < $count; $i++) {
            $find .= 'find_in_set(' . $ids[$i] . ',subject)';
            $find .= ' OR ';
        }
        $finds = rtrim($find, " OR ");
        $data = array();
        if ($type == 'nav-profile-tab') { //Near By Tutor
           
            $data1 = DB::table('users')
                    ->select('student_registration.mobile_no', 'student_registration.standard', 'student_registration.location', 'users.*', 'student_registration.latitude', 'student_registration.longitude')
                    ->leftjoin('student_registration', 'student_registration.email', 'users.email')
                    ->where('users.email', $username)
                    ->where('users.type', 'student')
                    ->get();
            $side = DB::table('users')
                    ->select('users.*')
                    ->where('users.email', $username)
                    ->first();
            $latitude = !empty($data1[0]->latitude) ? $data1[0]->latitude : '0';
            $longitude = !empty($data1[0]->longitude) ? $data1[0]->longitude : '0';
            $distance = DB::table('setting')
                    ->select("distance")
                    ->first();
            $dis = $distance->distance;
            $haversine = "round(
    6371 * acos(
        cos(radians(" . $latitude . "))
        * cos(radians(`latitude`))
        * cos(radians(`longitude`) - radians(" . $longitude . "))
        + sin(radians(" . $latitude . ")) * sin(radians(`latitude`))
    )
,2)";
//            \DB::enableQueryLog();
            $data = DB::table("tutor_registration")->select(DB::raw("tutor_registration.*,IFNULL(users.username, 'Unnamed Tutor') as `username`"), 'users.image', DB::raw('group_concat(subject.subject_name) as sname'))
                    ->selectRaw("$haversine AS distance")
                    ->join('subject', DB::raw('find_in_set(subject.id, tutor_registration.subject)'), '>', DB::raw("'0'"))
                    ->join('users', 'users.email', 'tutor_registration.email')
                    ->groupby('tutor_registration.id')
                    ->having("distance", "<=", $dis)
                    ->where('users.type', 'tutor')
                    ->whereRaw($finds)
                    ->orderby("distance", "desc")
                    ->limit(10)
                    ->get();
            
//            dd(\DB::getQueryLog());
        } elseif ($type == 'nav-contact-tab') { //popular
//             \DB::enableQueryLog();
            $data = DB::table('ratings')
                    ->select('ratings.*', DB::raw("IFNULL(users.username, 'Unnamed Tutor') as `username`"), 'users.image', 'tutor_registration.id as iid', DB::raw('ROUND(AVG(rate),1) as rating'), DB::raw('group_concat(DISTINCT(subject.subject_name)) as sname'))
                    ->join('users', 'ratings.tutor_email', 'users.email')
                    ->join('tutor_registration', 'ratings.tutor_email', 'tutor_registration.email')
                    ->join('subject', DB::raw('find_in_set(subject.id, tutor_registration.subject)'), '>', DB::raw("'0'"))
                    ->whereRaw($finds)
                    ->groupby('tutor_email')
                    ->orderby('ratings.rate', 'DESC')
                    ->limit('5')
                    ->get();
//            dd(\DB::getQueryLog());
        } else {

            
            $data = DB::table('tutor_registration')
                    ->select('tutor_registration.*', DB::raw("IFNULL(users.username, 'Unnamed Tutor') as `username`"), 'users.image', DB::raw('group_concat(subject.subject_name) as sname'))
                    ->join('subject', DB::raw('find_in_set(subject.id, tutor_registration.subject)'), '>', DB::raw("'0'"))
                    ->join('users', 'users.email', 'tutor_registration.email')
                    ->where('users.type', 'tutor')
                    ->whereRaw($finds)
                    ->groupBy('tutor_registration.id')
                    ->get();
        }
//        dd(\DB::getQueryLog());

        if (count($data) == 0) {
            $output = '';
            $output .= '<div class = "col-auto col-centered mr-4">';
            $output .= '<center>';
            $output .= '<img src="public/assets/img/no-data.png" class="rounded shadow-sm">';
            $output .= '</center>';
            $output .= '</div>';
            print_r($output);
        } else {
            foreach ($data as $datas) {
                $string = (strlen($datas->username) > 13) ? substr($datas->username, 0, 10) . '...' : $datas->username;

                $myString = $datas->sname;
                $subject = str_replace(",", " | ", $myString);
                $output = '';
                $output .= '<div class = "col-auto col-centered mr-4">';
                $output .= '<a href = "' . url('Tutor_details', $datas->id) . '">';
                $output .= '<div class = "box-hori shadow bg-white">';
                $output .= '<ul class = "pl-0 mb-1">';
                if (empty($datas->image)) {
                    $output .= '<li class = "d-inline-block"><img src = "' . asset('public/assets/img/avatar.png') . '" class = "img-fluid ml-3 d-block rounded-circle" alt = "..."></li>';
                } else {
                    $output .= '<li class = "d-inline-block"><img src = "' . asset($datas->image) . '" class = "img-fluid ml-3 d-block rounded-circle" alt = "..."></li>';
                }
                $output .= '<li class = "d-inline-block align-top ml-3 mt-4"><span class = "text-dark h5">' . $string . '</span></li>';
                $output .= '</ul>';
                $output .= '<ul class = "text-secondary text-center h6 font-weight-light">';
                $output .= '<li class = "d-inline">' . $subject . '</li>';
                $output .= '</ul>';
                $output .= '</div>';
                $output .= '</a>';
                $output .= '</div>';
                print_r($output);
            }
        }
    }

    function update_rating(Request $request) {
        $username = session()->get('web_username');
        $rating = DB::table('ratings')
                ->select('ratings.*')
                ->where('ratings.tutor_email', $request->input('t_email'))
                ->where('ratings.email', $username)
                ->first();
        if (empty($rating)) {
            $data = array(
                'email' => $username,
                'tutor_email' => $request->input('t_email'),
                'rate' => $request->input('rating')
            );
            $results = DB::table('ratings')->insert($data);
        } else {
            $data = array(
                'email' => $username,
                'tutor_email' => $request->input('t_email'),
                'rate' => $request->input('rating')
            );
            $results = DB::table('ratings')->where('id', $rating->id)->update($data);
        }
        print_r($results);
    }

}
