<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
// use Session;
class DashboardController extends Controller
{
    public function dashboard()
    {
    	// return 'welcome home '.Auth::user()->role;
    	return response()->json([
    		'user' => Auth::user(),
    		'last_ip' => session('last_ip'),
    		'last_login' => session('last_login')
    	], 200);
    }
}
