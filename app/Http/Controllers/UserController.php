<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Traits\FormatResult;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\UserResource;
use Symfony\Component\HttpFoundation\Response;
use Validator;

class UserController extends Controller
{
    use FormatResult;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->user()->role_id != 1){
            return response()->json($this->FormatResult([
                'message' => 'you are not permitted to access this route',
                'code' => 413
            ],true), Response::HTTP_FORBIDDEN);
        }
        $user = User::where('identity', '<>', '')->latest()->get();
        
        return response()->json($this->FormatResult([
        	'success' => true,
            'user' => $user
        ]),Response::HTTP_OK);
    }

   

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = $request->user();
        if ($request->hasfile('identity')) {
            Storage::disk('public')->delete($user->identity);
            $path = $request->file('identity')->store('identity', 'public');
        }else{
            $path = $user->identity;
        }
        

        if($user->role_id == 2){
            
            $validate = Validator::make($request->all(),[
                'first_name' => ['required', 'string', 'max:50'],
                'last_name' => ['required', 'string', 'max:50'],
                'accountName' => ['required', 'string', 'max:50'],
                'accountNumber' => ['required', 'string', 'max:50'],
                'bank' => ['required', 'string', 'max:50']
                
            ]);
            if($validate->fails()){
                $response = array('response' => $validate->messages(), 'success' => false);
                return response($response, Response::HTTP_INTERNAL_SERVER_ERROR);
            }
            $user->update([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'accountName' => $request->accountName,
                'accountNumber' => $request->accountNumber,
                'bank' => $request->bank,
                'identity' => $path
                
            ]);
            
        }else{
            return response()->json($this->FormatResult([
                'message' => 'you are not permitted to access this route',
                'code' => 413
            ],true), Response::HTTP_FORBIDDEN);
            
        }
        return response()->json($this->FormatResult([
        	'success' => true,
            'message' => 'User successfully Updated',
            'user' => $request->user()
        ]),Response::HTTP_OK);
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        if($request->user()->role_id != 1){
            return response()->json($this->FormatResult([
                'message' => 'you are not permitted to access this route',
                'code' => 413
            ],true), Response::HTTP_FORBIDDEN);
        }
        $user ->update([
            'valid' => !$user->valid
            
        ]);
        return response()->json($this->FormatResult([
        	'success' => true,
            'message' => 'User successfully Updated',
            'user' => $request->user()
        ]),Response::HTTP_OK);
       }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        if($user->id == 1 ){
            return response([
                "error" => "Superadmin cannot be deleted"
            ],Response::HTTP_FORBIDDEN);
        }
        Storage::disk('public')->delete($user->image);
        $user->delete();
        return response([
            "success" => "User successfully deleted"
        ],Response::HTTP_NO_CONTENT);
    }


    public function makeAdmin(Request $request)
    {
        $user = User::findorfail($request->input('id'));
        $user->update([
            "admin_right" =>true
        ]);
        return response([
            "success" => true,
            "message" => 'Admin right added'
        ],Response::HTTP_OK);
    }

    public function revokeAdmin(Request $request)
    {
        $user = User::findorfail($request->input('id'));
        $user->update([
            "admin_right" =>false
        ]);
        return response([
            "success" => true,
            "message" => 'Admin right revoked'
        ],Response::HTTP_OK);
    }
}
