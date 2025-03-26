<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\CityArea;
use App\Models\LegalPage;

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
                if($data['locationType'] == 'manual'){
                    if($data['area'] != null){
                        $areaData = CityArea::select('id', 'city_id', 'area_name', 'pincode', 'latitude','longitude')
                            ->with(['city' => function($e){
                                $e->select('id', 'name');
                            }])    
                            ->find($data['area']);
                        
                        if($areaData){
                            $data['fullAddress'] =  $areaData->area_name .", ". $areaData->city->name;
                        }

                    }else if($data['city'] != null){
                        $cityData = City::select('id', 'name')->find($data['city']);
                        if($cityData){
                            $data['fullAddress'] =  $cityData->name;
                        }
                    }
                }

                session()->put('hereitsLocation', $data);
                
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
