<?php

use Carbon\Carbon;
use App\Models\City;
use App\Models\User;
use App\Models\State;
use App\Models\Country;
// use Google\Client;
use Carbon\CarbonPeriod;
use Illuminate\Support\Str;
use App\Models\BusinessTiming;
use App\Models\BusinessSetting;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;


function apiResponce($statuscode, $status, $message, $data = [])
{
    return response()->json(["code" => $statuscode, "success" => $status, "message" => $message, "data" => $data]);
}

// ************ image function start ***************

function fileRemoveStorage($imageObject)
{
    if ($imageObject != null) {
        return Storage::disk('local')->delete($imageObject);
    }
}

function fileUploadStorage($imageObject, $directory = "", $width = "", $hieght = "", $converto = "webp")
{
    if (!empty($imageObject)) {
        $imgname = time() . "_" . rand(11111, 99999) . '.' . $imageObject->getClientOriginalExtension();
        $imageName = $directory . "/" . $imgname;

        if ($width != "" && $hieght != "") {

            // create folder if not exist
            if (!Storage::disk('public')->exists($directory)) {
                Storage::disk('public')->makeDirectory($directory);
            }

            $image = Image::read($imageObject->path());
            $image->scale($width, $hieght); //resize

            $image->toWebp()->save(public_path('/storage/' . $imageName));
            // 
            // if($converto == 'webp'){
            //     $image->toWebp()->save(public_path('/storage/' . $imageName));
            // }else if($converto == 'png'){
            //     $image->toPng()->save(public_path('/storage/' . $imageName));
            // }else if($converto == 'jpg'){
            //     dd();
            //     $image->toJpeg()->save(public_path('/storage/' . $imageName));
            // }



        } else {

            $storage = Storage::disk('local');

            $uploaded = $storage->put($imageName, file_get_contents($imageObject), 'public');
        }
        return $imageName;
    }
    return "";
}

function getImage($url = "")
{
    $image = "storage/" . $url;
    if (!empty($url)) {
        if (file_exists(public_path($image))) {
            return asset("storage/" . $url);
        }
    }
    return asset('admin/images/default.png');
}

// ************ image function end ***************


// ************ date function end ***************

function get_date($date, $format = 'd-m-Y')
{
    return Carbon::parse($date)->translatedFormat($format);
}

function get_time($date, $format = 'h:i A')
{
    return Carbon::parse($date)->translatedFormat($format);
}

function getDateTime($date, $format = 'd-m-Y h:i A')
{
    return Carbon::parse($date)->translatedFormat($format);
}

// ************ date function end ***************


function apiObject($arrey, $newObj = null, $data = null)
{
    $temp = [];
    foreach ($arrey as $arr) {
        if ($newObj != null) {
            if ($data != null) {
                $temp[] = $arr->$newObj($data);
            } else {
                $temp[] = $arr->$newObj();
            }
        } else {
            if ($data != null) {
                $temp[] = $arr->apiObject($data);
            } else {
                $temp[] = $arr->apiObject();
            }
        }
    }
    return $temp;
}

function getCountries()
{
    return Cache::remember('getContries', 1440, function () { // 1440/60 = 1 day
        return Country::get();
    });

    //fore clear cashe
    // Cache::forget('getContries'); 
}

function getStates($country_id = 101)
{
    if (empty($country_id)) {
        $country_id = 101;
    }
    return Cache::remember('getStates', 1440, function () use ($country_id) { // 1440/60 = 1 day
        return State::where('country_id', $country_id)->get();
    });

    //fore clear cashe
    // Cache::forget('getStates'); 

}

function getCities($state_id = 12)
{
    if (empty($state_id)) {
        $state_id = 12;
    }
    return City::where('state_id', $state_id)->get();
}

function generateUniqueSlug($model, $username, $field = 'slug')
{
    $slug = Str::slug($username);
    $originalSlug = $slug;
    $i = 1;

    while ($model::where($field, $slug)->exists()) {
        $slug = $originalSlug . '-' . $i;
        $i++;
    }

    return $slug;
}

// =============== Business functions start ================
function getBusinessId()
{
    return Auth::user()->business_id;
}

function getBusinessSettings()
{
    $setting = BusinessSetting::where('business_id', getBusinessId())->first();
    if ($setting) {
        $data = $setting->getBusinessSettingObject();
    } else {
        $data = [
            'is_appointment_system' => false,
            'is_appointment_book_with_time_slote' => false,
            'is_appointment_with_department' => false,
        ];
    }

    return (object)$data;
}

// =============== Business functions end ================

// =============== Appoinmenter functions start ================


function generateTimeSlots($startTime, $endTime, $interval = 15)
{
    $slots = [];

    // Parse the start and end times into Carbon instances
    $start = Carbon::parse($startTime);
    $end = Carbon::parse($endTime);

    // Generate the time slots
    while ($start->lt($end)) {
        $slotStart = $start->format('h:i a');
        $start->addMinutes($interval);
        $slotEnd = $start->format('h:i a');

        // Add the slot to the array
        if ($start->lte($end)) {
            $slots[] = "$slotStart - $slotEnd";
        }
    }

    return $slots;
}

function getAppoinmenterTiming($id, $date)
{
    $day = Carbon::parse($date)->format('l');
    $appontmenterTiming = BusinessTiming::where('day', $day)->where('appointmenter_id', $id)->where('business_id', getBusinessId())->orderBy('start_time', 'asc')->get();
    $slots = [];
    foreach ($appontmenterTiming as $timing) {
        $startTime = Carbon::parse($timing->start_time)->format('H:i');
        $endTime = Carbon::parse($timing->end_time)->format('H:i');
        $times = generateTimeSlots($startTime, $endTime);
        $slots = array_merge($slots, $times);
    }
    
    return $slots;
}

// =============== Appoinmenter functions end ================

/**
 * @param $user
 * @param $title
 * @param $body
 * @param array $extraData
 * @return bool|string
 */
function sendNotification($user_id, $title, $body, $permission, $type, array $extraData = []): bool|string
{
    try {
        // note :- install composer require google/apiclient
        if ($type == 'message') {
            // if (pusherChannel('getout-sport-convesations-' . $user_id)) {
            //     return true;
            // }
        } else {
            $insert = new Notification();
            $insert->user_id = $user_id;
            $insert->type = $type;
            $insert->title = $title;
            $insert->message = $body;
            if ($type == 'event' || $type == 'event_delete' || $type == 'next_event') {
                $insert->event_id = $extraData['event_id'];
                $insert->save();
                $extraData['event_id'] = (string)$extraData['event_id'];
            } else if ($type == 'friend') {
                $insert->friend_id = $extraData['friend_id'];
                $insert->save();
                $extraData['friend_id'] = (string)$extraData['friend_id'];
            } else if ($type == 'addToMember') {
                $insert->save();
            }
        }


        if ($permission != null && !getNotificationPermission($user_id, $permission)) {
            return true;
        }
        $projectId = '';
        $serviceAccountPath = base_path(env('FIREBASE_PROJECT_JSON'));
        $jsonContent = File::get($serviceAccountPath);
        $data = json_decode($jsonContent, true);

        if (!empty($data)) {
            $projectId = $data['project_id'];
        }
        $client = new Client();
        $client->setAuthConfig($serviceAccountPath);
        $client->addScope('https://www.googleapis.com/auth/firebase.messaging');
        $client->useApplicationDefaultCredentials();
        $token = $client->fetchAccessTokenWithAssertion();

        $accessToken = $token['access_token'];

        $tokens = User::where('id', $user_id)->whereNotNull('fcm_token')->pluck('fcm_token')->all();

        //$SERVER_API_KEY = env('FCM_SERVER_KEY');
        $message = [
            "notification" => [
                "title" => $title,
                "body" => $body,
            ],
            'data' => $extraData
        ];

        $url = 'https://fcm.googleapis.com/v1/projects/' . $projectId . '/messages:send';
        $headers = [
            'Authorization: Bearer ' . $accessToken,
            'Content-Type: application/json',
        ];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        foreach ($tokens as $fcmtoken) {
            if ($fcmtoken) {
                $message['token'] = $fcmtoken;
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(['message' => $message]));
            }
        }
        $response = curl_exec($ch);
        if ($response === false) {
            throw new Exception('Curl error: ' . curl_error($ch));
        }
        curl_close($ch);
        $jres = json_decode($response, true);
        // dd($user_id, $jres, json_encode(['message' => $message]), $extraData);
        if (isset($jres->success) && $jres->success != 1) {
            putLog('error', '"Notification error', $response);
            // Log::error("Notification error :- " . $response);
        } else {
            putLog('info', '"Notification success', $response);
            // Log::info("Notification success :- " . $response);
        }
        return $response;
        // dd($res, $user_id, $title, $body, $tokens, $SERVER_API_KEY);
        return curl_exec($ch);
    } catch (\Exception $e) {
        // Log::error("Notification error :- " . $e);
        putLog('error', "Notification error :- " . $e);
        return true;
    }
}
