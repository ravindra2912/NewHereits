<?php

namespace App\Http\Controllers\Admin;

use App\Models\Faq;
use Illuminate\Http\Request;
use App\Models\BusinessCategory;

use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\CityArea;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;

class LocationMasterController extends Controller
{
    public function getAreas(Request $request)
    {
        if ($request->ajax()) {
            $data = CityArea::with(['city:id,name']);
            return Datatables::of($data)
                ->addIndexColumn()
                // ->addColumn('city', function ($row) {

                //     return $row->city ? $row->city->name : '';
                // })
                ->addColumn('action', function ($row) {
                    $url = route('admin.businesscategory.destroy', $row->id);
                    $url = "'" . $url . "'";
                    return ' <div class="text-center">
                    <a href="' . route('admin.locations.areas.edit', $row->id) . '" class="btn btn-outline-primary btn-sm" title="edit"><i class="far fa-edit"></i></a>
                    </div>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('admin.locations.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function createArea()
    {
        $cities = City::select('id', 'name')->get();
        return view('admin.locations.create', compact('cities'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function storeArea(Request $request)
    {
        $success = false;
        $message = 'Something Wrong!';
        $redirect = Route('admin.locations.areas');
        $data = array();

        try {
            $rules = [
                'city_id' => 'required',
                'area_name' => 'required|unique:city_areas,area_name',
                'pincode' => 'required|numeric|digits:6',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) { // Validation fails
                $message = $validator->errors();
                // $message = $validator->errors()->first();
            } else {

                $insert = new CityArea();
                $insert->city_id = $request->city_id;
                $insert->area_name = $request->area_name;
                $insert->pincode = $request->pincode;
                $insert->status = $request->status;
                $insert->save();

                $success = true;
                $message = 'Area add successfully.';
            }
        } catch (\Exception $e) {
            $message = $e->getMessage();
        }
        return response()->json(['success' => $success, 'message' => $message, 'data' => $data, 'redirect' => $redirect]);
    }

    public function editArea(Request $request, $id)
    {
        $cities = City::select('id', 'name')->get();
        $area = CityArea::find($id);
        return view('admin.locations.edit', compact('cities', 'area'));
    }

    public function updateArea(Request $request, $id)
    {
        $success = false;
        $message = 'Something Wrong!';
        $redirect = Route('admin.locations.areas');
        $data = array();

        try {
            $rules = [
                'city_id' => 'required',
                'area_name' => 'required|unique:city_areas,area_name,'.$id,
                'pincode' => 'required|numeric|digits:6',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) { // Validation fails
                $message = $validator->errors();
            } else {

                $update = CityArea::find($id);
                $update->city_id = $request->city_id;
                $update->area_name = $request->area_name;
                $update->pincode = $request->pincode;
                $update->status = $request->status;
                $update->save();

                $success = true;
                $message = 'Area updated successfully.';
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
        $redirect = route('admin.businesscategory.index');
        $data = array();

        try {
            $delete = BusinessCategory::find($id);
            if ($delete) {
                fileRemoveStorage($delete->image);
                $delete->delete();
                $success = true;
                $message = 'Business category deleted successfully.';
            }
        } catch (\Exception $e) {
            $message = $e->getMessage();
        }
        return response()->json(['success' => $success, 'message' => $message, 'data' => $data, 'redirect' => $redirect]);
    }
}
