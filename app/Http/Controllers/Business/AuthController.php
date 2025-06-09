<?php

namespace App\Http\Controllers\Business;

use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\Business;
use Illuminate\Support\Facades\Redirect;


class AuthController extends Controller
{

    /**
     * Display the admin login form.
     */
    public function index(Request $request): View
    {
        if (Auth::check()) {
            if (Auth::user()->role_id == 1) {
                return redirect()->route('admin.login');
            } elseif (Auth::user()->role_id == 2) {
                return redirect()->route('business.login');
            } else {
                return redirect()->route('/');
            }
        }
        return view('business.auth.login');
    }



    /**
     * Handle an incoming authentication request.
     */
    // public function store(Request $request)
    // {
    //     // Attempt to log the user in
    //     if (Auth::attempt(['email' => $request->email, 'password' => $request->password, 'role_id'=>1])) {
    //         return redirect()->route('admin.dashboard');
    //     }

    //     $msg = 'Incorrect username or password.';
    //         return view('admin.auth.login', compact('msg'));
    // }

    public function store(LoginRequest $request): RedirectResponse
    {
        $user = User::with('getBusinessDetails:id,owner_id,name,business_image,subscription_expiry_date')->where('email', $request->email)->where('role_id', 2)->first();
        if ($user && Hash::check($request['password'], $user->password)) {

            if ($user->business_id == null) {
                $business = Business::select('id', 'owner_id','name','business_image','subscription_expiry_date')->where('owner_id', $user->id)->first();
                if ($business) {
                    $user->business_id = $business->id;
                    $user->save();

                    $user->getBusinessDetails = $business;
                } else {
                    return redirect()->back()->with('error', 'Business not found!');
                }
            }
            $request->authenticate();

            $request->session()->regenerate();

            return redirect()->intended(route('business.dashboard', absolute: false));
        } else {
            return redirect()->back()->with('error', 'invalid credentials!');
        }
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $data = session()->only(['hereitsLocation']);
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        // Restore
        session($data);

        return redirect()->route('business.login');
    }
}
