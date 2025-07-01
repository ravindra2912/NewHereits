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
use App\Mail\AppointmentCancelledMail;
use App\Mail\AppointmentComplitedMail;
use App\Mail\AppointmentConfirmationMail;
use App\Mail\TokenCancelledMail;
use App\Mail\TokenComplitedMail;
use App\Mail\TokenConfirmationMail;
use Illuminate\Support\Facades\Mail;

class AppointmentBookingController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function index(Request $request)
    {
        $businessSetting = getBusinessSettings();
        if ($request->ajax()) {
            $data = AppointmentBooking::with(['department' => function ($q) {
                $q->select('id', 'department_name');
            }, 'appontmenter' => function ($q) {
                $q->select('id', 'appointmenter_name');
            }])
                ->where('appointment_bookings.business_id', getBusinessId())
                ->whereDate('booking_date', $request->date)
                ->select('appointment_bookings.id', 'appointment_bookings.business_id', 'appointment_bookings.department_id', 'token_number', 'appointmenter_id', 'user_name', 'user_contact', 'booking_date', 'slot_start_time', 'slot_end_time', 'appointment_bookings.status');
            if (isset($request->department_id) && !empty($request->department_id)) {
                $data = $data->where('department_id', $request->department_id);
            }
            if (isset($request->appointmenter_id) && !empty($request->appointmenter_id)) {
                $data = $data->where('appointmenter_id', $request->appointmenter_id);
            }
            if (isset($request->status) && !empty($request->status)) {
                $data = $data->where('status', $request->status);
            }

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('appointmenter_info', function ($row) {
                    $expinfo = $row->appontmenter->appointmenter_name;
                    if (isset($row->department) && !empty($row->department->department_name)) {
                        $expinfo .= " (" . $row->department->department_name . ")";
                    }
                    return $expinfo;
                })
                ->addColumn('user_info', function ($row) {
                    $expinfo = $row->user_name;
                    if (!empty($row->user_contact)) {
                        $expinfo .= "</br>" . $row->user_contact;
                    }
                    return $expinfo;
                })
                ->addColumn('time', function ($row) {
                    $time = !empty($row->slot_start_time) ? Carbon::parse($row->slot_start_time)->format('h:i a') : '';
                    $time .= !empty($row->slot_end_time) ? ' To ' . Carbon::parse($row->slot_end_time)->format('h:i a') : '';
                    return $time;
                })

                ->addColumn('status_info', function ($row) {
                    $statusUi = '<p class="mb-1">status : ' . ucwords(str_replace('_', ' ', $row->status)) . '</p>';
                    if ($row->status == 'pending') {
                        $statusUi .= '<button class="ststus_chenge_btn btn btn-primary btn-sm" data-id="' . $row->id . '" data-status="confirmed" >Accept</button>';
                        $statusUi .= '<button class="ststus_chenge_btn btn btn-danger btn-sm ml-1" data-id="' . $row->id . '" data-status="cancel" >Cancel</button>';
                    } else if ($row->status == 'confirmed') {
                        $statusUi .= '<button class="ststus_chenge_btn btn btn-primary btn-sm" data-id="' . $row->id . '" data-status="in_progress" >In progress</button>';
                        $statusUi .= '<button class="ststus_chenge_btn btn btn-danger btn-sm ml-1" data-id="' . $row->id . '" data-status="cancel" >Cancel</button>';
                    } else if ($row->status == 'in_progress') {
                        $statusUi .= '<button class="ststus_chenge_btn btn btn-success btn-sm" data-id="' . $row->id . '" data-status="completed">Completed</button>';
                        $statusUi .= '<button class="ststus_chenge_btn btn btn-info btn-sm ml-1" data-id="' . $row->id . '" data-status="completeAndNext">Complete & Next</button>';
                    } else if ($row->status == 'cancel') {
                        $statusUi = '<span class="badge bg-danger">Cancel</span>';
                    } else if ($row->status == 'cancel_by_user') {
                        $statusUi = '<span class="badge bg-danger">Cancel by user</span>';
                    } else if ($row->status == 'completed') {
                        $statusUi = '<span class="badge bg-success">Completed</span>';
                    }

                    return $statusUi;
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
                ->rawColumns(['action', 'img', 'time', 'appointmenter_info', 'user_info', 'status_info'])
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
        $appoinment_id = null;
        if (isset($request->appoinment_id)) {
            $appoinment_id = $request->appoinment_id;
        }
        $slots = getAppoinmenterTiming($request->appointmenter_id, $request->date, $appoinment_id);
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
                'user_contact' => 'required|numeric|digits_between:10,15',
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
            $timeSlots = getAppoinmenterTiming($appontment->appointmenter_id, $appontment->booking_date, $id);
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
                'user_contact' => 'required|numeric|digits_between:10,15',
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
                $insert->status = $request->status;
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

    public function changeStatus(Request $request)
    {
        $success = false;
        $message = 'Something Wrong!';
        $redirect = '';
        $data = array();

        try {
            $rules = [
                'appointment_id' => 'required',
                'status' => 'required',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) { // Validation fails
                $message = $validator->errors();
                // $message = $validator->errors()->first();
            } else {

                $appointment = AppointmentBooking::select('id', 'business_id', 'appointmenter_id', 'status')->where('business_id', getBusinessId())->find($request->appointment_id);
                if ($appointment) {
                    $appointment->status = $request->status == 'completeAndNext' ? 'completed' : $request->status;
                    $appointment->save();

                    if ($request->status == 'completeAndNext') {
                        $businessSetting = getBusinessSettings();
                        $nextBooking = AppointmentBooking::query()
                            ->where('booking_date', Carbon::now()->format('Y-m-d'))
                            ->where('appointmenter_id', $appointment->appointmenter_id)
                            ->where('status', 'confirmed');
                        if ($businessSetting->is_appointment_book_with_time_slote) {
                            $nextBooking = $nextBooking->orderBy('slot_start_time', 'asc');
                        } else {
                            $nextBooking = $nextBooking->orderBy('token_number', 'asc');
                        }
                        $nextBooking = $nextBooking->first();
                        if ($nextBooking) {
                            $nextBooking->status = 'in_progress';
                            $nextBooking->save();
                        }
                    }
                    $success = true;
                    $message = 'Appoinment Update successfully.';
                } else {
                    $message = 'Appoinment not found!';
                }
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
