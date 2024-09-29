<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\user\Module;
use Hash;

class ChangePasswordController extends Controller {

    public function change_password() {
        return view('admin/change_password');
    }

    //check old user
    public function Check_Pass(Request $request) {

        $id = $request->input('id');
        $old = $request->input('old');
        $data = DB::table('admin')->select('username', 'password')->where('username', $id)->get();
        if (md5($request->input('old')) == $data[0]->password) {
            echo "1";
        } else {
            echo "0";
        }
    }

//change password
    public function Change_Pass(Request $request) {

        $user = $request->input('change');
        $new = $request->input('new');
        $en_pass = md5($new);
        $data = array('password' => $en_pass);

        $result = DB::table('admin')->where('username', $user)->update($data);
        if ($result) {
            echo '1';
        } else {
            echo '0';
        }
    }

}
