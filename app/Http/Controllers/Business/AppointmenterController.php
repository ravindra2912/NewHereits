<?php

namespace App\Http\Controllers\Business;

use Carbon\Carbon;
use App\Models\User;
use App\Models\UserRole;
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

class AppointmenterController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function index(Request $request)
    {
        $businessSetting = getBusinessSettings();
        if ($request->ajax()) {
            $data = Appointmenter::with('department')->where('business_id', getBusinessId())->select('id', 'department_id',  'appointmenter_name', 'appointmenter_image');

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('image', function ($row) {
                    return '<img class="avtar1" src="' . getImage($row->appointmenter_image) . '">';
                })
                ->addColumn('department', function ($row) {
                    return isset($row->department) ? $row->department->department_name : '';
                })
                ->addColumn('action', function ($row) {
                    $url = route('business.appointment.appointmenter.destroy', $row->id);
                    $url = "'" . $url . "'";
                    return ' <div class="text-center">
                    <a href="' . route('business.appointment.appointmenter.edit', $row->id) . '" class="btn btn-outline-primary btn-sm" title="edit"><i class="far fa-edit"></i></a>
                    <a href="' . route('business.appointment.appointmenter.timing', $row->id) . '" class="btn btn-outline-warning btn-sm" title="timing"><i class="far fa-clock"></i></a>
                    <!-- button onclick="destroy(' . $url . ', ' . $row->id . ')" class="btn btn-outline-danger btn-sm btn_delete-' . $row->id . '" title="Delete">
                        <i id="buttonText" class="far fa-trash-alt"></i>
                        <span id="loader" class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                    </button -->
                    </div>';
                })
                ->rawColumns(['action', 'department', 'image'])
                ->make(true);
        }

        return view('business.appointment.appointmenter.index', compact('businessSetting'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $businessSetting = getBusinessSettings();
        $departments = array();
        if ($businessSetting->is_appointment_with_department) {
            $departments = AppointmentDepartment::select('id', 'department_name')->where('business_id', getBusinessId())->get();
        }
        return view('business.appointment.appointmenter.create', compact('departments', 'businessSetting'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $success = false;
        $message = 'Something Wrong!';
        $redirect = Route('business.appointment.appointmenter.index');
        $data = array();

        try {
            $businessSetting = getBusinessSettings();
            $rules = [
                'appointmenter_image' => 'required|mimes:jpg,jpeg,png|',
                'department_id' => $businessSetting->is_appointment_with_department ? 'required' : 'nullable',
                'appointmenter_name' => 'required',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) { // Validation fails
                $message = $validator->errors();
                // $message = $validator->errors()->first();
            } else {
                $insert = new Appointmenter();

                $image_name = fileUploadStorage($request->file('appointmenter_image'), 'appointmenter_image', 500, 500);
                $insert->appointmenter_image = $image_name;

                $insert->business_id  = Auth::user()->business_id;
                $insert->department_id = $request->department_id;
                $insert->appointmenter_name = $request->appointmenter_name;
                $insert->save();

                $success = true;
                $message = 'Professional Create successfully.';
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
        $appointmenter = Appointmenter::find($id);
        $businessSetting = getBusinessSettings();
        $departments = array();
        if ($businessSetting->is_appointment_with_department) {
            $departments = AppointmentDepartment::select('id', 'department_name')->where('business_id', getBusinessId())->get();
        }
        return view('business.appointment.appointmenter.edit', compact('appointmenter', 'businessSetting', 'departments'));
    }

    public function update(Request $request, $id)
    {
        $success = false;
        $message = 'Something Wrong!';
        $redirect = Route('business.appointment.appointmenter.index');
        $data = array();

        try {
            $businessSetting = getBusinessSettings();
            $rules = [
                'appointmenter_image' => 'nullable|mimes:jpg,jpeg,png|',
                'department_id' => $businessSetting->is_appointment_with_department ? 'required' : 'nullable',
                'appointmenter_name' => 'required',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) { // Validation fails
                $message = $validator->errors();
                // $message = $validator->errors()->first();
            } else {
                $update = Appointmenter::find($id);

                if ($request->hasFile('appointmenter_image')) {
                    $oldimage = $update->appointmenter_image;
                    $image_name = fileUploadStorage($request->file('appointmenter_image'), 'appointmenter_image', 500, 500);
                    $update->appointmenter_image = $image_name;
                }

                $update->business_id  = Auth::user()->business_id;
                $update->department_id = $request->department_id;
                $update->appointmenter_name = $request->appointmenter_name;
                $update->save();

                // Remove old uploaded image if exist
                if (isset($oldimage)) {
                    fileRemoveStorage($oldimage);
                }

                $success = true;
                $message = 'Professional Update successfully.';
            }
        } catch (\Exception $e) {
            $message = $e->getMessage();
            if (isset($image_name) && !empty($image_name)) {
                fileRemoveStorage($image_name);
            }
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
        $redirect = Route('business.appointment.appointmenter.index');
        $data = array();

        try {
            $checkAppointmenter = Appointmenter::where('department_id', $id)->where('business_id', getBusinessId())->get();
            if ($checkAppointmenter && count($checkAppointmenter) > 0) {
                $message = 'Please first delete professionals which are in this department.';
            } else {
                $delete = AppointmentDepartment::find($id);
                if ($delete) {
                    // fileRemoveStorage($delete->profile);
                    $delete->delete();

                    $success = true;
                    $message = 'Professional deleted successfully.';
                }
            }
        } catch (\Exception $e) {
            $message = $e->getMessage();
        }
        return response()->json(['success' => $success, 'message' => $message, 'data' => $data, 'redirect' => $redirect]);
    }

    public function timing(Request $request, $id)
    {
        $timing = [];
        foreach( config('const.week_day_name') as $day){
            $temp = array();
            $temp['day'] = $day;
            $temp['timing'] = BusinessTiming::where('day', $day)->where('appointmenter_id', $id)->where('business_id', getBusinessId())->orderBy('start_time', 'asc')->get();
            $timing[] = $temp;
        }
        $appointmenter = Appointmenter::find($id);
        return view('business.appointment.appointmenter.timing', compact('appointmenter', 'timing'));
    }

    public function timingStore(Request $request, $id)
    {
        $success = false;
        $message = 'Something Wrong!';
        $redirect = Route('business.appointment.appointmenter.timing', $id);
        $data = array();

        try {
            $rules = [
                'day' => 'required',
                'start_time' => 'required',
                'end_time' => 'required|after:start_time',
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) { // Validation fails
                $message = $validator->errors();
                // $message = $validator->errors()->first();
            } else {
                $insert = new BusinessTiming();
                $insert->business_id = getBusinessId();
                $insert->appointmenter_id = $id;
                $insert->day = $request->day;
                $insert->start_time = $request->start_time;
                $insert->end_time = $request->end_time;
                $insert->save();

                $success = true;
                $message = 'Time add successfully.';
            }
        } catch (\Exception $e) {
            $message = $e->getMessage();
        }
        return response()->json(['success' => $success, 'message' => $message, 'data' => $data, 'redirect' => $redirect]);
    }

    public function TimingDestroy(Request $request)
    {
        $success = false;
        $message = 'Something Wrong!';
        $redirect = Route('business.setting.business.timing');
        $data = array();

        try {
                $timing = BusinessTiming::find($request->id);
                if($timing){
                    $timing->delete();
                }
                $success = true;
                $message = 'Time deleted successfully.';
            
        } catch (\Exception $e) {
            $message = $e->getMessage();
        }
        return response()->json(['success' => $success, 'message' => $message, 'data' => $data, 'redirect' => $redirect]);
    }

    
}
