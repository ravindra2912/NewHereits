<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Business;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\ProfileUpdateRequest;

class DashboarController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function index(Request $request): View
    {
        $usersByRole = User::select('role_id', DB::raw('count(*) as total'))
            ->whereIn('role_id', [2, 3])
            ->groupBy('role_id')
            ->pluck('total', 'role_id');

        $userCount = $usersByRole[3] ?? 0;
        $sellerCount = $usersByRole[2] ?? 0;

        $businessByStatus = Business::select('status', DB::raw('count(*) as total'))
            ->whereIn('status', ['active', 'pending'])
            ->groupBy('status')
            ->pluck('total', 'status');

        $activeBusinessCount = $businessByStatus['active'] ?? 0;
        $pendingBusinessCount = $businessByStatus['pending'] ?? 0;
        return view('admin.dashboard', compact('userCount', 'sellerCount', 'activeBusinessCount', 'pendingBusinessCount'));
    }
}
