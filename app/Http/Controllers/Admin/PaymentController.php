<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Session;
use Validator;
use Auth;

class PaymentController extends Controller {

    function index() {
        $data = DB::table('payment_transaction')
                ->select('payment_transaction.*')
                ->get();
        
        return view('admin/view_payment', ['getdata' => $data]);
    }
}
