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

class HoursAvailabilityController extends Controller {

    function index() {
        if (Session()->get('username')) {
            
        } else {
            return redirect('/');
        }
        $data = DB::table('hours_availability')
                ->select('*')
                ->get();
        return view('admin/hours_availability', ['data' => $data]);
    }

    function insert_hours_availability(Request $request) {
        $hours = $request->input('hours');
        $session = $request->input('session');
        $data = array(
            'hours' => $hours,
            'session' => $session
        );
        DB::table('hours_availability')->insert($data);

        return back()->withInput();
    }

    function update_hours_availability(Request $request, $id) {
        $hours = $request->input('hours');
        $session = $request->input('session');
        $data = array(
            'hours' => $hours,
            'session' => $session
        );
        DB::table('hours_availability')->where('id', $id)->update($data);

        return redirect('admin/hours_availability');
    }

    function edit_hours_availability(Request $request, $id) {
        $data = DB::table('hours_availability')
                ->select('*')
                ->get();
        $edit_data = DB::table('hours_availability')
                ->select('*')
                ->where('id', $id)
                ->get();
        return view('admin/hours_availability', ['data' => $data, 'getdata' => $edit_data]);
    }

    function delete_hours_availability(Request $request, $id) {
        DB::table('hours_availability')->where('id', $id)->delete();
        return back()->withInput();
    }

}
