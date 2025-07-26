<?php

namespace App\Http\Controllers\Front;

use App\Models\Faq;
use App\Models\Business;
use App\Models\Favorite;
use App\Models\LegalPage;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function index(Request $request): View
    {
        retry:
        $fevoriteBusinesses = array();
        $userLocationInfo = getUserLocationInfo();
        $businesses = Business::select('id', 'name', 'slug', 'business_image', 'area_id', 'city_id', 'latitude', 'longitude')
            ->where('subscription_expiry_date', '>=', now());
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
        $businesses = $businesses->where('status', 'active')->limit(8)->get();

        // if data get empty then re try for 15 km redius
        if ($businesses->isEmpty() && $userLocationInfo['radius'] == 5) { 
            $userLocationInfo['radius'] = 15;
            $updatedData = [
                'data' => $userLocationInfo,
                'expires_at' => now()->addDays(7),
            ];
            session()->put('hereitsLocation', $updatedData);
            goto retry;
        }

        $businessCategory = getBusinessCategory();

        if (Auth::check() && Auth::user()->role_id != 1) {
            $fevoriteBusinesses = Favorite::select('id', 'business_id')
                ->with(['business' => function ($q) {
                    return $q->select('id', 'name', 'slug', 'business_image')
                        ->where('subscription_expiry_date', '>=', now());
                }])
                ->where('user_id', Auth::user()->id)
                ->where('favorite_type', 'business')
                ->limit(8)
                ->get();
        }

        // dd($businesses->toArray(), $businessCategory->toArray());
        return view('front.home', compact('businesses', 'businessCategory', 'fevoriteBusinesses'));
    }

    public function faq(Request $request): View
    {
        $faqs = Cache::rememberForever('Faq', function () { // 1440/60 = 1 day
            return Faq::select('id', 'question', 'answer', 'type')->get()->groupBy('type');
        });
        return view('front.faq', compact('faqs'));
    }

    public function aboutUs(Request $request): View
    {
        return view('front.about-us');
    }

    public function contactUs(Request $request): View
    {
        return view('front.contact-us');
    }

    public function privacyPolicy(Request $request): View
    {
        $privacy = Cache::rememberForever('PrivacyPolicy', function () { // 1440/60 = 1 day
            return LegalPage::where('page_type', 'PrivacyPolicy')->first();
        });
        return view('front.privacy-policy', compact('privacy'));
    }

    public function termAndCondition(Request $request): View
    {
        $term = Cache::rememberForever('TermsAndCondition', function () { // 1440/60 = 1 day
            return LegalPage::where('page_type', 'TermsAndCondition')->first();
        });
        return view('front.term-and-condition', compact('term'));
    }

    public function CopyRight(Request $request): View
    {
        $CopyRight = Cache::rememberForever('CopyRight', function () { // 1440/60 = 1 day
            return LegalPage::where('page_type', 'CopyRight')->first();
        });
        return view('front.copy-right', compact('CopyRight'));
    }
    
    public function CancellationAndRefundPolicy(Request $request): View
    {
        $data = Cache::rememberForever('CancellationAndRefundPolicy', function () { // 1440/60 = 1 day
            return LegalPage::where('page_type', 'CancellationAndRefundPolicy')->first();
        });
        return view('front.cancellation_and_refund_policy', compact('data'));
    }
}
