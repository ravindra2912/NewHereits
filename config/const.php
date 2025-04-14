<?php


return [

    "site_setting" => [
        "name" => "Test site",
        //  "logo" => asset('admin/images/logo.png'),
        "logo" => env('APP_URL') . '/admin/images/logo.png',
        "small_logo" => env('APP_URL') . '/admin/images/small_logo.png',
        "fevicon" => env('APP_URL') . '/admin/images/small_logo.png',
    ],

    "legal_page_type" => ["PrivacyPolicy", "TermsAndCondition", "CopyRight"],

    "gender" => ["Male", "Female"],

    "user_status" => ["active", "in-active"],
    "appointmenter_status" => ["active", "in-active"],

    "business_type_status" => ["active", "in-active"],

    "business_status" => ["pending", "active", "in-active", 'baned'],
    "business_type" => ["Service", "Product", 'Both'],
    "business_rating" => [
        0 => 'No Review',
        1 => 'Bad',
        2 => 'Poor',
        3 => 'Average',
        4 => 'Good',
        5 => 'Excellent',
    ],


    "week_day_name" => ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", 'Sunday'],

    "appointment_status" => ["pending", "completed", "cancel"],

    "faq_type" => ['General', 'Business', 'Appointment', 'Services', 'Product'],

];
