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

class BusinessController extends Controller
{
    public function index(Request $request, $catSlug = null): View
    {
        $businessCategory = BusinessCategory::select('id', 'name', 'image', 'slug')->where('status', 'active')->limit(8)->get();
        return view('front.business.list', compact('businessCategory', 'catSlug'));
    }

    public function getBusiness(Request $request)
    {
        
        $businesses = Business::select('id', 'name', 'slug', 'business_image', 'address', 'business_category_id')
            ->with(['businessCategory'])
            ->where('status', 'active');
            if(isset($request->category) && !empty($request->category)){
                $cat = BusinessCategory::where('slug', $request->category)->first('id');
                if($cat){
                    $businesses =  $businesses->where('business_category_id', $cat->id);
                }
            }
            $businesses =  $businesses->limit($request->limit)
            ->skip($request->offset)
            ->get();

           $data['list'] =  view('front.business.elements.storeList', compact('businesses'))->render();
           $data['counts'] =  $businesses->count();
           return response()->json($data);
    }
    
    public function businessDetails(Request $request, $slug)
    {
        $business = Business::select('id', 'name', 'slug', 'business_image', 'address', 'contact', 'business_category_id', 'latitude', 'longitude')
            ->with(['businessCategory'])
            ->where('slug', $slug)
            ->where('status', 'active')
            ->first();

        if($business){
            $setting = getBusinessSettings($business->id);
            return view('front.business.details', compact('business', 'setting'));
        }else{
            return view('404');
        }

    }

    
}
