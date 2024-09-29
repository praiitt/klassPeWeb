<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Session;
use Validator;
use Auth;
use Image;

class FeesController extends Controller {

    function index() {
        if (Session()->get('username')) {
            
        } else {
            return redirect('/');
        }
        $student = DB::table('student_registration')
                ->select('users.username', 'users.email')
                ->join('users', 'users.email', '=', 'student_registration.email')
                ->get();
        $data = DB::table('fees')
                ->select('fees.*', 'users.username')
                ->join('users', 'fees.student_id', 'users.email')
                ->get();
        return view('admin/add_fees', ['student' => $student, 'datas' => $data]);
    }

    function insert_fees(Request $request) {
        $student_id = $request->input('student_id');
        $fees = $request->input('fees');
        $status = $request->input('status');
        $date = $request->input('date');
        $data = array(
            'student_id' => $student_id,
            'fees' => $fees,
            'date' => $date,
            'status' => $status
        );
        DB::table('fees')->insert($data);

        return back()->withInput();
    }

    function update_fees(Request $request, $id) {
        $student_id = $request->input('student_id');
        $fees = $request->input('fees');
        $status = $request->input('status');
        $date = $request->input('date');
        $data = array(
            'student_id' => $student_id,
            'fees' => $fees,
            'date' => $date,
            'status' => $status
        );
        DB::table('fees')->where('id', $id)->update($data);
        return redirect('admin/fees');
    }

    function edit_fees(Request $request, $id) {
        $student = DB::table('student_registration')
                ->select('users.username', 'users.email')
                ->join('users', 'users.email', '=', 'student_registration.email')
                ->get();
        $data = DB::table('fees')
                ->select('fees.*', 'users.username')
                ->join('users', 'fees.student_id', 'users.email')
                ->get();
        $edit_data = DB::table('fees')
                ->select('*')
                ->where('id', $id)
                ->get();
        return view('admin/add_fees', ['datas' => $data, 'getdata' => $edit_data, 'student' => $student]);
    }

    function delete_fees(Request $request, $id) {

        DB::table('fees')->where('id', $id)->delete();
        return back()->withInput();
    }

    function view_monthly_fees(Request $request) {
        $student = DB::table('users')
                ->select('*')
                ->where('type', 'Student')
                ->get();
        $current_month = $request->input('current_month');
        $fdate = $request->input('from_date');
        $tdate = $request->input('to_date');
        $student_id = $request->input('student_id');
        if (!empty($student_id)) {
            $student_data = DB::table('fees')
                    ->select('fees.*', 'users.username')
                    ->join('users', 'fees.student_id', 'users.email')
                    ->where('fees.date', '>=', $fdate)
                    ->where('fees.date', '<=', $tdate)
                    ->where('fees.student_id', '=', $student_id)
                    ->get();
        } elseif (!empty($fdate)) {
            $student_data = DB::table('fees')
                    ->select('fees.*', 'users.username')
                    ->join('users', 'fees.student_id', 'users.email')
                    ->where('fees.date', '>=', $fdate)
                    ->where('fees.date', '<=', $tdate)
                    ->get();
        } else {
            $student_data = '';
        }
        if (isset($current_month)) {
            $month_payment = DB::table('fees')
                    ->select('fees.*', 'users.username')
                    ->join('users', 'users.email', '=', 'fees.student_id')
                    ->where(DB::raw("DATE_FORMAT(fees.date,'%m-%Y')"), "=", $current_month)
                    ->get();
        } else {
            $month_payment = '';
        }
        return view('admin/view_monthly_fees', ['student' => $student, 'student_data' => $student_data, "month_payment" => $month_payment]);
    }

}
