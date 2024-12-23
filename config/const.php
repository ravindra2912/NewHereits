<?php


return [

   "site_setting" => [
    "name" => "Test site",
   //  "logo" => asset('admin/images/logo.png'),
    "logo" => env('APP_URL').'/admin/images/logo.png',
    "small_logo" => env('APP_URL').'/admin/images/small_logo.png',
    "fevicon" => env('APP_URL').'/admin/images/small_logo.png',
   ],

    "legal_page_type" => ["PrivacyPolicy", "TermsAndCondition"],
    
    "gender" => ["Male", "Female"],

    "user_status" => ["active", "in-active"],
    
    "business_status" => ["active", "in-active", 'baned'],
    "business_type" => ["Service", "Product", 'Both'],


    "week_day_name" => ["Monday", "Tuesday","Wednesday","Thursday","Friday","Saturday", 'Sunday'],
    
    "appointment_status" => ["pending", "complete","cancel"],

];
