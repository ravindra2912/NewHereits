<?php

namespace App\Http\Controllers\Front;

use App\Models\Business;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Models\Appointmenter;
use App\Models\BusinessCategory;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;
use App\Models\AppointmentDepartment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Favorite;

class BusinessController extends Controller
{
    public function index(Request $request, $catSlug = null): View
    {
        $businessCategory = BusinessCategory::select('id', 'name', 'image', 'slug')->where('status', 'active')->limit(8)->get();
        return view('front.business.list', compact('businessCategory', 'catSlug'));
    }

    public function getBusiness(Request $request)
    {

        $businesses = Business::select('id', 'name', 'slug', 'business_image', 'address', 'business_category_id', 'country_id', 'state_id', 'city_id')
            ->with([
                'businessCategory',
                'country',
                'state',
                'city',
            ])
            ->where('status', 'active');
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

        $data['list'] =  view('front.business.elements.storeList', compact('businesses'))->render();
        $data['counts'] =  $businesses->count();
        return response()->json($data);
    }

    public function businessDetails(Request $request, $slug): View
    {
        $business = Business::select('id', 'name', 'slug', 'business_image', 'address', 'contact', 'business_category_id', 'latitude', 'longitude', 'country_id', 'state_id', 'city_id')
            ->with([
                'businessCategory',
                'country',
                'state',
                'city',
            ])
            ->where('slug', $slug)
            ->where('status', 'active')
            ->first();

        if ($business) {
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
            $appontmenters = Appointmenter::select('id', 'appointmenter_name', 'appointmenter_image', 'department_id', 'slug')->with('department')->where('business_id', $business->id)->get();

            $appontmentersHtml = view('front.business.elements.appontmenterList', compact('appontmenters'))->render();
            return view('front.business.details', compact('business', 'setting', 'departments', 'appontmentersHtml'));
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
        return $address;
    }
}
