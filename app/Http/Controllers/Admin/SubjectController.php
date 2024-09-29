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

class SubjectController extends Controller {

    function index() {
        if (Session()->get('username')) {
            
        } else {
            return redirect('/');
        }
        $data = DB::table('subject')
            ->select('*')
            ->get();
        return view('admin/add_subject', ['data' => $data]);
    }

    function insert_subject(Request $request) {
        $subject = $request->input('subject_name');
        $image = $request->file('image');
        $lastdata = DB::table('subject')->get()->last();
        if ($request->file('image')) {
            $ext = $image->getClientOriginalExtension();
            if (empty($lastdata->id)) {
                $imageName = '1-' . time() . '.' . $image->getClientOriginalExtension();
            } else {
                $imageName = $lastdata->id + 1 . '-' . time() . '.' . $image->getClientOriginalExtension();
            }

            $imgefolder = "public/subject/" . ($imageName);
            $file = array("jpg", "jpeg", "png");
            if ($ext != 'png') {

                $pic1 = $this->compress_image($_FILES["image"]["tmp_name"], $imgefolder, 80);
            } else {
                $tmp = $_FILES['image']['tmp_name'];
                move_uploaded_file($tmp, $imgefolder);
            }
            $data = array(
                'subject_name' => $subject,
                'image' => url($imgefolder)
            );
            DB::table('subject')->insert($data);
        } else {
            $data = array(
                'subject_name' => $subject
            );
            DB::table('subject')->insert($data);
        }
        return back()->withInput();
    }

    function update_subject(Request $request, $id) {
        $subject = $request->input('subject_name');
        if ($request->file('image')) {
            $image = $request->file('image');
            $ext = $image->getClientOriginalExtension();

            $imageName = $id . '-' . time() . '.' . $image->getClientOriginalExtension();
            $imgefolder = "public/subject/" . ($imageName);
            $file = array("jpg", "jpeg", "png");
            if ($ext != 'png') {

                $pic1 = $this->compress_image($_FILES["image"]["tmp_name"], $imgefolder, 80);
            } else {
                $tmp = $_FILES['image']['tmp_name'];
                move_uploaded_file($tmp, $imgefolder);
            }
            $data = array(
                'subject_name' => $subject,
                'image' => url($imgefolder)
            );
            DB::table('subject')->where('id', $id)->update($data);
        } else {
            $data = array(
                'subject_name' => $subject
            );
            DB::table('subject')->where('id', $id)->update($data);
        }
        return redirect('admin/subject');
    }

    function edit_subject(Request $request, $id) {
        $data = DB::table('subject')
            ->select('*')
            ->get();
        $edit_data = DB::table('subject')
            ->select('*')
            ->where('id', $id)
            ->get();
        return view('admin/add_subject', ['data' => $data, 'getdata' => $edit_data]);
    }

    function delete_subject(Request $request, $id) {
        $data = DB::table('subject')->where('id', $id);
        $editdata = $data->get();
        if (!empty($editdata[0]->image)) {
            $url = $editdata[0]->image;
            $image = 'public/subject/' . substr($url, strrpos($url, '/') + 1);

            if (file_exists($image)) {
                unlink($image);
            }
        }
        DB::table('subject')->where('id', $id)->delete();
        return back()->withInput();
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
