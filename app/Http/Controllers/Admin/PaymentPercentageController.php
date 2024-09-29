<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Session;
use Validator;
use Auth;

class PaymentPercentageController extends Controller {

    function index(Request $request) {
        $percentage = DB::table('setting')
                ->select('percentage')
                ->get();

        $current_month = $request->input('current_month');
        if (isset($current_month)) {
            $month_payment = DB::table('payment_transaction')
                    ->select('payment_transaction.*', 'users.username')
                    ->join('users', 'users.email', '=', 'payment_transaction.tutor_email')
                    ->where(DB::raw("DATE_FORMAT(payment_transaction.datetime,'%m-%Y')"), "=", $current_month)
                    ->where('users.type', 'tutor')
                    ->get();
        } else {
            $month_payment = '';
        }

        return view('admin/view_payment_percentage', ['percentage' => $percentage, 'month_payment' => $month_payment]);
    }

}
