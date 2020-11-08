<?php

namespace App\Console\Commands;

use App\User;
use App\Transfer;

use Carbon\Carbon;
use Illuminate\Console\Command;

class TransferCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'transfer:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

     /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
         $transfer = Transfer::where("status","pending")->where('transfer_time', '<=', date('Y-m-d').' 00:00:00')->get();
       
        foreach($transfer as $tr){//loop through an Eloquent collection instance
            $oldUpdate = $tr->updated_at;
            $tr->update([
                "status" =>"completed"
            ]);
            $user = User::where("id",$tr->user_id)->first();
            $newWallet = (int)$user->wallet - (int) $tr->amount;
            if($newWallet < 0){
                $tr->update([
                    "status" =>"failed"
                ]);
            }else{
                $user->update([
                    "wallet"=> $newWallet 
                ]);
            }
            
        }
       
        
        /*
           Write your database logic we bellow:
           Item::create(['name'=>'hello new']);
        */
        
        $this->info('Transfer:Cron Cummand Run successfully!');
    }
}
