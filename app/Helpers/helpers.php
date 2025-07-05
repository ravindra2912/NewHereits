<?php

use Carbon\Carbon;
use App\Models\City;
use App\Models\User;
use App\Models\State;
use GuzzleHttp\Client;
// use Google\Client;
use App\Models\Country;
use App\Models\CityArea;
use Carbon\CarbonPeriod;
use Illuminate\Support\Str;
use App\Models\Appointmenter;
use chillerlan\QRCode\QRCode;
use App\Models\BusinessTiming;
use App\Models\BusinessSetting;
use App\Models\BusinessCategory;
use chillerlan\QRCode\QROptions;
use App\Models\AppointmentBooking;
use App\Models\Business;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use chillerlan\QRCode\Common\EccLevel;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;
use chillerlan\QRCode\Output\QROutputInterface;


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

function getImage($url = "", $type = '')
{
    $image = "storage/" . $url;
    if (!empty($url)) {
        if (file_exists(public_path($image))) {
            return asset("storage/" . $url);
        }
    }
    if ($type == 'expert') {
        return asset('front/img/expert.webp');
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

function getCitieArea($city_id)
{
    return CityArea::select('id', 'area_name', 'city_id', 'pincode')->where('city_id', $city_id)->get();
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

function getBusinessSettings($business_id = null)
{
    if ($business_id == null) {
        $business_id = getBusinessId();
    }
    $setting = BusinessSetting::where('business_id', $business_id)->first();
    if ($setting) {
        $data = $setting->getBusinessSettingObject();
    } else {
        $data = [
            'is_appointment_system' => false,
            'is_appointment_book_with_time_slote' => false,
            'is_appointment_with_department' => false,
            'is_need_booking_confirmetion' => false,
        ];
    }
    return (object)$data;
}

function getBusinessCategory()
{
    return Cache::rememberForever('BusinessCategory', function () { // 1440/60 = 1 day
        return BusinessCategory::where('status', 'active')->get();
    });
}

function isBusinessOpen($business_id = null)
{
    if ($business_id == null) {
        $business_id = getBusinessId();
    }
    $day = Carbon::now()->format('l');
    $time = Carbon::now()->format('H:i:s');
    $businessTiming = BusinessTiming::where('day', $day)->where('business_id', $business_id)->where('start_time', '<=', $time)->where('end_time', '>=', $time)->first();
    if ($businessTiming) {
        return true;
    }
    return false;
}

function isExpertAvailable($appointmenter_id = null, $business_id = null)
{
    $res['status'] = 'close';
    $res['data'] = null;

    if ($appointmenter_id != null) {
        if ($business_id == null) {
            $expertDetail = Appointmenter::select('id', 'business_id')->find($appointmenter_id);
            $business_id = $expertDetail->business_id;
        }
        $businessSetting = getBusinessSettings($business_id);

        $currentBooking = AppointmentBooking::select('id', 'token_number', 'user_id', 'appointmenter_id', 'user_name', 'user_contact', 'slot_start_time', 'slot_end_time', 'booking_date', 'status')
            ->where('booking_date', Carbon::now()->format('Y-m-d'))
            ->where('appointmenter_id', $appointmenter_id)
            ->where('status', 'in_progress');
        if ($businessSetting->is_appointment_book_with_time_slote) {
            $currentBooking = $currentBooking->orderBy('slot_start_time', 'asc');
        } else {
            $currentBooking = $currentBooking->orderBy('token_number', 'asc');
        }
        $currentBooking = $currentBooking->first();

        if ($currentBooking) {
            $res['status'] = 'open';
            $res['data'] = $currentBooking;
        } else {
            $day = Carbon::now()->format('l');
            $time = Carbon::now()->format('H:i:s');
            $businessTiming = BusinessTiming::where('day', $day)
                ->where('appointmenter_id', $appointmenter_id)
                ->where('start_time', '<=', $time)
                ->where('end_time', '>=', $time)
                ->first();
            if ($businessTiming) {
                $res['status'] = 'open';
            } else {
                $businessTiming = BusinessTiming::select('id', 'start_time')
                    ->where('day', $day)
                    ->where('appointmenter_id', $appointmenter_id)
                    ->where('start_time', '>=', $time)
                    ->first();
                if ($businessTiming) {
                    $res['status'] = 'break';
                    $res['data'] = $businessTiming;
                }
            }
        }
    }
    return $res;
}

function updateBusinessSeo($bussinessId)
{
    $business = Business::select('id', 'name', 'address', 'business_category_id', 'country_id', 'state_id', 'city_id', 'area_id', 'pincode')
        ->with([
            'businessCategory',
            'country',
            'state',
            'city',
            'area',
        ])
        ->find($bussinessId);

    $catname = '';
    if (isset($business->businessCategory) && !empty($business->businessCategory->name)) {
        $catname = $business->businessCategory->name;
    }

    $description = '';
    $keyword = '';
    if ($business) {
        if (isset($business->city) && !empty($business->city->name)) {
            $keyword .= $catname . ' in ' . $business->city->name . ', ';
            $keyword .= 'Top ' . $catname . ' in ' . $business->city->name . ', ';
            $keyword .= 'Best ' . $catname . ' in ' . $business->city->name . ', ';
        }

        if (isset($business->area) && !empty($business->area->area_name)) {
            $keyword .= 'Best ' . $catname . ' near ' . $business->area->area_name . ', ';
            $keyword .= $business->name . ' ' . $catname . ' ' . $business->area->area_name . ', ';
            $keyword .= 'Top ' . $catname . ' in ' . $business->area->area_name . ', ';
            $keyword .= 'nearby  ' . $catname . ' in ' . $business->area->area_name . ', ';

            $description = "Explore trusted {$catname} services in {$business->area->area_name}";
            $description .= !empty($business->city->name) ? " {$business->city->name}" : "";
            $description .= ". ";
        }

        $description .= "{$business->name} offers professional and reliable {$catname} solutions near you.";
    }

    Business::where('id', $bussinessId)->update([
        'seo_description' => $description,
        'seo_keyword' => $keyword,
    ]);
}

// =============== Business functions end ================

// =============== Appoinmenter functions start ================


function generateTimeSlots($startTime, $endTime, $date, $interval, $bookedArray)
{
    $slots = [];

    // Parse the start and end times into Carbon instances
    $date = Carbon::parse($date)->format('Y-m-d');
    $start = Carbon::parse($startTime);
    $end = Carbon::parse($endTime);

    // Generate the time slots
    while ($start->lt($end)) {
        $slotStart = $start->format('h:i a');
        $start->addMinutes($interval);
        $slotEnd = $start->format('h:i a');

        // Add the slot to the array
        if ($start->lte($end)) {
            $temp['time'] = "$slotStart - $slotEnd";

            // check if the slot is available
            $currentDateTime = Carbon::now()->addMinutes($interval);
            $slotStartDateTime = Carbon::parse(Carbon::parse($date)->format('Y-m-d') . ' ' . $slotStart);
            $slotEndDateTime = Carbon::parse(Carbon::parse($date)->format('Y-m-d') . ' ' . $slotEnd);
            if ($currentDateTime->between($slotStartDateTime, $slotEndDateTime)) {
                $temp['is_available'] = false;
            } elseif ($currentDateTime->greaterThan($slotEndDateTime)) {
                $temp['is_available'] = false;
            } else {
                $temp['is_available'] = true;
            }

            $temp['is_booked'] = in_array($temp['time'], $bookedArray) ? true : false;
            $slots[] = $temp;
        }
    }

    return $slots;
}

function getAppoinmenterTiming($id, $date, $appoinment_id = null, $getBusinessId = null)
{
    $day = Carbon::parse($date)->format('l');

    // if ($getBusinessId == null) {
    //     $getBusinessId = getBusinessId();
    // }

    $interval = 15;
    // get appointmenter interval time
    $geinterval = Appointmenter::select('id', 'business_id', 'timing_per_appointment')->find($id);
    if ($geinterval) {
        if ($getBusinessId == null) {
            $getBusinessId = $geinterval->business_id;
        }

        if ($geinterval->timing_per_appointment > 0) {
            $interval = $geinterval->timing_per_appointment;
        }
    }

    $appontmentsData = AppointmentBooking::select('slot_start_time', 'slot_end_time')
        ->whereDate('booking_date', Carbon::parse($date))
        ->where('business_id', $getBusinessId)
        ->where('appointmenter_id', $id);
    if ($appoinment_id != null) {
        $appontmentsData = $appontmentsData->WhereNotIn('id', [$appoinment_id]);
    }
    $appontmentsData = $appontmentsData->get();
    $bookedArray = array();
    foreach ($appontmentsData as $appontmentrow) {
        $bookedArray[] = Carbon::parse($appontmentrow->slot_start_time)->format('h:i a') . ' - ' . Carbon::parse($appontmentrow->slot_end_time)->format('h:i a');
    }

    $appontmenterTiming = BusinessTiming::where('day', $day)->where('appointmenter_id', $id)->where('business_id', $getBusinessId)->orderBy('start_time', 'asc')->get();
    $slots = array();
    foreach ($appontmenterTiming as $timing) {
        $startTime = Carbon::parse($timing->start_time)->format('H:i');
        $endTime = Carbon::parse($timing->end_time)->format('H:i');
        $times = generateTimeSlots($startTime, $endTime, $date, (int)$interval, $bookedArray);
        $slots = array_merge($slots, $times,);
    }
    return $slots;
}


// =============== Appoinmenter functions end ================

// =============== geo location info functions start ================

function getUserLocationInfo()
{
    $data = session('hereitsLocation');
    if ($data && isset($data['data']) != null) {
        return $data['data'];
    }
    return null;
}

function getIpDetails()
{

    $ip = request()->ip(); // This fetches the client's IP address
    $ip = ($ip == '127.0.0.1') ? '123.201.3.127' : $ip;

    $response = file_get_contents("http://ip-api.com/json/{$ip}");
    $data = json_decode($response);
    // dd($data->city, $data);
    return $data;
    // $location = geoip()->getLocation($ip);
    // return $location;
}


function getLatLongOnAddress($address)
{
    $apiKey = ''; //get your api key from https://opencagedata.com/
    $client = new Client();

    if (empty($apiKey)) {
        $response = $client->get('https://nominatim.openstreetmap.org/search', [
            'query' => [
                'q' => $address,
                'format' => 'json',
            ],
        ]);

        $data = json_decode($response->getBody(), true);

        if (!empty($data)) {
            return [
                'latitude' => $data[0]['lat'],
                'longitude' => $data[0]['lon'],
            ];
        }
    } else {
        $response = $client->get('https://api.opencagedata.com/geocode/v1/json', [
            'query' => [
                'q' => $address,
                'key' => $apiKey,
            ],
        ]);

        $data = json_decode($response->getBody(), true);

        if (!empty($data['results'])) {
            $location = $data['results'][0]['geometry'];
            return [
                'latitude' => $location['lat'],
                'longitude' => $location['lng'],
            ];
        }
    }
    return ['error' => 'Unable to fetch coordinates'];
}

function getAddressOnLatLong($latitude, $longitude)
{
    // $apiKey = 'AIzaSyBDH6OcgfnirI5a7pmMSUInirj3ZwoOlGU'; //get your api key from https://opencagedata.com/
    $apiKey = env('GOOGLE_MAP_KEY'); //get your api key from https://opencagedata.com/
    $client = new Client();

    if (empty($apiKey)) {
        // $response = $client->get('https://nominatim.openstreetmap.org/reverse', [
        //     'query' => [
        //         'lat' => $latitude,
        //         'lon' => $longitude,
        //         'format' => 'json',
        //     ],
        // ]);

        // $data = json_decode($response->getBody(), true);

        // if (!empty($data)) {
        //     return $data['display_name'];
        // }

        $response = Http::withHeaders([
            'User-Agent' => 'hereits/1.0 (hereits@gmail.com)'
        ])->get("https://nominatim.openstreetmap.org/reverse", [
            'format' => 'json', //jsonv2
            // 'lat' => 21.085221,
            // 'lon' => 71.771351,
            'lat' => $latitude,
            'lon' => $longitude,
        ]);

        if ($response->successful()) {

            $data = $response->json();
            if ($data['address']) {
                if (isset($data['address']['village'])) {
                    return $data['address']['village'] . ', ' . $data['address']['state_district'];
                }
                if (isset($data['address']['county'])) {
                    return $data['address']['county'] . ', ' . $data['address']['state_district'];
                } else {
                    return $data['address']['town'];
                }
            }
            return null;
        } else {
            return null;
            // return 'Error: Unable to retrieve address.';
        }
    } else {
        $url = "https://maps.googleapis.com/maps/api/geocode/json?latlng={$latitude},{$longitude}&key={$apiKey}";

        $client = new \GuzzleHttp\Client();
        $response = $client->get($url);
        $data = json_decode($response->getBody(), true);

        if (!empty($data['results'])) {
            $address_components = $data['results'][0]['address_components'];

            $area = '';
            $locality = '';
            $admin_area_level_3 = '';
            $administrative_area_level_1 = '';
            $address = '';

            // dd($address_components);

            // Parse components
            foreach ($address_components as $component) {
                $types = $component['types'];

                if (in_array('sublocality', $types) || in_array('sublocality_level_1', $types)) {
                    $area = $component['long_name'];
                }

                if (in_array('locality', $types)) {
                    $locality = $component['short_name'];
                }

                if (in_array('administrative_area_level_3', $types)) {
                    $admin_area_level_3 = $component['short_name'];
                }

                if (in_array('administrative_area_level_1', $types)) {
                    $administrative_area_level_1 = $component['short_name'];
                }
            }

            // dd($area, $locality, $admin_area_level_3, $administrative_area_level_1);

            // Construct address
            if (!empty($area)) {
                $address = $area;
            }
            if (!empty($locality)) {
                $address .= $address == '' ? $locality : ', ' . $locality;
            } else {
                $address .= $address == '' ? $admin_area_level_3 : ', ' . $admin_area_level_3;
            }

            if ($locality == $admin_area_level_3) {
                $address .= $address == '' ? $administrative_area_level_1 : ', ' . $administrative_area_level_1;
            }
        }
        if (!empty($address)) {
            return $address;
        }
    }
    // return 'Unable to fetch address';
    return null;
}

// =============== geo location info functions end ================

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



// ==============================================
//      Frontend functions Start 
// ==============================================

function getAvailableCities()
{
    return Cache::rememberForever('getAvailableCities', function () {
        return City::select('cities.id', 'cities.name')
            ->join('businesses', 'businesses.city_id', '=', 'cities.id', 'right')
            ->where('businesses.status', '=', 'active')
            ->distinct()
            // ->groupBy('businesses.city_id')
            ->get();
    });

    //fore clear cashe
    // Cache::forget('getAvailableCities'); 

}

// ==============================================
//      Frontend functions end 
// ==============================================

function generateQRCodeBase64($data)
{
    // $options = new QROptions([
    //     'outputType' => QRCode::OUTPUT_IMAGE_PNG,
    //     'eccLevel' => QRCode::ECC_L,
    //     'scale' => 10,
    // ]);

    $myOptions = new QROptions([
        'version'    => 10,
        'outputType' => QROutputInterface::GDIMAGE_PNG,
        'eccLevel'   => EccLevel::H,
    ]);

    $qrPng = (new QRCode($myOptions))->render($data);
    return $qrPng;
    // echo "<img src='$qrPng' />";
}


function businessSticker($qrdata, $text)
{
    $baseImagePath = public_path('front/stiker/poster.png');
    $qrImagePath = public_path('front/stiker/qr.png');

    // Load base and QR images
    $base = imagecreatefrompng($baseImagePath);
    // $qr = imagecreatefrompng($qrImagePath);

    $qr = imagecreatefromstring(base64_decode(str_replace('data:image/png;base64,', '', generateQRCodeBase64($qrdata))));

    // Resize QR to 700x700
    $qrResized = imagecreatetruecolor(700, 700);
    imagealphablending($qrResized, false);
    imagesavealpha($qrResized, true);
    imagecopyresampled($qrResized, $qr, 0, 0, 0, 0, 700, 700, imagesx($qr), imagesy($qr));

    // Center QR
    $bgWidth = imagesx($base);
    $qrX = intval(($bgWidth - 700) / 2);
    $qrY = 750; // Adjust vertically
    imagecopy($base, $qrResized, $qrX, $qrY, 0, 0, 700, 700);

    //add text
    $fontPath = public_path('front/stiker/Roboto-ExtraBold.ttf'); // Must exist
    $maxFontSize = 110;
    $minFontSize = 10;

    $imageWidth = imagesx($base);
    $imageHeight = imagesy($base);

    $textColor = imagecolorallocate($base, 255, 255, 255); // Set text color

    // Start with max size and shrink if needed
    $fontSize = $maxFontSize;

    do {
        $bbox = imagettfbbox($fontSize, 0, $fontPath, $text);
        $textWidth = abs($bbox[2] - $bbox[0]);
        $textHeight = abs($bbox[7] - $bbox[1]);
        if ($textWidth <= $imageWidth - 40) {
            break;
        }
        $fontSize -= 2;
    } while ($fontSize >= $minFontSize);

    // Final X/Y position (centered)
    $textX = intval(($imageWidth - $textWidth) / 2);
    $textY = 320; // Adjust based on your design layout

    // Draw text
    imagettftext($base, $fontSize, 0, $textX, $textY, $textColor, $fontPath, $text);

    // Convert to base64
    ob_start();
    imagepng($base);
    $imageData = ob_get_clean();
    $base64 = base64_encode($imageData);
    $base64Image = 'data:image/png;base64,' . $base64;
    // echo "<img src='$base64Image' height='600' />";
    // dd($base64Image);

    // Cleanup
    imagedestroy($base);
    imagedestroy($qr);
    imagedestroy($qrResized);

    // Return as JSON or use directly in a view
    return $base64Image;
}
