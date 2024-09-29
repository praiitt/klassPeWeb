<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Session;
use Validator;
use Auth;

class SettingController extends Controller {

    function setting() {
        $data = DB::table('setting')
                ->select('*')
                ->get();
        return view('admin/setting', ['getdata' => $data]);
    }

    function change_status(Request $request) {
        $cid = $request->input('cid');
        $status = $request->input('notification_status');
        $data = array('notification_status' => $status);
        $result = DB::table('setting')->where('id', $cid)->update($data);
        $responce = array();

        if ($result) {

            $responce = array("status" => TRUE, "msg" => "Operation Successful!");
        } else {

            $responce = array("status" => FALSE, "msg" => "Oops Operation Fail");
        }
        echo json_encode($responce);
    }

    function about_privacy(Request $request) {
        $about = $request->input('about');
        $privacy_policy = $request->input('privacy_policy');
        $distance = $request->input('distance');
        $stripe_client_key = $request->input('stripe_client_key');
        $stripe_public_key = $request->input('stripe_public_key');
        $percentage = $request->input('percentage');
        $getdata = DB::table('setting')
                ->select('*')
                ->get();
        $id = $getdata[0]->id;
        $data = array('stripe_public_key' => $stripe_public_key,
            'stripe_client_key' => $stripe_client_key,
            'distance' => $distance,
            'about' => $about,
            'privacy_policy' => $privacy_policy,
            'percentage' => $percentage
        );
        $result = DB::table('setting')->where('id', $id)->update($data);
        return back()->withInput();
    }

}
