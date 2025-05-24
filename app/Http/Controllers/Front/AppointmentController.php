<?php

namespace App\Http\Controllers\Front;

use Carbon\Carbon;
use App\Models\Business;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Models\Appointmenter;
use App\Models\ReviewAndRating;

use App\Models\BusinessCategory;
use App\Models\AppointmentBooking;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\AppointmentDepartment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\ProfileUpdateRequest;
use App\Mail\AppointmentConfirmationMail;
use App\Mail\TokenConfirmationMail;
use Cart;
use Illuminate\Support\Facades\Mail;

class AppointmentController extends Controller
{
    public function index(Request $request, $slug): View
    {
        $expert = Appointmenter::select('id', 'department_id', 'business_id', 'appointmenter_image', 'appointmenter_name', 'slug', 'title', 'description', 'rating')
            ->with([
                'business' => function ($q) {
                    return $q->select('id', 'name', 'slug', 'address', 'latitude', 'longitude', 'business_image');
                },
                'reviews' => function ($q) {
                    $q->select('id', 'business_id', 'user_id', 'review_on_id', 'rating', 'review', 'created_at')
                        ->with([
                            'user' => function ($query) {
                                $query->select('id', 'first_name', 'last_name', 'profile');
                            }
                        ])
                        ->limit(6);
                },
                'businessSetting'
            ])
            ->where('status', 'active')
            ->where('slug', $slug)
            ->first();

        if ($expert) {
            // review and rating count
            $expert->ReviewAndRating = ReviewAndRating::select(
                DB::raw('SUM(CASE WHEN rating = "1" THEN 1 ELSE 0 END) as reviewCount1'),
                DB::raw('SUM(CASE WHEN rating = "2" THEN 1 ELSE 0 END) as reviewCount2'),
                DB::raw('SUM(CASE WHEN rating = "3" THEN 1 ELSE 0 END) as reviewCount3'),
                DB::raw('SUM(CASE WHEN rating = "4" THEN 1 ELSE 0 END) as reviewCount4'),
                DB::raw('SUM(CASE WHEN rating = "5" THEN 1 ELSE 0 END) as reviewCount5'),
                DB::raw('COUNT(rating) as totalReview'),
                // DB::raw('AVG(rating) as avgRating'),
                // DB::raw('SELECT * FROM review_and_ratings WHERE business_id = '.$business->id.' AND review_type = "business" AND user_id = '.Auth::user()->id.' as is_reviewed'),
            )
                ->where('review_on_id', $expert->id)
                ->where('review_type', 'professional')
                ->first();

            $expert->businessSetting = $expert->businessSetting->getBusinessSettingObject();
            $timeSlots = getAppoinmenterTiming($expert->id, Carbon::now(), null, $expert->business_id);

            $expert->timing = isExpertAvailable($expert->id);

            return view('front.appointment.expert', compact('expert', 'timeSlots'));
        } else {
            return view('404');
        }
    }


    public function board(Request $request, $slug): View
    {
        $expert = Appointmenter::select('id', 'department_id', 'business_id', 'appointmenter_image', 'appointmenter_name', 'slug', 'title', 'description')
            ->where('status', 'active')
            ->where('slug', $slug)
            ->first();

        if ($expert) {
            $timing = isExpertAvailable($expert->id);
            $appointmentFirst = null;
            if ($timing['data']) {
                $appointmentFirst = $timing['data'];
            }

            $appointmentList = array();
            if ($appointmentFirst) {
                $appointmentList = AppointmentBooking::whereDate('booking_date', Carbon::now())
                    ->where('appointmenter_id', $expert->id)
                    ->where('id', '!=', $appointmentFirst->id)
                    ->where('status', 'confirmed')
                    ->orderBy('token_number', 'asc')
                    ->limit(5)
                    ->get();
            }
            return view('front.appointment.board', compact('expert', 'timing', 'appointmentList', 'appointmentFirst'));
        } else {
            return view('404');
        }
    }

    public function getAppoinmenterTiming(Request $request)
    {
        $slots = getAppoinmenterTiming($request->appointmenter_id, $request->date, null, $request->business_id);
        return response()->json($slots);
    }

    public function bookAppointment(Request $request)
    {
        $success = false;
        $message = 'Something Wrong!';
        $redirect = '';
        $data = array();

        try {
            $businessSetting = getBusinessSettings($request->business_id);
            $rules = [
                'user_name' => $request->appointment_for == 'other' ? 'required' : 'nullable',
                'user_contact' => ($request->appointment_for == 'other' ? 'required' : 'nullable') . '|numeric',
                'booking_date' => 'required|date',
                'timeslote' => $businessSetting->is_appointment_book_with_time_slote ? 'required' : 'nullable',
                'expert_id' => 'required',
                'note' => 'nullable|string|max:250',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) { // Validation fails
                $message = $validator->errors();
                // $message = $validator->errors()->first();
            } else if (Auth::check() == false) {
                $message = 'pease login form book your appointment';
            } else {
                if (!$businessSetting->is_appointment_book_with_time_slote) {
                    $appointmenter = Appointmenter::select('id', 'number_of_bookings_per_day')->where('id', $request->expert_id)->first();
                    if ($appointmenter) {
                        $getAllbooking = AppointmentBooking::select('id', 'token_number')
                            ->where('appointmenter_id', $request->expert_id)
                            ->whereDate('booking_date', Carbon::parse($request->booking_date))
                            ->where('status', 'pending')
                            ->where('business_id', $request->business_id)
                            ->get()
                            ->count();
                        if ($appointmenter->number_of_bookings_per_day > 0 && $getAllbooking >= $appointmenter->number_of_bookings_per_day) {
                            $message = 'Sorry! This expert has already booked the maximum number of booking for this date.';
                            return response()->json(['success' => $success, 'message' => $message, 'data' => $data, 'redirect' => $redirect]);
                        }
                    }
                }


                $getLastToken = AppointmentBooking::where('appointmenter_id', $request->expert_id)->whereDate('booking_date', Carbon::parse($request->booking_date))->orderBy('token_number', 'desc')->where('business_id', $request->business_id)->first();
                if ($getLastToken) {
                    $tokenNumber = $getLastToken->token_number + 1;
                } else {
                    $tokenNumber = 1;
                }
                $insert = new AppointmentBooking();
                $insert->business_id  = $request->business_id;
                $insert->user_id = Auth::user() ? Auth::user()->id : null;
                $insert->token_number  = $tokenNumber;
                $insert->department_id = $request->department_id;
                $insert->appointmenter_id = $request->expert_id;
                if ($request->appointment_for == 'self') {
                    $insert->user_name = Auth::user()->first_name . ' ' . Auth::user()->last_name;
                    $insert->user_contact = Auth::user()->contact;
                } else {
                    $insert->user_name = $request->user_name;
                    $insert->user_contact = $request->user_contact;
                }
                $insert->appointment_for = $request->appointment_for;
                $insert->booking_date = $request->booking_date;
                $insert->note = $request->note;

                if ($businessSetting->is_appointment_book_with_time_slote) {
                    $timeslote = explode(' - ', $request->timeslote);
                    $insert->slot_start_time = Carbon::parse($request->booking_date . ' ' . $timeslote[0]);
                    $insert->slot_end_time = Carbon::parse($request->booking_date . ' ' . $timeslote[1]);
                }
                $insert->status =  $businessSetting->is_need_booking_confirmetion ? 'pending' : 'confirmed';
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
