<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Session;
use Validator;
use Auth;

class StudentController extends Controller {

    function student_update(Request $request) {
        $email = session()->get('web_username');
        $username = $request->input('username');
        $mob_no = $request->input('mob_no');
        $location = $request->input('location');
        $std = $request->input('std');
        $data = array(
            'username' => $username
        );
        $student = array(
            'email' => $email,
            'mobile_no' => $mob_no,
            'location' => $location,
            'standard' => $std
        );
        $result = DB::table('users')->where('email', $email)->update($data);
        $get_data = DB::table('student_registration')
                ->where('email', $email)
                ->get();
        $count = count($get_data);
        if ($count == 0) {
            $results = DB::table('student_registration')->insert($student);
        } else {
            $results = DB::table('student_registration')->where('email', $email)->update($student);
        }
    }

    function student_image(Request $request) {
        $email = session()->get('web_username');
        $image = $request->file('file');
        $new_name = rand() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('Student'), $new_name);
        $data = array(
            'image' => url('public/Student/' . $new_name)
        );
        $result = DB::table('users')->where('email', $email)->update($data);
        echo $result;
    }

    function update_lat_long(Request $request) {
        $email = $request->input('email');
        $latitude = $request->input('latitude');
        $longitude = $request->input('longitude');
        $student = array(
            'email' => $email,
            'latitude' => $latitude,
            'longitude' => $longitude
        );
        $get_data = DB::table('student_registration')
                ->where('email', $email)
                ->get();
        $count = count($get_data);
        if ($count == 0) {
            $results = DB::table('student_registration')->insert($student);
        } else {
            $results = DB::table('student_registration')->where('email', $email)->update($student);
        }
    }

}
