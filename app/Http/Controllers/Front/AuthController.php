<?php

namespace App\Http\Controllers\Front;

use App\Models\User;
use App\Models\Business;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;


class AuthController extends Controller
{
    public function store(LoginRequest $request)
    {
        $success = false;
        $message = 'Something Wrong!';
        $redirect = '';
        $data = array();

        try {
            $user = User::where('email', $request->email)->whereIn('role_id', [2, 3])->first();
            if ($user && Hash::check($request['password'], $user->password)) {
                if($user->role_id == 2 && $user->business_id == null){
                    $business = Business::select('id')->where('owner_id', $user->id)->first();
                    $user->business_id = $business->id;
                    $user->save();
                }
                $request->authenticate();
                $request->session()->regenerate();
                $success = true;
                $message = 'Login Successfully!';
            } else {
                $message = 'Invalid Credentials!';
            }
        } catch (\Exception $e) {
            $message = $e->getMessage();
        }
        return response()->json(['success' => $success, 'message' => $message, 'data' => $data, 'redirect' => $redirect]);
    }

    public function register(Request $request)
    {
        $success = false;
        $message = 'Something Wrong!';
        $redirect = Route('home');
        $data = array();

        try {
            $rules = [
                'first_name' => 'required',
                'last_name' => 'required',
                'email' => 'required|email|unique:users,email',
                'contact' => 'required|numeric|digits:10|unique:users,contact',
                'password' => 'required',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) { // Validation fails
                $message = $validator->errors();
                // $message = $validator->errors()->first();
            } else {

                $insert = new User();
                $insert->first_name = $request->first_name;
                $insert->last_name = $request->last_name;
                $insert->email = $request->email;
                $insert->contact = $request->contact;
                $insert->password = Hash::make($request->password);
                $insert->save();

                Auth::logout();
                Auth::login($insert);

                $success = true;
                $message = 'User register successfully.';
            }
        } catch (\Exception $e) {
            $message = $e->getMessage();
        }
        return response()->json(['success' => $success, 'message' => $message, 'data' => $data, 'redirect' => $redirect]);
    }

    public function forgotPassword(Request $request)
    {
        $success = false;
        $message = 'Something Wrong!';
        $redirect = '';
        $data = array();

        try {
            $rules = [
                'email' => 'required|email',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) { // Validation fails
                $message = $validator->errors();
                // $message = $validator->errors()->first();
            } else {
                $user = User::where('email', $request->email)->first();
                if ($user) {
                    $user->password = Hash::make('123456');
                    $user->save();
                    $success = true;
                    $message = 'Password reset successfully.';
                } else {
                    $message = 'Email not found.';
                }
            }
        } catch (\Exception $e) {
            $message = $e->getMessage();
        }
        return response()->json(['success' => $success, 'message' => $message, 'data' => $data, 'redirect' => $redirect]);
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home');
    }

    public function registerBusinessView(): View
    {
        $businessCat = getBusinessCategory();
        return view('front.auth.businessRegistration', compact('businessCat'));
    }


    public function registerBusiness(Request $request)
    {
        $success = false;
        $message = 'Something Wrong!';
        $redirect = Route('home');
        $data = array();

        try {
            $rules = [
                'business_image' => 'required|mimes:jpg,jpeg,png,webp|',
                'business_name' => 'required',
                'business_contact' => 'required|numeric|digits:10|unique:businesses,contact',
                'business_category_id' => 'required',
                'address' => 'required',
                'state_id' => 'required|exists:states,id',
                'city_id' => 'required|exists:cities,id',
                'area_id' => 'required|exists:city_areas,id',
                'pincode' => 'required',
            ];

            if(!Auth::check()){
                $rules['user_email'] = 'required|email|exists:users,email';
                $rules['password'] = 'required';
            }

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) { // Validation fails
                $message = $validator->errors();
                // $message = $validator->errors()->first();
            } else {
                
                if(!Auth::check()){
                    $user = User::where('email', $request->user_email)->first();
                    if ($user && Hash::check($request['password'], $user->password)) {
                        // Auth::login($user);
                        $user_id = $user->id;
                    } else {
                        $message = 'Invalid Email id and Password!';
                        return response()->json(['success' => $success, 'message' => $message, 'data' => $data, 'redirect' => $redirect]);
                    }
                }else{
                    $user_id = Auth::user()->id;
                }

                $insert = new Business();

                $image_name = fileUploadStorage($request->file('business_image'), 'business_images', 500, 500);
                $insert->business_image = $image_name;

                $insert->owner_id = $user_id;
                $insert->name = $request->business_name;
                $insert->contact = $request->business_contact;
                $insert->slug = generateUniqueSlug(Business::class, $request->business_name);
                $insert->business_category_id = $request->business_category_id;
                $insert->address = $request->address;
                // $insert->latitude = $request->latitude;
                // $insert->longitude = $request->longitude;
                $insert->state_id = $request->state_id;
                $insert->city_id = $request->city_id;
                $insert->area_id = $request->area_id;
                $insert->pincode = $request->pincode;
                $insert->status = 'pending';
                $insert->save();

                //change user role to seller
                $user = User::select('id', 'role_id', 'business_id')->find($insert->owner_id);
                if ($user && ( $user->role_id != 2 || $user->business_id == null)) {
                    $user->business_id =  $insert->id;
                    $user->role_id = 2;
                    $user->save();
                }

                $success = true;
                $message = 'User register successfully.';
            }
        } catch (\Exception $e) {
            $message = $e->getMessage();
            if (isset($image_name) && !empty($image_name)) {
                fileRemoveStorage($image_name);
            }
        }
        return response()->json(['success' => $success, 'message' => $message, 'data' => $data, 'redirect' => $redirect]);
    }
}
