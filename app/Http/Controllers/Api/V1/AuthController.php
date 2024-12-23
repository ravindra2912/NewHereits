<?php

namespace App\Http\Controllers\Api\V1;

use Auth;
// use Hash;
use Carbon\Carbon;
use App\Models\OwnerOfUser;
use App\Models\UserSetting;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Mail\ResetPasswordEmail;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use App\Models\{Categories, User, UserCategory};

class AuthController extends Controller
{
	public function login(Request $request)
	{
		$success = false;
		$message = 'Something Wrong!';
		$data = array();
		$statuscode = 422;

		try {

			$msg = [];

			$rules['email'] = 'required|string|max:255';
			$rules['password'] = 'required|string|min:6';

			$validator = Validator::make($request->all(), $rules, $msg);
			if ($validator->fails()) {
				$message = $validator->errors()->first();
			} else {
					$identifier = $request->email;
					$user = User::query()
					->where(function ($q) use ($identifier) {
						$q->where('email', $identifier);
						if(is_numeric($identifier) && $identifier > 0){
							$q->orWhere('contact', $identifier);
						}
					})
					->first();

					if ($user && !Hash::check($request->password, $user->password)) {
						$message = "Password mismatch";
						return apiResponce($statuscode, $success, $message, $data);
					}
				
				if ($user) {
					$token = $user->createToken('Laravel Password Grant Client')->accessToken;
					$data['user_details'] = $user->apiObject();
					$data['token'] = $token;
					$user->save();

					$statuscode = 200;
					$success = true;
					$message = 'Success';
				} else {
					$statuscode = 51;
					$message = 'User does not exist';
				}
			}
		} catch (\Exception $e) {
			$message = $e->getMessage();
		}
		return apiResponce($statuscode, $success, $message, $data);
	}

	public function register(Request $request)
	{
		$success = false;
		$message = 'Something Wrong!';
		$data = array();
		$statuscode = 422;
		
		$msgs = [];
		$rules = [
			'first_name' => 'required|max:191',
			'last_name' => 'required|max:191',
			'contact' => 'required|numeric|digits:10|unique:users,contact',
			'email' => 'required|email|unique:users,email|max:191',
			'dob' => 'nullable|date',
			'password' => 'required|min:6',
			'confirm_password' => 'required|min:6',
		];

		
		$validator = Validator::make($request->all(), $rules, $msgs);
		if ($validator->fails()) { // Validation fails
			// $message = $validator->errors();
			$message = $validator->errors()->first();
		} elseif ($request->password != $request->confirm_password) {
			$message =  'Confirm password is not match';
		} else {
			try {
				$User = new User();
				$User->first_name = trim($request->first_name);
				$User->last_name = trim($request->last_name);
				$User->email = trim($request->email);
				$User->contact = $request->contact == 0 ?null:$request->contact;
				$User->dob = $request->dob;
				$User->role_id = 3;
				$User->password = Hash::make($request->password);
				$User->save();

				$user = User::find($User->id);
				$token = $user->createToken('Laravel Password Grant Client')->accessToken;
				$data['user_details'] = $user->apiObject();
				$data['token'] = $token;

				$success = true;
				$message =  'User register SuccessFully';
				$statuscode = 200;
			} catch (\Exception $e) {
				$message = $e->getMessage();
			}
		}
		return apiResponce($statuscode, $success, $message, $data);
	}

	public function forgotPassword(Request $request)
	{
		$success = false;
		$message = 'Something Wrong!';
		$data = array();
		$statuscode = 422;

		$rules = [
			'email' => 'required|email',
		];

		$validator = Validator::make($request->all(), $rules);

		if ($validator->fails()) { // Validation fails
			// $message = $validator->errors();
			$message = $validator->errors()->first();
		} else {
			try {
				$User = User::where('email', $request->email)->first();
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
						'username' => $User->username,
						'token' => $token,
						'url' => route('password.reset', [$token, $request->email])
					];

					Mail::to($request->email)->send(new ResetPasswordEmail($maildata));
					$success = true;
					$message =  'Successfully varification code send from you email address, please check your email';
					$statuscode = 200;
				} else {
					$message =  'Please enter registered email address';
				}
			} catch (\Exception $e) {
				$message = $e->getMessage();
			}
		}
		return apiResponce($statuscode, $success, $message, $data);
	}

	public function ResetPassword(Request $request)
	{
		$success = false;
		$message = 'Something Wrong!';
		$data = array();
		$statuscode = 422;

		$rules = [
			'email' => 'required|email|Exists:users,email',
			'password' => 'required|min:6',
			'confirm_password' => 'required|min:6',
		];

		$validator = Validator::make($request->all(), $rules);

		if ($validator->fails()) { // Validation fails
			// $message = $validator->errors();
			$message = $validator->errors()->first();
		} elseif ($request->password != $request->confirm_password) {
			$message =  'Confirm password is not match';
		} else {
			try {
				$User = User::where('email', $request->email)->first();
				$to = Carbon::parse($User->varification_code_at);
				$from = Carbon::now();
				$diffInMinutes = $to->diffInMinutes($from);
				if ($diffInMinutes <= 5) {
					$User->password = Hash::make($request->password);
					$User->save();

					$success = true;
					$message =  'Success';
					$statuscode = 200;
				} else {
					$message = 'Expired';
				}
			} catch (\Exception $e) {
				$message = $e->getMessage();
			}
		}
		return apiResponce($statuscode, $success, $message, $data);
	}

	public function logout(Request $request)
	{
		$success = false;
		$message = 'Something Wrong!';
		$data = array();
		$statuscode = 422;
		try {
			$user = $request->user();
			$user->tokens()->delete();
			// $user->devices()->delete();
			$success = true;
			$message =  'Logouted';
			$statuscode = 200;
		} catch (\Exception $e) {
			$message = $e->getMessage();
		}
		return apiResponce($statuscode, $success, $message, $data);
	}

}
