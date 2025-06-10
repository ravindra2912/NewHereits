<?php

namespace App\Http\Controllers\Front;

use Carbon\Carbon;
use App\Models\Business;
use App\Models\Favorite;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Models\Appointmenter;

use App\Models\ReviewAndRating;
use App\Models\BusinessCategory;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\AppointmentDepartment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\ProfileUpdateRequest;

class BusinessController extends Controller
{
    public function index(Request $request, $catSlug = null): View
    {
        $businessCategory = BusinessCategory::select('id', 'name', 'image', 'slug')->where('status', 'active')->limit(8)->get();
        return view('front.business.list', compact('businessCategory', 'catSlug'));
    }

    public function getBusiness(Request $request)
    {
        $userLocationInfo = getUserLocationInfo();
        $businesses = Business::query()
            ->select('id', 'name', 'slug', 'business_image', 'address', 'business_category_id', 'country_id', 'state_id', 'city_id', 'rating', 'pincode', 'latitude', 'longitude')
            ->where('subscription_expiry_date', '>=', now())
            ->with([
                'businessCategory',
                'country',
                'state',
                'city',
                'businessSetting'
            ])
            ->where('status', 'active');

        if ($userLocationInfo) {
            if ($userLocationInfo['locationType'] == 'manual') {
                if ($userLocationInfo['area'] != '') {
                    $businesses = $businesses->where('area_id', $userLocationInfo['area']);
                }
                if ($userLocationInfo['city'] != '') {
                    $businesses = $businesses->where('city_id', $userLocationInfo['city']);
                }
            } else if ($userLocationInfo['locationType'] == 'currentLocation') {
                if ($userLocationInfo['lat'] != '' && $userLocationInfo['long'] != '') {
                    $businesses = $businesses->withinDistance($userLocationInfo['lat'], $userLocationInfo['long'], $userLocationInfo['radius']); // 5 KM radius

                }
            }
        }
        if (isset($request->category) && !empty($request->category)) {
            $cat = BusinessCategory::where('slug', $request->category)->first('id');
            if ($cat) {
                $businesses =  $businesses->where('business_category_id', $cat->id);
            }
        }
        $businesses =  $businesses->limit($request->limit)
            ->skip($request->offset)
            ->get();

        foreach ($businesses as $key => $business) {
            $businesses[$key]->address = $this->getBusinessAddress($business);
            $businesses[$key]->is_favorite = false;
            if (Auth::check()) {
                $favorite = Favorite::where('business_id', $business->id)
                    ->where('user_id', Auth::user()->id)
                    ->where('favorite_type', 'business')
                    ->first();
                if ($favorite) {
                    $businesses[$key]->is_favorite = true;
                }
            }
        }

        $userLocationInfos = getUserLocationInfo();
        $data['list'] =  view('front.business.elements.storeList', compact('businesses', 'userLocationInfos'))->render();
        $data['counts'] =  $businesses->count();
        return response()->json($data);
    }

    public function businessDetails(Request $request, $slug): View
    {
        $business = Business::select('id', 'name', 'slug', 'business_image', 'address', 'contact', 'business_category_id', 'latitude', 'longitude', 'country_id', 'state_id', 'city_id', 'rating', 'pincode', 'credit')
            ->with([
                'businessCategory',
                'country',
                'state',
                'city',
                'reviews' => function ($query) {
                    $query->where('review_type', 'business')
                        ->with([
                            'user' => function ($query) {
                                $query->select('id', 'first_name', 'last_name', 'profile');
                            }
                        ])
                        ->select('id', 'business_id', 'user_id', 'rating', 'review', 'created_at')
                        ->limit(6);
                }
            ],)
            ->where('slug', $slug)
            ->where('status', 'active')
            ->first();

        if ($business) {
            // review and rating count
            $business->ReviewAndRating = ReviewAndRating::select(
                DB::raw('SUM(CASE WHEN rating = "1" THEN 1 ELSE 0 END) as reviewCount1'),
                DB::raw('SUM(CASE WHEN rating = "2" THEN 1 ELSE 0 END) as reviewCount2'),
                DB::raw('SUM(CASE WHEN rating = "3" THEN 1 ELSE 0 END) as reviewCount3'),
                DB::raw('SUM(CASE WHEN rating = "4" THEN 1 ELSE 0 END) as reviewCount4'),
                DB::raw('SUM(CASE WHEN rating = "5" THEN 1 ELSE 0 END) as reviewCount5'),
                DB::raw('COUNT(rating) as totalReview'),
                // DB::raw('AVG(rating) as avgRating'),
                // DB::raw('SELECT * FROM review_and_ratings WHERE business_id = '.$business->id.' AND review_type = "business" AND user_id = '.Auth::user()->id.' as is_reviewed'),
            )
                ->where('business_id', $business->id)
                // ->where('review_type', 'business')
                ->first();

            // dd($business->ReviewAndRating->toArray());

            $business->address = $this->getBusinessAddress($business);
            $business->is_favorite = false;
            if (Auth::check()) {
                $favorite = Favorite::where('business_id', $business->id)
                    ->where('user_id', Auth::user()->id)
                    ->where('favorite_type', 'business')
                    ->first();
                if ($favorite) {
                    $business->is_favorite = true;
                }
            }

            $setting = getBusinessSettings($business->id);
            $departments = array();
            if ($setting->is_appointment_with_department) {
                $departments = AppointmentDepartment::select('id', 'department_name')->where('business_id', $business->id)->get();
            }
            $appontmenters = Appointmenter::select('id', 'business_id', 'title', 'appointmenter_name', 'appointmenter_image', 'department_id', 'slug', 'rating')
                ->with([
                    'department',
                    'business' => function ($q) {
                        return $q->select('id', 'name', 'slug', 'address', 'latitude', 'longitude', 'business_image', 'credit');
                    },
                    'businessSetting'
                ])
                ->where('business_id', $business->id)
                ->where('status', 'active')
                ->get();

            $expert = array();
            $timeSlots = array();
            $appontmentersHtml = '';
            if (count($appontmenters) == 1) {
                $expert = $appontmenters[0];
                $expert->getLastBooking = isExpertAvailable($expert->id);
                $timeSlots = getAppoinmenterTiming($expert->id, Carbon::now(), null, $expert->business_id);
            } else {
                $appontmentersHtml = view('front.business.elements.appontmenterList', compact('appontmenters'))->render();
            }

            return view('front.business.details', compact('business', 'setting', 'departments', 'appontmentersHtml', 'expert', 'timeSlots'));
        } else {
            return view('404');
        }
    }

    function businessFavorite(Request $request)
    {
        $success = false;
        $is_favorite = false;
        $message = 'Something Wrong!';
        $redirect = route('home');
        $data = array();

        $favorite = Favorite::where('business_id', $request->business_id)
            ->where('user_id', Auth::user()->id)
            ->where('favorite_type', 'business')
            ->first();
        if ($favorite) {
            $favorite->delete();
            $success = true;
            $message = 'Removed from favourite';
        } else {
            $favorite = new Favorite();
            $favorite->business_id = $request->business_id;
            $favorite->user_id = Auth::user()->id;
            $favorite->favorite_type = 'business';
            $favorite->save();
            $success = true;
            $is_favorite = true;
            $message = 'Added to favourite';
        }
        return response()->json(['success' => $success, 'message' => $message, 'data' => $data, 'redirect' => $redirect, 'is_favorite' => $is_favorite]);
    }

    function getBusinessAddress($business): string
    {
        $address = $business->address;
        if (isset($business->city) && !empty($business->city->name)) {
            $address .= ', ' . $business->city->name;
        }
        if (isset($business->state) && !empty($business->state->name)) {
            $address .= ', ' . $business->state->name;
        }
        if (isset($business->country) && !empty($business->country->name)) {
            $address .= ', ' . $business->country->name;
        }
        if (isset($business->pincode) && !empty($business->pincode)) {
            $address .= '-' . $business->pincode;
        }
        return $address;
    }
}
