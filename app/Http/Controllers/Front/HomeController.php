<?php

namespace App\Http\Controllers\Front;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

use App\Http\Controllers\Controller;
use App\Models\Business;
use App\Models\BusinessCategory;

class HomeController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function index(Request $request): View
    {
        // dd(getIpDetails());
        $businesses = Business::select('id', 'name', 'slug', 'business_image')->where('status', 'active')->limit(8)->get();
        $businessCategory = BusinessCategory::select('id', 'name', 'image', 'slug')->where('status', 'active')->limit(8)->get();
        // dd($businesses->toArray(), $businessCategory->toArray());
        return view('front.home', compact('businesses', 'businessCategory'));
    }

    
}
