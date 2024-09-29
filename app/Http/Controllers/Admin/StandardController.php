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

class StandardController extends Controller {

    function index() {
        if (Session()->get('username')) {
            
        } else {
            return redirect('/');
        }
        $data = DB::table('standard')
            ->select('*')
            ->get();
        return view('admin/add_standard', ['data' => $data]);
    }

    function insert_standard(Request $request) {
        $std = $request->input('std');
        $data = array(
            'std' => $std
        );
        DB::table('standard')->insert($data);

        return back()->withInput();
    }

    function update_standard(Request $request, $id) {
        $std = $request->input('std');
        $data = array(
            'std' => $std
        );
        DB::table('standard')->where('id', $id)->update($data);

        return redirect('admin/standard');
    }

    function edit_standard(Request $request, $id) {
        $data = DB::table('standard')
            ->select('*')
            ->get();
        $edit_data = DB::table('standard')
            ->select('*')
            ->where('id', $id)
            ->get();
        return view('admin/add_standard', ['data' => $data, 'getdata' => $edit_data]);
    }

    function delete_standard(Request $request, $id) {
        DB::table('standard')->where('id', $id)->delete();
        return back()->withInput();
    }

}
