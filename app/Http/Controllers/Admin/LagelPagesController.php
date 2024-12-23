<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;

use App\Http\Controllers\Controller;
use App\Models\LegalPage;

class LagelPagesController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $data = LegalPage::query();

            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        return '<a href="'.route('admin.lagel-pages.edit', $row->id).'" class="btn btn-outline-primary btn-sm" title="edit"><i class="far fa-edit"></i></a>';
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        return view('admin.lagel_page.index');
    }

    public function edit(Request $request, $id)
    {
        $legalData = LegalPage::find($id);
        return view('admin.lagel_page.edit', compact('legalData'));
    }
    
    public function update(Request $request, $id)
    {
        $success = false;
        $message = 'Something Wrong!';
        $redirect = '';
        $data = array();

        try {
            $rules = [
                'type' => 'required',
                'description' => 'required'
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) { // Validation fails
                $message = $validator->errors();
                // $message = $validator->errors()->first();
            } else {

                $update = LegalPage::find($id);
                $update->page_type = $request->type;
                $update->description = $request->description;
                $update->save();
                $success = true;
                $message = 'Page updated successfully.';
            }
        } catch (\Exception $e) {
            $message = $e->getMessage();
        }
        return response()->json(['success' => $success, 'message' => $message, 'data' => $data, 'redirect' => $redirect]);
        
    }

    
}
