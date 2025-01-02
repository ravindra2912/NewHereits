<?php

namespace App\Http\Controllers\Front;

use Carbon\Carbon;
use App\Models\Business;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Models\Appointmenter;
use App\Models\BusinessCategory;

use App\Models\AppointmentBooking;
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
        $expert = Appointmenter::select('id', 'department_id', 'business_id', 'appointmenter_image', 'appointmenter_name', 'slug')
            ->with('businessSetting')
            ->where('status', 'active')
            ->where('slug', $slug)
            ->first();

        if ($expert) {
            $expert->businessSetting = $expert->businessSetting->getBusinessSettingObject();
            $timeSlots = getAppoinmenterTiming($expert->id, Carbon::now()->subDays(3), null, $expert->business_id);
            return view('front.appointment.expert', compact('expert', 'timeSlots'));
        } else {
            return view('404');
        }
    }

    public function bookAppointment(Request $request)
    {
        $success = false;
        $message = 'Something Wrong!';
        $redirect = Route('business.appointment.bookings.index');
        $data = array();

        try {
            $businessSetting = getBusinessSettings($request->business_id);
            $rules = [
                'user_name' => 'required',
                'user_contact' => 'required|numeric',
                'booking_date' => 'required|date',
                'timeslote' => $businessSetting->is_appointment_book_with_time_slote ? 'required' : 'nullable',
                'expert_id' => 'required',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) { // Validation fails
                $message = $validator->errors();
                // $message = $validator->errors()->first();
            } else {

                $getLastToken = AppointmentBooking::where('appointmenter_id', $request->expert_id)->whereDate('booking_date', Carbon::parse($request->booking_date))->orderBy('token_number', 'desc')->where('business_id', $request->business_id)->first();
                if ($getLastToken) {
                    $tokenNumber = $getLastToken->token_number + 1;
                } else {
                    $tokenNumber = 1;
                }
                $insert = new AppointmentBooking();
                $insert->business_id  = Auth::user()->business_id;
                $insert->token_number  = $tokenNumber;
                $insert->department_id = $request->department_id;
                $insert->appointmenter_id = $request->expert_id;
                $insert->user_name = $request->user_name;
                $insert->user_contact = $request->user_contact;
                $insert->booking_date = $request->booking_date;

                if ($businessSetting->is_appointment_book_with_time_slote) {
                    $timeslote = explode(' - ', $request->timeslote);
                    $insert->slot_start_time = Carbon::parse($request->booking_date . ' ' . $timeslote[0]);
                    $insert->slot_end_time = Carbon::parse($request->booking_date . ' ' . $timeslote[1]);
                }

                $insert->save();

                $success = true;
                $message = 'Appointment Book Successfully.';
            }
        } catch (\Exception $e) {
            $message = $e->getMessage();
        }
        return response()->json(['success' => $success, 'message' => $message, 'data' => $data, 'redirect' => $redirect]);
    }
}
