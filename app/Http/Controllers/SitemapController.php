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
use App\Models\Appointmenter;
use App\Models\Business;
use App\Models\City;
use App\Models\CityArea;
use App\Models\LegalPage;

class SitemapController extends Controller
{
    public function index(){
        $businesses = Business::select('id', 'slug', 'updated_at')->where('status', 'active')->get();
        $Appointmenters = Appointmenter::select('id', 'slug', 'updated_at')->where('status', 'active')->get();
        return response()->view('sitemap', compact('businesses', 'Appointmenters'))->header('Content-Type', 'application/xml');
    }
}
