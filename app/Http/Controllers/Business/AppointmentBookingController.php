<?php

namespace App\Http\Controllers\Business;

use Carbon\Carbon;
use App\Models\User;
use App\Models\UserRole;
use Carbon\CarbonPeriod;
use App\Models\LegalPage;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Models\Appointmenter;

use App\Models\BusinessTiming;
use Yajra\DataTables\DataTables;
use App\Models\AppointmentBooking;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\AppointmentDepartment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\ProfileUpdateRequest;

class AppointmentBookingController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function index(Request $request)
    {
        $businessSetting = getBusinessSettings();
        if ($request->ajax()) {
            $data = AppointmentBooking::with(['department', 'appontmenter'])
                ->where('business_id', getBusinessId())
                ->whereDate('booking_date', $request->date)->select('*');
            if (isset($request->department_id) && !empty($request->department_id)) {
                $data = $data->where('department_id', $request->department_id);
            }
            if (isset($request->appointmenter_id) && !empty($request->appointmenter_id)) {
                $data = $data->where('appointmenter_id', $request->appointmenter_id);
            }

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('department', function ($row) {
                    return isset($row->department) ? $row->department->department_name : '';
                })
                ->addColumn('start_time', function ($row) {
                    return !empty($row->slot_start_time)?Carbon::parse($row->slot_start_time)->format('H:i a'):'';
                })
                ->addColumn('end_time', function ($row) {
                    return !empty($row->slot_end_time)?Carbon::parse($row->slot_end_time)->format('H:i a'):'';
                })
                ->addColumn('action', function ($row) {
                    $url = route('business.appointment.bookings.destroy', $row->id);
                    $url = "'" . $url . "'";
                    return ' <div class="text-center">
                    <a href="' . route('business.appointment.bookings.edit', $row->id) . '" class="btn btn-outline-primary btn-sm" title="edit"><i class="far fa-edit"></i></a>
                    <!-- button onclick="destroy(' . $url . ', ' . $row->id . ')" class="btn btn-outline-danger btn-sm btn_delete-' . $row->id . '" title="Delete">
                        <i id="buttonText" class="far fa-trash-alt"></i>
                        <span id="loader" class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                    </button -->
                    </div>';
                })
                ->rawColumns(['action', 'img', 'start_time', 'end_time'])
                ->make(true);
        }

        $departments = array();
        $appontmenters = array();
        if ($businessSetting->is_appointment_with_department) {
            $departments = AppointmentDepartment::select('id', 'department_name')->where('business_id', getBusinessId())->get();
        } else {
            $appontmenters = Appointmenter::select('id', 'appointmenter_name')->where('business_id', getBusinessId())->get();
        }

        return view('business.appointment.booking.index', compact('businessSetting', 'departments', 'appontmenters'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $businessSetting = getBusinessSettings();
        $departments = array();
        $appontmenters = array();
        if ($businessSetting->is_appointment_with_department) {
            $departments = AppointmentDepartment::select('id', 'department_name')->where('business_id', getBusinessId())->get();
        } else {
            $appontmenters = Appointmenter::select('id', 'appointmenter_name')->where('business_id', getBusinessId())->get();
        }

        return view('business.appointment.booking.create', compact('departments', 'appontmenters', 'businessSetting'));
    }

    public function getAppoinmenterTiming(Request $request)
    {
        $slots = getAppoinmenterTiming($request->appointmenter_id, $request->date);
        return response()->json($slots);
    }

    public function getAppoinmenterByDepartment(Request $request)
    {
        $Appointmenter = Appointmenter::where('department_id', $request->department_id)->where('business_id', getBusinessId())->get();
        return response()->json($Appointmenter);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $success = false;
        $message = 'Something Wrong!';
        $redirect = Route('business.appointment.bookings.index');
        $data = array();

        try {
            $businessSetting = getBusinessSettings();
            $rules = [
                'user_name' => 'required',
                'user_contact' => 'required|numeric',
                'booking_date' => 'required|date',
                'department_id' => $businessSetting->is_appointment_with_department ? 'required' : 'nullable',
                'timeslote' => $businessSetting->is_appointment_book_with_time_slote ? 'required' : 'nullable',
                'appointmenter_id' => 'required',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) { // Validation fails
                $message = $validator->errors();
                // $message = $validator->errors()->first();
            } else {

                $getLastToken = AppointmentBooking::where('appointmenter_id', $request->appointmenter_id)->whereDate('booking_date', Carbon::parse($request->booking_date))->orderBy('token_number', 'desc')->where('business_id', getBusinessId())->first();
                if ($getLastToken) {
                    $tokenNumber = $getLastToken->token_number + 1;
                } else {
                    $tokenNumber = 1;
                }
                $insert = new AppointmentBooking();
                $insert->business_id  = Auth::user()->business_id;
                $insert->token_number  = $tokenNumber;
                $insert->department_id = $request->department_id;
                $insert->appointmenter_id = $request->appointmenter_id;
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
                $message = 'Appoinment Create successfully.';
            }
        } catch (\Exception $e) {
            $message = $e->getMessage();
        }
        return response()->json(['success' => $success, 'message' => $message, 'data' => $data, 'redirect' => $redirect]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    public function edit(Request $request, $id)
    {
        $appontment = AppointmentBooking::find($id);
        $appontment->bookdate = Carbon::parse($appontment->slot_start_time)->format('h:i a') . ' - ' . Carbon::parse($appontment->slot_end_time)->format('h:i a');
        $businessSetting = getBusinessSettings();
        $appontmenters = Appointmenter::select('id', 'appointmenter_name')->where('business_id', getBusinessId());
        $departments = array();
        $timeSlots = array();
        if ($businessSetting->is_appointment_with_department) {
            $departments = AppointmentDepartment::select('id', 'department_name')->where('business_id', getBusinessId())->get();
            $appontmenters = $appontmenters->where('department_id', $appontment->department_id);
        }

        if ($businessSetting->is_appointment_book_with_time_slote) {
            $timeSlots = getAppoinmenterTiming($appontment->appointmenter_id, $appontment->booking_date);
        }

        $appontmenters = $appontmenters->get();
        return view('business.appointment.booking.edit', compact('departments', 'appontmenters', 'businessSetting', 'appontment', 'timeSlots'));
    }

    public function update(Request $request, $id)
    {
        $success = false;
        $message = 'Something Wrong!';
        $redirect = Route('business.appointment.bookings.index');
        $data = array();

        try {
            $businessSetting = getBusinessSettings();
            $rules = [
                'user_name' => 'required',
                'user_contact' => 'required|numeric',
                'booking_date' => 'required|date',
                'department_id' => $businessSetting->is_appointment_with_department ? 'required' : 'nullable',
                'timeslote' => $businessSetting->is_appointment_book_with_time_slote ? 'required' : 'nullable',
                'appointmenter_id' => 'required',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) { // Validation fails
                $message = $validator->errors();
                // $message = $validator->errors()->first();
            } else {
                $insert = AppointmentBooking::find($id);
                $insert->department_id = $request->department_id;
                $insert->appointmenter_id = $request->appointmenter_id;
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
                $message = 'Appoinment Update successfully.';
            }
        } catch (\Exception $e) {
            $message = $e->getMessage();
        }
        return response()->json(['success' => $success, 'message' => $message, 'data' => $data, 'redirect' => $redirect]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $success = false;
        $message = 'Something Wrong!';
        $redirect = route('admin.user.index');
        $data = array();

        try {
            $delete = User::find($id);
            if ($delete) {
                fileRemoveStorage($delete->profile);
                $delete->delete();

                $success = true;
                $message = 'User deleted successfully.';
            }
        } catch (\Exception $e) {
            $message = $e->getMessage();
        }
        return response()->json(['success' => $success, 'message' => $message, 'data' => $data, 'redirect' => $redirect]);
    }
}
