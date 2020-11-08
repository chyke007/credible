<?php

namespace App\Http\Controllers;

use App\Transfer;
use App\User;
use Illuminate\Http\Request;
use App\Http\Requests\TransferRequest;
use App\Traits\FormatResult;
use App\Traits\Transfer as TransferAmount;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Validator;
use Carbon\Carbon;

class TransferController extends Controller
{

    
    const LIMIT = 50000;
    const PENDING = 'pending';
    const COMPLETED  = 'completed';
    const INSTANT = 'instant';
    const FUTURE = 'future'; 
    
    use TransferAmount;
    use formatResult;
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        if($user->role_id == 1){
            $transfer = Transfer::latest()->get();
            return response()->json($this->FormatResult([
                'status' => true,
                'transfer'=> $transfer
            ]), Response::HTTP_OK);
        }else{
            $transfer = Transfer::where('user_id',$user->id)->latest()->get();
            return response()->json($this->FormatResult([
                'status' => true,
                'transfer'=> $transfer,
                
            ]), Response::HTTP_OK);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TransferRequest $request)
    {
            if($request->user()->role_id == 1){
                return response()->json($this->FormatResult([
                    'message' => 'you are not permitted to access this route',
                    'code' => 413
                ],true), Response::HTTP_FORBIDDEN);
            }
    
        
        $user = Auth::user();
        $currentAmount = $user->transfer->sum('amount');
        $projectedAmount = (int)$currentAmount + (int) $request->amount;
        if(($projectedAmount > self::LIMIT ) && $user->valid == 0){
            
            // Failed KYC levels
            return response()->json($this->FormatResult([
                'message' => 'Please upload a valid id to complete your verification',
                'code' => 711
            ],true), Response::HTTP_UNPROCESSABLE_ENTITY);
        }else{
            if((int)$request->amount > (int)$user-> wallet){
                //error amount too large
                return response()->json($this->FormatResult([
                    'message' => 'Amount exceeds your wallet balance',
                    'code' => 720
                ],true), Response::HTTP_UNPROCESSABLE_ENTITY);
            }
            if($request->mode == self::INSTANT){
                $this->createTransfer($user->id,$request->amount,Carbon::now(),self::INSTANT,self::COMPLETED);
                $this->deductFromWallet($user,$request->amount);
                $newUserData = User::where('id',$user->id)->first();
                return response()->json($this->FormatResult(['success' => true, 'message' => 'Transfer was successful', 'user'=> $newUserData]), Response::HTTP_OK);

            }else{
                $this->createTransfer($user->id,$request->amount,$request->transfer_time,self::FUTURE,self::PENDING);
                return response()->json($this->FormatResult(['success' => true, 'message' => 'Transfer has been logged']), Response::HTTP_OK);

            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Transfer  $transfer
     * @return \Illuminate\Http\Response
     */
    public function show(Transfer $transfer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Transfer  $transfer
     * @return \Illuminate\Http\Response
     */
    public function edit(Transfer $transfer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Transfer  $transfer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Transfer $transfer)
    {
        //crom job finds transfers and update status and then deducts from wallet
        // $this->deductFromWallet($user,amount);
                
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Transfer  $transfer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transfer $transfer)
    {
        //
    }
}
