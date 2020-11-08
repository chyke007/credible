<?php

namespace App\Traits;
use App\Transfer as TransferAmount;
use App\User;

trait Transfer
{
    
    public function deductFromWallet($id, $amount){
        if(!$id) $id = Auth::user()->id;
        
        $validUser = User::where('id',$id)->first();
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