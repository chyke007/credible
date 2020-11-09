<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;
use App\User;

class GeneralController extends Controller
{
    
    public function loadPages()
    {
        return view('app');
    }
    
   
}
