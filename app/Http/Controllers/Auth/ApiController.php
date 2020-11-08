<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UserStoreRequest;
use App\Http\Resources\UserResource;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

use App\Traits\FormatResult;
use Validator;
use Symfony\Component\HttpFoundation\Response;

class ApiController extends Controller
{
    use FormatResult;
    
    /**
     * Handles Registration Request
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(UserStoreRequest $request)
    {
       

 		$user =  User::create([
            'role_id' => 2,
            'first_name' => $request['first_name'],
            'last_name' => $request['last_name'],
            'email' => $request['email'],
            'password' => bcrypt($request['password']),
            'referral_code'=> Str::random(6)

        ]);
        if($request->referral){
            $referral = User::where('referral_code',$request['referral'])->first();
            if($referral){

                $referral ? $referral-> wallet +=1000 : '';
                $referral->save();
            }
        }
        $user->save();
        
        return response()->json($this->FormatResult(['success' => true, 'message' => 'Account successfully created']), Response::HTTP_OK);
    }
 
    /**
     * Handles Login Request
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        
        $validate = Validator::make($request->all(),[
			'password' => ['required', 'string', 'max:50'],
            'email' => ['required', 'email']
        ]);
        if($validate->fails()){
			$response = array('response' => $validate->messages(), 'success' => false);
            return response($response, Response::HTTP_INTERNAL_SERVER_ERROR);
		}
        $credentials = request(['email', 'password']);
        $userEmail = User::where('email',$request['email'])->get();
        
        if(count($userEmail) < 1){
            return response()->json($this->FormatResult([
                'message' => 'account not found',
                'code' => 610
            ],true), Response::HTTP_UNAUTHORIZED);
        }else if(!Auth::attempt($credentials)){
           
            return response()->json($this->FormatResult([
                'message' => 'invalid credentials',
                'code' => 611
            ],true), Response::HTTP_UNAUTHORIZED);
        }
        $user = $request->user();
        
       $user->update([
            'last_login' => Carbon::now()
        ]);
        $tokenResult = $user->createToken('UserSignPassword');
        $token = $tokenResult->token;
        if ($request->remember_me){
            $token->expires_at = Carbon::now()->addDay(30);
        }else{

            $token->expires_at = Carbon::now()->addDay(2);
        }

        $token->save();
        return response()->json($this->FormatResult([
        	'success' => true,
            'token' => $tokenResult->accessToken,
            'user' => $request->user()
        ]),Response::HTTP_OK);
    }
        
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json([
            'message' => 'Successfully logged out'
        ],Response::HTTP_OK);
    }
}
