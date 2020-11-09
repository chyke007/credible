<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'role_id' => 2,
            'first_name' => 'CredPal',
            'last_name' => 'User',
            'email' => 'user@credpal.com',
            'password' => bcrypt('credpal'),
            'referral_code' => Str::random(6),
            'wallet' => 40000,
            'identity' => '',
            'accountNumber' => '30484993043',
            'accountName'=>'CredPal limited',
            'valid' => 0
        ]); 
        DB::table('users')->insert([
            'role_id' => 1,
            'first_name' => 'CredPal',
            'last_name' => 'Admin',
            'email' => 'admin@credpal.com',
            'password' => bcrypt('credpal'),
            'referral_code' => Str::random(6),
            'wallet' => 0,
            'identity' => '',
            'accountNumber' => '',
            'accountName'=>'',
            'valid' => 0
        ]); 
    }
}
