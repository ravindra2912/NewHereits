<?php

namespace App\Http\Controllers\Front;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Business;
use App\Models\CityArea;
use Illuminate\View\View;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Appointmenter;
use App\Models\BusinessTiming;
use App\Models\BusinessSetting;
use App\Mail\ResetPasswordEmail;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Support\Facades\Redirect;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{

    public $forgotPasswordTimeLimite = 110; // in minutes
    function __construct() {}

    public function store(LoginRequest $request)
    {
        $success = false;
        $message = 'Something Wrong!';
        $redirect = '';
        $data = array();

        try {
            $user = User::with('getBusinessDetails:id,owner_id,name,business_image,subscription_expiry_date')->where('email', $request->email)->whereIn('role_id', [2, 3])->first();
            if ($user && Hash::check($request['password'], $user->password)) {
                if (isset($request->notification_token)) {
                    $user->notification_token = $request->notification_token;
                    $user->save();
                }
                if ($user->role_id == 2 && $user->business_id == null) {
                    $business = Business::select('id', 'owner_id', 'name', 'business_image', 'subscription_expiry_date')->where('owner_id', $user->id)->first();
                    $user->business_id = $business->id;
                    $user->save();
                    $user->getBusinessDetails = $business;
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
        $data = array();
        $redirect = '';

        $rules = [
            'email' => 'required|email',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) { // Validation fails
            // $message = $validator->errors();
            $message = $validator->errors()->first();
        } else {
            try {
                $User = User::select('id', 'email', 'first_name')->where('email', $request->email)->first();
                if ($User) {

                    //Check  if token exist then delete first
                    if ($request->email) {
                        DB::table('password_reset_tokens')->where('email', $request->email)->delete();
                    }
                    $token = Str::random(64);
                    DB::table('password_reset_tokens')->insert([
                        'email' => $request->email,
                        'token' => $token,
                        'created_at' => Carbon::now()
                    ]);
                    $maildata = [
                        'username' => $User->first_name,
                        'token' => $token,
                        'url' => route('password.reset', [$token, $request->email])
                    ];

                    Mail::to($request->email)->send(new ResetPasswordEmail($maildata));
                    $success = true;
                    $message =  'Successfully varification code send from you email address, please check your email';
                } else {
                    $message =  'Please enter registered email address';
                }
            } catch (\Exception $e) {
                $message = $e->getMessage();
            }
        }
        return response()->json(['success' => $success, 'message' => $message, 'data' => $data, 'redirect' => $redirect]);
    }

    function ResetPasswordForm($token, $email)
    {
        $data = DB::table('password_reset_tokens')->where('email', $email)->where('token', $token)->first();
        if ($data) {
            $to = Carbon::parse($data->created_at);
            $from = Carbon::now();
            $diffInMinutes = $to->diffInMinutes($from);
            if ($diffInMinutes <= $this->forgotPasswordTimeLimite) {
                return view('front.auth.resetPassword', compact('token', 'email'));
            }
        }
        exit('Invalid Token');
    }

    public function ResetPassword(Request $request)
    {
        $success = false;
        $message = 'Something Wrong!';
        $data = array();
        $redirect = Route('home');

        $rules = [
            'password' => 'required|min:6',
            'confirm_password' => 'required|min:6|same:password',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) { // Validation fails
            $message = $validator->errors();
            // $message = $validator->errors()->first();
        } else {
            try {
                $data = DB::table('password_reset_tokens')->where('email', $request->email)->where('token', $request->token)->first();
                if ($data) {
                    $User = User::where('email', $request->email)->first();
                    $to = Carbon::parse($data->created_at);
                    $from = Carbon::now();
                    $diffInMinutes = $to->diffInMinutes($from);
                    if ($diffInMinutes <= $this->forgotPasswordTimeLimite) {
                        $User = User::select('id', 'email', 'password')->where('email', $request->email)->first();
                        if ($User) {
                            $User->password = Hash::make($request->password);
                            $User->save();

                            $success = true;
                            $message =  'Password reset successfully.';
                        } else {
                            $message = 'Invalid Token';
                        }
                    } else {
                        $message = 'Token expired, please try again.';
                    }
                } else {
                    $message = 'Invalid Token';
                }
            } catch (\Exception $e) {
                $message = $e->getMessage();
            }
        }
        return response()->json(['success' => $success, 'message' => $message, 'data' => $data, 'redirect' => $redirect]);
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $data = session()->only(['hereitsLocation']);

        User::where('id', Auth::user()->id)->update(['notification_token' => null]);

        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Restore
        session($data);
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
        $redirect = Route('business.dashboard');
        $data = array();

        DB::beginTransaction();

        try {
            $rules = [
                'business_image' => 'required|mimes:jpg,jpeg,png,webp|',
                'business_name' => 'required',
                'business_contact' => 'required|numeric|digits:10|unique:businesses,contact',
                'business_category_id' => 'required',
                'address' => 'required',
                'state_id' => 'required|exists:states,id',
                'city_id' => 'required|exists:cities,id',
                'pincode' => 'required',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) { // Validation fails
                $message = $validator->errors();
                // $message = $validator->errors()->first();
            } else if ($request->latitude == null || $request->longitude == null) {
                $message = 'Pleaase select location on map';
            } else {

                if (!Auth::check()) {
                    $message = 'Session expired, please login again.';
                } else {
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
                $insert->latitude = $request->latitude;
                $insert->longitude = $request->longitude;
                $insert->state_id = $request->state_id;
                $insert->city_id = $request->city_id;

                $insert->pincode = $request->pincode;
                $insert->status = 'pending';

                if ($request->area != null && $request->area != '') {
                    $areaDetail = CityArea::where('city_id', $request->city_id)
                        // ->where('area_name', strtolower($request->area))
                        ->whereRaw('LOWER(area_name) = ?', [strtolower($request->area)])
                        ->first();
                    if ($areaDetail) {
                        $insert->area_id = $areaDetail->id;
                    } else {
                        $inserArea = new CityArea();
                        $inserArea->pincode = $request->pincode;
                        $inserArea->city_id = $request->city_id;
                        $inserArea->area_name = strtolower($request->area);
                        $inserArea->save();
                        $insert->area_id = $inserArea->id;
                    }
                }

                $insert->save();

                updateBusinessSeo($insert->id);

                // assign appoinment system to business
                BusinessSetting::create([
                    'business_id' => $insert->id,
                    'is_appointment_system' => true,
                ]);

                // add default expert for show booking
                $expertInsert = new Appointmenter();
                $expertInsert->business_id = $insert->id;
                $expertInsert->appointmenter_name = $insert->name;
                $expertInsert->number_of_bookings_per_day = 25;
                $expertInsert->timing_per_appointment = 15;
                $expertInsert->is_default = true;
                $expertInsert->slug  = generateUniqueSlug(Appointmenter::class, $insert->name);
                $expertInsert->save();

                // add business and expert timing
                $start = '08:00'; // 8 AM
                $end = '20:00';   // 8 PM
                foreach (config('const.week_day_name') as $day) {
                    // Add for business
                    $businessTime = new BusinessTiming();
                    $businessTime->business_id = $insert->id;
                    $businessTime->day = $day;
                    $businessTime->start_time = $start;
                    $businessTime->end_time = $end;
                    $businessTime->save();

                    // Add for expert
                    $expertTime = new BusinessTiming();
                    $expertTime->business_id = $insert->id;
                    $expertTime->appointmenter_id = $expertInsert->id;
                    $expertTime->day = $day;
                    $expertTime->start_time = $start;
                    $expertTime->end_time = $end;
                    $expertTime->save();
                }

                //change user role to seller
                $user = User::select('id', 'role_id', 'business_id')->find($insert->owner_id);
                if ($user && ($user->role_id != 2 || $user->business_id == null)) {
                    $user->role_id = 2;
                }
                $user->business_id =  $insert->id;
                $user->save();

                if ($user) {
                    $user->getBusinessDetails = Business::select('id', 'owner_id', 'name', 'business_image', 'subscription_expiry_date')->find($insert->id);
                }
                Auth::logout();
                Auth::login($user);

                $success = true;
                $message = 'Business register successfully.';

                Cache::forget('getAvailableCities'); //this function in helpers.php file getAvailableCities()

                DB::commit();
            }
        } catch (\Exception $e) {
            $message = $e->getMessage();
            if (isset($image_name) && !empty($image_name)) {
                fileRemoveStorage($image_name);
            }
            DB::rollBack();
        }
        return response()->json(['success' => $success, 'message' => $message, 'data' => $data, 'redirect' => $redirect]);
    }




    public function redirectToGoogle(Request $request)
    {
        $token = '';
        if (isset($request->notificationtoken) && !empty($request->notificationtoken)) {
            $token = $request->notificationtoken;
        }
        session()->put('googleAuth', [
            'data' => $token,
            'redirectUrl' => url()->previous(),
            'expires_at' => now()->addMinutes(5), // Set your desired expiration
        ]);
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $notificationtoken = '';
            $session = session('googleAuth');
            if ($session && (isset($session['data']) != null || $session['redirectUrl'] != null)) {
                $notificationtoken = $session['data'];
                $redirectUrl = $session['redirectUrl'];
            }

            $googleUser = Socialite::driver('google')->stateless()->user();
            // Check if the user already exists
            $user = User::where('email', $googleUser->getEmail())->first();

            if ($user) {
                // Update user's Google ID if not set
                if (!$user->google_id) {
                    $user->update([
                        'google_key' => $googleUser->getId(),
                    ]);
                }
                if ($user->role_id == 2 && $user->business_id == null) {
                    $business = Business::select('id', 'owner_id')->where('owner_id', $user->id)->first();
                    $user->business_id = $business->id;
                }
                $user->notification_token = $notificationtoken;
                $user->save();
            } else {
                $name = explode(' ', $googleUser->getName());
                // Create a new user
                $user = new User();
                if ($googleUser->getAvatar() != null) {
                    $imageUrl = $googleUser->getAvatar();

                    // Generate a clean image name (or use your own naming logic)
                    $imageName = Str::random(10) . '.png';

                    // Define the path inside the 'public' disk
                    $path = 'user_images/' . $imageName;

                    // Get the image content from the URL
                    $imageContents = file_get_contents($imageUrl);

                    // Store the image in storage/app/public/product-images
                    Storage::disk('public')->put($path, $imageContents);

                    $user->profile =  $path;
                }


                $user->first_name = $name[0];
                $user->last_name = isset($name[1]) != null ? $name[1] : $name[0];
                $user->email = $googleUser->getEmail();
                $user->google_key = $googleUser->getId();
                $user->notification_token = $notificationtoken;

                $user->password = Hash::make(Str::random(8)); // Generate a random 8-character password
                $user->save();
            }

            // Log the user in
            $user->load('getBusinessDetails:id,owner_id,name,business_image,subscription_expiry_date');
            Auth::login($user);

            if (isset($redirectUrl) && !empty($redirectUrl)) {
                return redirect($redirectUrl);
            } else {
                return redirect()->intended('/');
            }
        } catch (\Exception $e) {
            dd($e->getMessage());
            // Handle exceptions
            return redirect('/')->with('error', 'Failed to login with Google.');
        }
    }
}
