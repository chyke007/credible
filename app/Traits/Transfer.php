<?php

namespace App\Traits;
use App\Transfer as TransferAmount;
use App\User;

trait Transfer
{
    
    public function deductFromWallet($user, $amount){
        if(!$user) $user = Auth::user();
        
        $validUser = User::where('id',$user->id)->first();
            if($validUser){

                $validUser ? $validUser-> wallet -= $amount : '';
                $validUser->save();
            }
    }

    public function createTransfer($id,$amount,$time,$mode,$status){
        TransferAmount::create([
            'user_id' => $id,
            'amount' => $amount,
            'transfer_time' => $time,
            'mode' => $mode,
            'status' => $status
        ]);
    }
    
}

?>