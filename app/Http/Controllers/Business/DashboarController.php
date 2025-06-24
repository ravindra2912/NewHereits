<?php

namespace App\Http\Controllers\Business;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

use App\Http\Controllers\Controller;
use App\Models\AppointmentBooking;
use App\Models\Business;
use Carbon\Carbon;

class DashboarController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function index(Request $request): View
    {
        $businessSettings = getBusinessSettings();
        $businessDetails = Business::select('id', 'credit', 'subscription_expiry_date')
            ->withCount([
                'bookings as complited_count' => function ($q) {
                    $q->where('status', 'completed');
                },
                'bookings as all_count' => function ($q) {
                    $q->where('status', '!=', 'clipboard-check');
                },
                'professionals as allProfessionals'

            ])
            ->find(Auth::user()->business_id);
        // dd($businessDetails->complited_count);
        return view('business.dashboard', compact('businessDetails', 'businessSettings'));
    }

    function monthlyBookings($date)
    {
        $startDate = Carbon::parse($date)->startOfMonth();
        $endDate = Carbon::parse($date)->endOfMonth();
        // dd($date, $startDate, $endDate);
        return Business::select('id')
            ->withCount([
                'bookings as complited_count' => function ($q) use ($startDate, $endDate) {
                    $q->where('status', 'completed')
                        ->whereBetween('booking_date', [$startDate, $endDate]);
                },
                'bookings as all_count' => function ($q) use ($startDate, $endDate) {
                    $q->where('status', '!=', 'clipboard-check')
                        ->whereBetween('booking_date', [$startDate, $endDate]);
                }

            ])
            ->find(Auth::user()->business_id);
    }

    function analytics(Request $request)
    {
        $success = false;
        $message = 'Something Wrong!';
        $data = array();

        try {
            $now = Carbon::now();
            $months = [];
            $all = [];
            $complited = [];
            for ($i = 0; $i < 12; $i++) {
                $monthName = $now->copy()->subMonths(11 - $i)->format('M Y'); // or use 'F Y' for full month
                $months[] = $monthName;
                $countData = $this->monthlyBookings($monthName);
                $all[] = $countData->all_count;
                $complited[] = $countData->complited_count;
            }
            // dd($months, $all, $complited);
            $data['appointmrntChart']['lable'] = $months;
            $data['appointmrntChart']['Complited'] = $complited;
            $data['appointmrntChart']['All'] = $all;

            $success = true;
            $message = 'Success';
        } catch (\Exception $e) {
            $message = $e->getMessage();
        }

        return response()->json(['success' => $success, 'message' => $message, 'data' => $data]);
    }
}
