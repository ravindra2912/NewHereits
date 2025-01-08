<?php

namespace App\Http\Controllers\Front;

use App\Models\Faq;
use App\Models\Business;
use App\Models\Favorite;
use App\Models\LegalPage;
use Illuminate\View\View;
use Illuminate\Http\Request;

use App\Models\BusinessCategory;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\ProfileUpdateRequest;

class HomeController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function index(Request $request): View
    {
        $fevoriteBusinesses = array();
        $businesses = Business::select('id', 'name', 'slug', 'business_image')->where('status', 'active')->limit(8)->get();
        $businessCategory = BusinessCategory::select('id', 'name', 'image', 'slug')->where('status', 'active')->limit(8)->get();
       
        if (Auth::check()) {
            $fevoriteBusinesses = Favorite::select('id', 'business_id')
            ->with(['business' => function($q){
               return $q->select('id', 'name', 'slug', 'business_image');
            }])
            ->where('favorite_type', 'business')
            ->limit(8)
            ->get();
        }

        // dd($businesses->toArray(), $businessCategory->toArray());
        return view('front.home', compact('businesses', 'businessCategory', 'fevoriteBusinesses'));
    }

    public function faq(Request $request): View
    {
        // Cache::forget('Faq'); // Clear Cache
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
}
