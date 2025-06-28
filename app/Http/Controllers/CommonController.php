<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Business;
use App\Models\CityArea;
use App\Models\LegalPage;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Appointmenter;

class CommonController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function getCities(Request $request)
    {
        $citeis = getCities($request->state_id);
        return response()->json($citeis);
    }

    public function getCitieArea(Request $request)
    {
        $areas = getCitieArea($request->city_id);
        return response()->json($areas);
    }

    //*************** for front location Start******************* */
    public function getAreas(Request $request)
    {
        $success = false;
        $message = 'Something Wrong!';
        $redirect = '';
        $data = array();

        try {
            $rules = [
                'area_search' => 'nullable',
                'city' => 'required'
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) { // Validation fails
                // $message = $validator->errors();
                $message = $validator->errors()->first();
            } else {
                $areas = CityArea::select('id', 'area_name', 'city_id', 'pincode')->where('city_id', $request->city);
                if ($request->area_search) {
                    $areas = $areas->where('area_name', 'like', '%' . $request->area_search . '%');
                }
                $areas = $areas->get();

                $html = '';
                if ($areas && count($areas) > 0) {
                    foreach ($areas as $val) {
                        $html .= "  <li >
                                    <input id='$val->id' name='location' value='$val->area_name' class='custom-control-input' type='radio'>
                                    <label class='location-box' tabindex='2' for='$val->id' onclick='setLocation(\"area\", $val->id)'>
                                        <span class='fas fa-map-marker-alt location-icon'></span>
                                        <p class='location-name'>$val->area_name</p>
                                    </label>
                                </li>";
                    }
                } else {
                    $html .= "  <li>
                                    <label class='w-100 ' tabindex='2'>
                                        <p class='location-name border-bottom-0 text-center'>Area not availabel</p>
                                    </label>
                                </li>";
                }

                $data['area'] = $html;
                $success = true;
                $message = 'success';
            }
        } catch (\Exception $e) {
            $message = $e->getMessage();
        }

        return response()->json(['success' => $success, 'message' => $message, 'data' => $data, 'redirect' => $redirect]);
    }

    public function getSearch(Request $request)
    {
        $success = false;
        $message = 'Something Wrong!';
        $redirect = '';
        $data = array();

        try {
            $search = $request->search;

            $businesses = Business::select('id', 'name', 'slug', DB::raw("'Business' as type"))
                ->where('name', 'like', "%{$search}%")
                ->where('status', 'active')
                ->union(
                    Appointmenter::select('id', 'appointmenter_name as name', 'slug', DB::raw("'Expert' as type"))
                        ->where('appointmenter_name', 'like', "%{$search}%")
                        ->where('status', 'active')
                )
                ->limit(10)
                ->get();


            $html = '';
            if ($businesses && count($businesses) > 0) {
                foreach ($businesses as $val) {
                    if ($val->type == 'Business') {
                        $html .= '<li><span><a class="text-dark" href="' . route('business-details', $val->slug) . '"> <i class="fas fa-building  pr-2"></i>' . $val->name . '</a></span><span style="float: right;">' . $val->type . '</span></li>';
                    } else {
                        $html .= '<li><span><a class="text-dark" href="' . route('expert', $val->slug) . '"> <i class="fas fa-user-tie  pr-2"></i>' . $val->name . '</a></span><span style="float: right;">' . $val->type . '</span></li>';
                    }
                }
            } else {
                $html .= "  <li>
                                    <label class='w-100 ' tabindex='2'>
                                        <p class='location-name border-bottom-0 text-center'>No results found</p>
                                    </label>
                                </li>";
            }

            $data = $html;
            $success = true;
            $message = 'success';
        } catch (\Exception $e) {
            $message = $e->getMessage();
        }

        return response()->json(['success' => $success, 'message' => $message, 'data' => $data, 'redirect' => $redirect]);
    }

    public function getLocationInfo(Request $request)
    {
        $success = false;
        $message = 'Something Wrong!';
        $redirect = '';
        $data = array();
        try {
            $rules = [
                'data' => 'required',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) { // Validation fails
                // $message = $validator->errors();
                $message = $validator->errors()->first();
            } else {
                $data = $request->data;
                // dd($data);
                if ($data['locationType'] == 'manual') {
                    if ($data['area'] != null) {
                        $areaData = CityArea::select('id', 'city_id', 'area_name', 'pincode', 'latitude', 'longitude')
                            ->with(['city' => function ($e) {
                                $e->select('id', 'name');
                            }])
                            ->find($data['area']);

                        if ($areaData) {
                            $data['fullAddress'] =  $areaData->area_name . ", " . $areaData->city->name;
                            $data['city'] =  $areaData->city_id;
                        }
                    } else if ($data['city'] != null) {
                        $cityData = City::select('id', 'name')->find($data['city']);
                        if ($cityData) {
                            $data['fullAddress'] =  $cityData->name;
                        }
                    }
                } else if ($data['locationType'] == 'currentLocation') {
                    $data['fullAddress'] = getAddressOnLatLong($data['lat'], $data['long']);
                } else if ($data['locationType'] == 'searchLocation') {
                    $data['locationType'] = 'currentLocation';
                }

                // dd($data);
                // session()->forget('hereitsLocation');
                // $expiration = now()->addDays(7);
                // session()->put('hereitsLocation', [
                //     'data' => $data,
                //     'expires_at' => $expiration,
                // ]);

                // Retrieve the existing session data
                $location = session('hereitsLocation');

                $updatedData = [
                    'data' => $data,
                    'expires_at' => now()->addDays(7),
                ];

                if ($location) {
                    // Merge or update the session data
                    $location = array_merge($location, $updatedData);
                    session()->put('hereitsLocation', $location);
                } else {
                    // Initialize session with new data
                    session()->put('hereitsLocation', $updatedData);
                }

                // $data = getUserLocationInfo();
                // dd($data);
                // session()->put('hereitsLocation', $data);

                $success = true;
                $message = 'success';
            }
        } catch (\Exception $e) {
            $message = $e->getMessage();
        }

        return response()->json(['success' => $success, 'message' => $message, 'data' => $data, 'redirect' => $redirect]);
    }

    //*************** for front location End******************* */
}
