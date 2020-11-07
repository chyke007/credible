<?php

use Illuminate\Database\Seeder;

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
            'role_id' => 1,
            'full_name' => 'CredPal',
            'last_name' => 'Yaba',
            'email' => 'info@zercomsystems.com',
            'admin_right' => 1,
            'password' => bcrypt('credpal')
        ]); 
        DB::table('users')->insert([
            'role_id' => 2,
            'full_name' => 'Chibuike',
            
            'last_name' => 'Nwachukwu',
            'email' => 'work@chibuikenwa.com',
            'password' => bcrypt('chibuike')
        ]); 
    }
}
