<?php

namespace App\Http\Controllers\Business;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use App\Models\User;

class AppointmentUsersController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function index(Request $request)
    {
        $businessSetting = getBusinessSettings();
        if ($request->ajax()) {
            $data = User::withCount([
                'appointments as completed_appointments' => function ($query) {
                    $query->where('business_id', getBusinessId())
                        ->where('status', 'completed');
                },
                'appointments as uncompleted_appointments' => function ($query) {
                    $query->where('business_id', getBusinessId())
                        ->whereNotIn('status', ['completed', 'auto_cancelled', 'cancel']);
                }
            ])
                ->whereHas('appointments', function ($query) {
                    $query->where('business_id', getBusinessId())
                        ->whereNotNull('user_id')
                        ->groupBy('user_id');
                });

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('img', function ($row) {

                    return '<div class="text-center"><img src="' . getImage($row->profile) . '" class="table_img" /></div>';
                })
                ->addColumn('convertRate', function ($row) {

                    return round(($row->completed_appointments / $row->uncompleted_appointments) * 100, 2) . '%';
                })
                ->addColumn('action', function ($row) {
                    return ' <div class="text-center">
                    <div onclick="getUserDetails(' . $row->id . ')" class="btn btn-outline-primary btn-sm" title="View"><i class="far fa-eye"></i></div>
                    
                    </div>';
                })
                ->rawColumns(['img', 'convertRate', 'action'])
                ->make(true);
        }

        return view('business.appointment.user.index', compact('businessSetting'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {}

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    public function edit(Request $request, $id) {}

    public function update(Request $request, $id) {}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id) {}
}
