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

class AppointmentController extends Controller
{
    public function index(Request $request, $slug): View
    {
        $expert = Appointmenter::select('id', 'department_id', 'business_id', 'appointmenter_image', 'appointmenter_name', 'slug')->where('status', 'active')->where('slug', $slug)->first();
        if ($expert) {
            return view('front.appointment.expert', compact('expert'));
        } else {
            return view('404');
        }
    }
}
