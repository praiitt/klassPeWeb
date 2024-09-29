<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Session;
use Validator;
use Auth;

class Search_tutorController extends Controller {

    function index(Request $request) {
        if (Session()->get('web_username')) {
            
        } else {
            return redirect('/');
        }
        $username = session()->get('web_username');
        $data = DB::table('tutor_registration')
                ->select('tutor_registration.*', DB::raw("IFNULL(users.username, 'Unnamed Tutor') as `username`"), 'users.image', DB::raw('group_concat(subject.subject_name) as sname'))
                ->join('subject', DB::raw('find_in_set(subject.id, tutor_registration.subject)'), '>', DB::raw("'0'"))
                ->join('users', 'users.email', 'tutor_registration.email')
                ->where('users.type', 'tutor')
                ->groupBy('tutor_registration.id')
                ->get();
        $subject = DB::table('subject')
                ->select('*')
                ->get();
        $standard = DB::table('standard')
                ->select('*')
                ->get();
        return view('search-tutor', ['getdata' => $data, 'subject' => $subject, 'standard' => $standard]);
    }

    function tutor_detail(Request $request, $id) {
        if (Session()->get('web_username')) {
            
        } else {
            return redirect('/');
        }
        $username = session()->get('web_username');
        $student_data = DB::table('users')
                ->select('student_registration.mobile_no', 'student_registration.standard', 'student_registration.location', 'users.*', 'student_registration.latitude', 'student_registration.longitude')
                ->leftjoin('student_registration', 'student_registration.email', 'users.email')
                ->where('users.email', $username)
                ->where('users.type', 'student')
                ->get();

        $latitude = !empty($student_data[0]->latitude) ? $student_data[0]->latitude : '0';
        $longitude = !empty($student_data[0]->longitude) ? $student_data[0]->longitude : '0';
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
//        \DB::enableQueryLog();
        $data = DB::table('users')
                ->select('tutor_registration.mobile_no', 'tutor_registration.year_of_experience', 'tutor_registration.location', 'tutor_registration.subject','tutor_registration.m_hours','tutor_registration.a_hours', DB::raw('group_concat(DISTINCT(standard.std)) as std_name'), 'tutor_registration.standard', 'tutor_registration.university', 'tutor_registration.monthly_fees', 'users.*', DB::raw('group_concat(DISTINCT subject.subject_name ORDER BY subject.id ASC) as sname'), DB::raw('GROUP_CONCAT(DISTINCT CASE WHEN hours_availability.session = "am" THEN hours_availability.hours ELSE NULL END ORDER BY hours_availability.id ASC) as m_hour'),DB::raw('GROUP_CONCAT(DISTINCT CASE WHEN hour.session = "pm" THEN hour.hours ELSE NULL END ORDER BY hour.id ASC) as a_hour'),DB::raw("IFNULL(users.username, 'Unnamed Tutor') as `username`"), 'tutor_registration.tuition_type')
                ->selectRaw("$haversine AS distance")
                ->leftjoin('tutor_registration', 'tutor_registration.email', 'users.email')
                ->join('subject', DB::raw('find_in_set(subject.id, tutor_registration.subject)'), '>', DB::raw("'0'"))
                ->join('standard', DB::raw('find_in_set(standard.id, tutor_registration.standard)'), '>', DB::raw("'0'"))
                ->leftjoin('hours_availability', DB::raw('find_in_set(hours_availability.id, tutor_registration.m_hours)'), '>', DB::raw("'0'"))
                ->leftjoin('hours_availability as hour', DB::raw('find_in_set(hour.id, tutor_registration.a_hours)'), '>', DB::raw("'0'"))
                ->where('tutor_registration.id', $id)
                ->where('users.type', 'tutor')
                ->get();
//dd(\DB::getQueryLog());
        $user = DB::table('tutor_registration')
                ->select('email')
                ->where('id', $id)
                ->first();
        $rate = DB::table('ratings')
                ->select(DB::raw('ROUND(AVG(rate),1) as rating'))
                ->where('tutor_email', $user->email)
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
        return view('tutor-detail', ['getdata' => $data, 'rate' => $rate, 'm_hours' => $m_hours, 'a_hours' => $a_hours, 'student_data' => $student_data]);
    }

    function s_tutor(Request $request) {
        $username = $request->input('username');
        $data = DB::table('tutor_registration')
                ->select('tutor_registration.*', DB::raw("IFNULL(users.username, 'Unnamed Tutor') as `username`"), 'users.type', 'users.image', DB::raw('group_concat(subject.subject_name) as sname'))
                ->join('subject', DB::raw('find_in_set(subject.id, tutor_registration.subject)'), '>', DB::raw("'0'"))
                ->join('users', 'users.email', 'tutor_registration.email')
                ->groupBy('tutor_registration.id')
                ->where('users.type', 'tutor')
                ->where('users.username', 'LIKE', "%$username%")
                ->orwhere('subject.subject_name', 'LIKE', "%$username%")
                ->get();
        if (count($data) == 0) {
            $output = '';
            $output .= '<div class="col-lg-4 col-md-6">';
            $output .= '<center>';
            $output .= '<img src="public/assets/img/no-data.png" class="rounded shadow-sm">';
            $output .= '</center>';
            $output .= '</div>';
            print_r($output);
        } else {
            $output = '';
            foreach ($data as $tutor) {
                $output .= '<div class="col-lg-4 col-md-6">';
                $output .= '<a href="' . url('Tutor_details/' . $tutor->id) . '">';
                $output .= '<div class="count-box tutor-img">';
                if (empty($tutor->image)) {
                    $output .= '<img src="' . asset('public/assets/img/avatar.png') . '" class="rounded shadow-sm">';
                } else {
                    $output .= '<img src="' . asset($tutor->image) . '" class="rounded shadow-sm">';
                }
                $output .= '<div>';
                $output .= '<h4 class="text-secondary">' . $tutor->username . '</h4>';

                $myString = $tutor->sname;
                $subject = str_replace(",", "|", $myString);

                $output .= '<li class="d-inline text-secondary font-weight-light">' . $subject . '</li>';
                $output .= '</div>';
                $output .= '<i class="bi bi-chevron-right h2 text-blue"></i>';
                $output .= '</div>';
                $output .= '</a>';
                $output .= '</div>';
            }
            echo $output;
        }
    }

}
