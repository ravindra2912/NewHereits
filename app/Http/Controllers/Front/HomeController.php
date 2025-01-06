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
use App\Models\Favorite;

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

    
}
