<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Business;
use App\Models\UserRole;
use App\Models\LegalPage;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Models\BusinessSetting;
use App\Models\BusinessCategory;

use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\ProfileUpdateRequest;

class BusinessController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $data = Business::with(['owner', 'businessCategory'])
                ->select('id', 'owner_id', 'business_category_id', 'name', 'business_image', 'address', 'contact');

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('owner', function ($row) {
                    return isset($row->owner) && !empty($row->owner->first_name) ? $row->owner->first_name : '';
                })
                ->addColumn('category', function ($row) {
                    return isset($row->businessCategory) && !empty($row->businessCategory->name) ? $row->businessCategory->name : '';
                    return $row->businessCategory->name;
                })
                ->addColumn('img', function ($row) {

                    return '<div class="text-center"><img src="' . getImage($row->business_image) . '" class="table_img" /></div>';
                })
                ->addColumn('action', function ($row) {
                    $url = route('admin.business.destroy', $row->id);
                    $url = "'" . $url . "'";
                    return ' <div class="text-center">
                    <a href="' . route('admin.business.edit', $row->id) . '" class="btn btn-outline-primary btn-sm" title="edit"><i class="far fa-edit"></i></a>
                    <button onclick="destroy(' . $url . ', ' . $row->id . ')" class="btn btn-outline-danger btn-sm btn_delete-' . $row->id . '" title="Delete">
                        <i id="buttonText" class="far fa-trash-alt"></i>
                        <span id="loader" class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                    </button>
                    </div>';
                })
                ->rawColumns(['action', 'owner', 'img'])
                ->make(true);
        }
        return view('admin.business.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $businessCat = BusinessCategory::get();
        return view('admin.business.create', compact('businessCat'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $success = false;
        $message = 'Something Wrong!';
        $redirect = Route('admin.business.index');
        $data = array();

        try {
            $rules = [
                'business_image' => 'required|mimes:jpg,jpeg,png|',
                'owner_id' => 'nullable|numeric|exists:users,id',
                'name' => 'required',
                'business_category_id' => 'required',
                'business_type' => 'required',
                'address' => 'required',
                'contact' => 'required|numeric|unique:businesses,contact',
                'state_id' => 'required|exists:states,id',
                'city_id' => 'required|exists:cities,id',
                'status' => 'required',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) { // Validation fails
                $message = $validator->errors();
                // $message = $validator->errors()->first();
            } else {
                $insert = new Business();

                $image_name = fileUploadStorage($request->file('business_image'), 'business_images', 500, 500);
                $insert->business_image = $image_name;

                $insert->owner_id = $request->owner_id;
                $insert->name = $request->name;
                $insert->slug = generateUniqueSlug(Business::class, $request->name);
                $insert->business_category_id = $request->business_category_id;
                $insert->business_type = $request->business_type;
                $insert->address = $request->address;
                $insert->contact = $request->contact;
                $insert->state_id = $request->state_id;
                $insert->city_id = $request->city_id;
                $insert->status = $request->status;
                $insert->save();

                $success = true;
                $message = 'Business add successfully.';
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
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    public function edit(Request $request, $id)
    {
        $business = Business::find($id);
        $businessCat = BusinessCategory::get();
        $setting = getBusinessSettings($id);
        return view('admin.business.edit', compact('business', 'businessCat', 'setting'));
    }

    public function update(Request $request, $id)
    {
        $success = false;
        $message = 'Something Wrong!';
        $redirect = Route('admin.business.index');
        $data = array();

        try {
            $rules = [
                'business_image' => 'nullable|mimes:jpg,jpeg,png|',
                'owner_id' => 'nullable|numeric|exists:users,id',
                'name' => 'required',
                'business_category_id' => 'required',
                'business_type' => 'required',
                'address' => 'required',
                'contact' => 'required|numeric|unique:businesses,contact,' . $id,
                'state_id' => 'required|exists:states,id',
                'city_id' => 'required|exists:cities,id',
                'status' => 'required',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) { // Validation fails
                $message = $validator->errors();
                // $message = $validator->errors()->first();
            } else {

                $update = Business::find($id);

                if ($request->hasFile('business_image')) {
                    $oldimage = $update->profile;
                    $image_name = fileUploadStorage($request->file('business_image'), 'business_images', 500, 500);
                    $update->business_image = $image_name;
                }

                $update->name = $request->name;
                $update->business_category_id = $request->business_category_id;
                $update->business_type = $request->business_type;
                $update->address = $request->address;
                $update->contact = $request->contact;
                $update->state_id = $request->state_id;
                $update->city_id = $request->city_id;
                $update->status = $request->status;
                $update->save();

                // Remove old uploaded image if exist
                if (isset($oldimage)) {
                    fileRemoveStorage($oldimage);
                }

                $success = true;
                $message = 'Business update successfully.';
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
        $redirect = route('admin.business.index');
        $data = array();

        try {
            $delete = Business::find($id);
            if ($delete) {
                fileRemoveStorage($delete->business_image);
                $delete->delete();

                $success = true;
                $message = 'Business deleted successfully.';
            }
        } catch (\Exception $e) {
            $message = $e->getMessage();
        }
        return response()->json(['success' => $success, 'message' => $message, 'data' => $data, 'redirect' => $redirect]);
    }

    public function systemSettingUpdate(Request $request, $id)
    {
        $success = false;
        $message = 'Something Wrong!';
        $redirect = Route('business.setting.systemsetting');
        $data = array();

        try {
            $rules = [
                // 'business_image' => 'nullable|mimes:jpg,jpeg,png|',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) { // Validation fails
                $message = $validator->errors();
                // $message = $validator->errors()->first();
            } else {

                $update = BusinessSetting::where('business_id',$id)->first();
                if(!$update){
                    $update = new BusinessSetting();
                    $update->business_id = $id;
                }
                $update->is_appointment_system = isset($request->is_appointment_system) && $request->is_appointment_system == 'on'?1:0;
                $update->is_appointment_with_department = isset($request->is_appointment_with_department) && $request->is_appointment_with_department == 'on'?1:0;
                $update->is_appointment_book_with_time_slote = isset($request->is_appointment_book_with_time_slote) && $request->is_appointment_book_with_time_slote == 'on'?1:0;
                $update->save();

                $success = true;
                $message = 'Setting update successfully.';
            }
        } catch (\Exception $e) {
            $message = $e->getMessage();
        }
        return response()->json(['success' => $success, 'message' => $message, 'data' => $data, 'redirect' => $redirect]);
    }

}
