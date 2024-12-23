<?php

namespace App\Http\Controllers\Business;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Business;
use App\Models\LegalPage;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Models\BusinessCategory;
use Yajra\DataTables\DataTables;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\ProfileUpdateRequest;
use App\Models\BusinessSetting;
use App\Models\BusinessTiming;

class SettingController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function profile(Request $request)
    {
        $user = User::find(Auth::user()->id);
        return view('business.setting.profile', compact('user'));
    }

    public function profileUpdate(Request $request, $id)
    {
        $success = false;
        $message = 'Something Wrong!';
        $redirect = Route('business.setting.profile');
        $data = array();

        try {
            $rules = [
                'profile' => 'nullable|mimes:jpg,jpeg,png|',
                'first_name' => 'required',
                'last_name' => 'required',
                'email' => 'required|email|unique:users,email,'.$id,
                'contact' => 'required|numeric|unique:users,contact,'.$id,
                'dob' => 'nullable|date',
                'gender' => 'nullable',
                'password' => 'nullable|min:6'
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) { // Validation fails
                $message = $validator->errors();
                // $message = $validator->errors()->first();
            } else {

                $update = User::find($id);

                if ($request->hasFile('profile')) {
                    $oldimage = $update->profile;
                    $image_name = fileUploadStorage($request->file('profile'), 'user_images', 1000, 1000);
                    $update->profile = $image_name;
                }

                $update->first_name = $request->first_name;
                $update->last_name = $request->last_name;
                $update->email = $request->email;
                $update->contact = $request->contact;
                $update->dob = $request->dob;
                $update->gender = $request->gender;
                if(!empty($request->password)){
                    $update->password = Hash::make($request->password);
                }
                
                $update->save();

                // Remove old uploaded image if exist
                if (isset($oldimage)) {
                    fileRemoveStorage($oldimage);
                }

                $success = true;
                $message = 'Profile updated successfully.';
            }
        } catch (\Exception $e) {
            $message = $e->getMessage();
            if (isset($image_name) && !empty($image_name)) {
                fileRemoveStorage($image_name);
            }
        }
        return response()->json(['success' => $success, 'message' => $message, 'data' => $data, 'redirect' => $redirect]);
    }

    public function businessProfile(Request $request)
    {
        // dd(Carbon::now()->addDay(6)->format('l'));

        $business = Business::find(Auth::user()->business_id);
        $businessCat = BusinessCategory::get();
        return view('business.setting.business_profile', compact('business', 'businessCat'));
    }

    public function businessUpdate(Request $request, $id)
    {
        $success = false;
        $message = 'Something Wrong!';
        $redirect = Route('business.setting.business');
        $data = array();

        try {
            $rules = [
                'business_image' => 'nullable|mimes:jpg,jpeg,png|',
                'name' => 'required',
                'business_category_id' => 'required',
                'business_type' => 'required',
                'address' => 'required',
                'contact' => 'required|numeric|unique:businesses,contact,' . $id,
                'state_id' => 'required|exists:states,id',
                'city_id' => 'required|exists:cities,id',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) { // Validation fails
                $message = $validator->errors();
                // $message = $validator->errors()->first();
            } else {

                $update = Business::find($id);

                if ($request->hasFile('business_image')) {
                    $oldimage = $update->profile;
                    $image_name = fileUploadStorage($request->file('business_image'), 'business_images', 500, 500);
                    $update->business_image = $image_name;
                }

                $update->name = $request->name;
                $update->business_category_id = $request->business_category_id;
                $update->business_type = $request->business_type;
                $update->address = $request->address;
                $update->contact = $request->contact;
                $update->state_id = $request->state_id;
                $update->city_id = $request->city_id;
                $update->save();

                // Remove old uploaded image if exist
                if (isset($oldimage)) {
                    fileRemoveStorage($oldimage);
                }

                $success = true;
                $message = 'Business update successfully.';
            }
        } catch (\Exception $e) {
            $message = $e->getMessage();
            if (isset($image_name) && !empty($image_name)) {
                fileRemoveStorage($image_name);
            }
        }
        return response()->json(['success' => $success, 'message' => $message, 'data' => $data, 'redirect' => $redirect]);
    }
    
    public function businessTiming(Request $request)
    {
        // dd(Carbon::now()->addDay(6)->format('l'));

        $timing = [];
        foreach( config('const.week_day_name') as $day){
            $temp = array();
            $temp['day'] = $day;
            $temp['timing'] = BusinessTiming::where('day', $day)->whereNull('appointmenter_id')->where('business_id', Auth::user()->business_id)->orderBy('start_time', 'asc')->get();
            $timing[] = $temp;
        }
        return view('business.setting.business_timing', compact('timing'));
    }

    public function businessTimingStore(Request $request)
    {
        $success = false;
        $message = 'Something Wrong!';
        $redirect = Route('business.setting.business.timing');
        $data = array();

        try {
            $rules = [
                'day' => 'required',
                'start_time' => 'required',
                'end_time' => 'required|after:start_time',
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) { // Validation fails
                $message = $validator->errors();
                // $message = $validator->errors()->first();
            } else {
                $insert = new BusinessTiming();
                $insert->business_id = getBusinessId();
                $insert->day = $request->day;
                $insert->start_time = $request->start_time;
                $insert->end_time = $request->end_time;
                $insert->save();

                $success = true;
                $message = 'Time add successfully.';
            }
        } catch (\Exception $e) {
            $message = $e->getMessage();
        }
        return response()->json(['success' => $success, 'message' => $message, 'data' => $data, 'redirect' => $redirect]);
    }
    
    public function businessTimingSestroy(Request $request)
    {
        $success = false;
        $message = 'Something Wrong!';
        $redirect = Route('business.setting.business.timing');
        $data = array();

        try {
                $timing = BusinessTiming::find($request->id);
                if($timing){
                    $timing->delete();
                }
                $success = true;
                $message = 'Time deleted successfully.';
            
        } catch (\Exception $e) {
            $message = $e->getMessage();
        }
        return response()->json(['success' => $success, 'message' => $message, 'data' => $data, 'redirect' => $redirect]);
    }

    public function systemSetting(Request $request)
    {
        $setting = getBusinessSettings();
        return view('business.setting.systemsetting', compact('setting'));
    }

    public function systemSettingUpdate(Request $request)
    {
        $success = false;
        $message = 'Something Wrong!';
        $redirect = Route('business.setting.systemsetting');
        $data = array();

        try {
            $rules = [
                // 'business_image' => 'nullable|mimes:jpg,jpeg,png|',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) { // Validation fails
                $message = $validator->errors();
                // $message = $validator->errors()->first();
            } else {

                $update = BusinessSetting::where('business_id',getBusinessId())->first();
                if(!$update){
                    $update = new BusinessSetting();
                    $update->business_id = getBusinessId();
                }
                $update->is_appointment_with_department = isset($request->is_appointment_with_department) && $request->is_appointment_with_department == 'on'?1:0;
                $update->is_appointment_book_with_time_slote = isset($request->is_appointment_book_with_time_slote) && $request->is_appointment_book_with_time_slote == 'on'?1:0;
                $update->save();

                $success = true;
                $message = 'Setting update successfully.';
            }
        } catch (\Exception $e) {
            $message = $e->getMessage();
        }
        return response()->json(['success' => $success, 'message' => $message, 'data' => $data, 'redirect' => $redirect]);
    }
    
}
