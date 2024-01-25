<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserDashboardController extends Controller
{
    public function index()
    {
        if(Auth::user()->role == 'admin' || Auth::user()->role == 'employee'){
            return redirect()->route('staff.profile');
        }
        return view('frontend.dashboard.dashboard');
    }
}
