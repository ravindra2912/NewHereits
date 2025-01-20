<?php

namespace App\Http\Controllers\Front;

use App\Models\User;
use App\Models\Business;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Models\BusinessCategory;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\ProfileUpdateRequest;

class AccountController extends Controller
{
    public function index(): View
    {
        return view('front.account.index');
    }
    public function userProfile(Request $request): View
    {
        // dd(getIpDetails());
        $user = User::find(Auth::user()->id);
        if($user) {
            return view('front.account.profile.user_profile', compact('user'));
        }
        return view('404');
    }

    public function userProfileUpdate(Request $request, $id)
    {
        $success = false;
        $message = 'Something Wrong!';
        $redirect = Route('account.userprofile');
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
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) { // Validation fails
                $message = $validator->errors();
                // $message = $validator->errors()->first();
            } else {

                $update = User::find($id);

                if ($request->hasFile('profile')) {
                    $oldimage = $update->profile;
                    $image_name = fileUploadStorage($request->file('profile'), 'user_images', 500, 500);
                    $update->profile = $image_name;
                }

                $update->first_name = $request->first_name;
                $update->last_name = $request->last_name;
                $update->email = $request->email;
                $update->contact = $request->contact;
                $update->dob = $request->dob;
                $update->gender = $request->gender;
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

    public function changePassword(Request $request): View
    {
       
            return view('front.account.profile.changepassword');
      
    }

    public function changePasswordUpdate(Request $request)
    {
        $success = false;
        $message = 'Something Wrong!';
        $redirect = Route('account.changePassword');
        $data = array();

        try {
            $rules = [
                'old_password' => 'required',
                'password' => 'required|min:6',
                'confirm_password' => 'required|same:password',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) { // Validation fails
                $message = $validator->errors();
                // $message = $validator->errors()->first();
            } else {
                $user = User::find(Auth::user()->id);
                if (password_verify($request->old_password, $user->password)) {
                    $user->password = bcrypt($request->password);
                    $user->save();
                    $success = true;
                    $message = 'Password updated successfully.';
                } else {
                    $message = 'Old password does not match.';
                }
            }
        } catch (\Exception $e) {
            $message = $e->getMessage();
        }
        return response()->json(['success' => $success, 'message' => $message, 'data' => $data, 'redirect' => $redirect]);
    }

    
}
