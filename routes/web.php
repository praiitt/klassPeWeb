<?php

/*
  |--------------------------------------------------------------------------
  | Web Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register web routes for your application. These
  | routes are loaded by the RouteServiceProvider within a group which
  | contains the "web" middleware group. Now create something great!
  |
 */
//Login
Route::get('/admin', function () {
    return view('admin/login');
});

//Index Page
Route::get('admin/login', 'Admin\LoginController@index');
Route::get('admin/dashboard', 'Admin\LoginController@dashboard');
Route::post('admin/checklogin', 'Admin\LoginController@checklogin');

//Subject
Route::get('admin/subject', 'Admin\SubjectController@index');
Route::post('admin/insert_subject', 'Admin\SubjectController@insert_subject');
Route::post('admin/update_subject/{id}', 'Admin\SubjectController@update_subject');
Route::get('admin/edit_subject/{id}', 'Admin\SubjectController@edit_subject');
Route::get('admin/delete_subject/{id}', 'Admin\SubjectController@delete_subject');

//Standard
Route::get('admin/standard', 'Admin\StandardController@index');
Route::post('admin/insert_standard', 'Admin\StandardController@insert_standard');
Route::post('admin/update_standard/{id}', 'Admin\StandardController@update_standard');
Route::get('admin/edit_standard/{id}', 'Admin\StandardController@edit_standard');
Route::get('admin/delete_standard/{id}', 'Admin\StandardController@delete_standard');

//Hours Availability
Route::get('admin/hours_availability', 'Admin\HoursAvailabilityController@index');
Route::post('admin/insert_hours_availability', 'Admin\HoursAvailabilityController@insert_hours_availability');
Route::post('admin/update_hours_availability/{id}', 'Admin\HoursAvailabilityController@update_hours_availability');
Route::get('admin/edit_hours_availability/{id}', 'Admin\HoursAvailabilityController@edit_hours_availability');
Route::get('admin/delete_hours_availability/{id}', 'Admin\HoursAvailabilityController@delete_hours_availability');

//Fees
Route::get('admin/fees', 'Admin\FeesController@index');
Route::post('admin/insert_fees', 'Admin\FeesController@insert_fees');
Route::post('admin/update_fees/{id}', 'Admin\FeesController@update_fees');
Route::get('admin/edit_fees/{id}', 'Admin\FeesController@edit_fees');
Route::get('admin/delete_fees/{id}', 'Admin\FeesController@delete_fees');
Route::get('admin/view_monthly_fees', 'Admin\FeesController@view_monthly_fees');

//Setting
Route::get('admin/setting', 'Admin\SettingController@setting');
Route::post('admin/change_status', 'Admin\SettingController@change_status');
Route::post('admin/about_privacy', 'Admin\SettingController@about_privacy');

//Send Notification
Route::get('admin/Send_Notification', 'Admin\Send_notification@index');
Route::post('admin/change_type', 'Admin\Send_notification@change_type');
Route::post('admin/sendnotification', 'Admin\Send_notification@Send_notification');

//User
Route::get('admin/view_user', 'Admin\UserController@user');

//Request
Route::get('admin/view_request', 'Admin\RequestController@index');

//Payment
Route::get('admin/view_payment','Admin\PaymentController@index');

//Payment Percentage
Route::get('admin/view_payment_percentage','Admin\PaymentPercentageController@index');

//Change Password
Route::get('admin/change_password', 'Admin\ChangePasswordController@change_password');
Route::post('admin/change', 'Admin\ChangePasswordController@Check_Pass');
Route::post('admin/update_pass', 'Admin\ChangePasswordController@Change_Pass');

//Logout
Route::get('admin/logout', 'Admin\LogOutController@index');


//Web Panel
Route::get('', 'IndexController@index');
Route::post('/check_email', 'LoginController@check_email');
Route::post('/check_forgot_pass', 'LoginController@check_forgot_pass');
//Send Mail
Route::resource('sendemail', 'SendEmail');
Route::post('Email', 'SendEmail@send_mail');

Route::get('/Find_tutor', 'TutorController@find_tutor');
Route::get('/About', 'AboutController@index');

Route::get('/Privacy', 'PrivacyController@index');

Route::get('/Notification', 'NotificationController@index');

Route::get('/Tutor_details/{id}', 'Search_tutorController@tutor_detail');
Route::post('update_rating', 'TutorController@update_rating');

//My Student
Route::get('/My_student', 'My_studentController@index');
Route::post('send_payment_data', 'My_studentController@send_payment_data');

//My Tutor
Route::get('/My_tutor', 'My_tutorController@index');

//Send Request
Route::get('/Send_request', 'Send_requestController@index');

//Request List
Route::get('/Request_list', 'TutorRequestController@index');
Route::post('request_tutor_details', 'TutorRequestController@request_tutor_details');
Route::post('update_request', 'TutorRequestController@update_request');
Route::post('delete_request', 'TutorRequestController@delete_request');
Route::get('send_payment_request','Send_requestController@send_payment_request');

//Search Tutor
Route::get('/Search_tutor', 'Search_tutorController@index');
Route::post('s_tutor', 'Search_tutorController@s_tutor');

Route::get('/Tutor_profile', 'TutorController@index');
Route::post('student_update', 'StudentController@student_update');
Route::post('tutor_update', 'TutorController@tutor_update');
Route::post('student_image', 'StudentController@student_image');
Route::post('tutor_image', 'TutorController@tutor_image');
Route::post('get_subject_tutor', 'TutorController@get_subject_tutor');
Route::post('update_lat_long', 'StudentController@update_lat_long');
Route::post('stripe', 'PaymentController@index');

//Send tutor request
Route::post('request_tutor', 'TutorController@request_tutor');

Route::post('register', 'RegisterController@index');
Route::post('login', 'LoginController@index');
Route::get('Logout', 'LogoutController@index');
Route::post('Login_with_google', 'LoginController@Login_with_google');
Route::post('web_facebook_login', 'LoginController@web_facebook_login');

Route::get('/Tutor_registration', 'TutorController@tutor_registration');
Route::post('insert_registration', 'TutorController@insert_registration');

//forgot password
Route::get('forgot_password/{token}', 'ForgotPassController@index');
Route::post('change_forgot_pass', 'ForgotPassController@change_forgot_pass');