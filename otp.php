<?php
$otp = rand(0, 999999);
//----------------------Send Sms-------------------------------------------//   
    $apiKey = urlencode('NjE3MTVhNTg2NjZkMzY2ZTY1MzM2OTU2NzE1MzQ1N2E=');
//// Message details
    $numbers = array('7436046314');

    $sender = urlencode('HUVI');
    $message = rawurlencode("$otp  is the OTP for the Login conformation on website https://www.indianfilmhistory.com. OTP is valid for 24 Hours.. pls do not share with anyone.");
    $numbers = implode(',', $numbers);
    $data = array('apikey' => $apiKey, 'numbers' => $numbers, "sender" => $sender, "message" => $message);

    $ch = curl_init('https://api.textlocal.in/send/');

    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);

    curl_close($ch);
    print_r($response);

?>
