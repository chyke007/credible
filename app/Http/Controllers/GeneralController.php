<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ComplaintRequest;
use App\Http\Requests\ContactUsRequest;
use App\Http\Requests\PasswordResetRequest;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\SalaryRequest;
use App\Http\Requests\FinRequest;
use App\Http\Requests\InfoRequest;
use App\Http\Requests\PayslipRequest;

use Carbon\Carbon;
use App\Jobs\SendEmail;
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
