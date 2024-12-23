<?php

namespace App\Http\Controllers;

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

class CommonController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function getCities(Request $request)
    {
        $citeis = getCities($request->state_id);
        return response()->json($citeis);
    }
}
