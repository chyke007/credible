<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class TransferTest extends TestCase
{

    
    /**
     * admin.
     *
     * @return void
     */
    public function testIndexAdmin()
    {
        
        $response = $this->withHeaders([
                'Accept' => 'application/json',
            ])->json('POST', '/api/login', ['email' => 'admin@credpal.com', 'password'=> 'credpal']);
            $token = $response->json()['data']['token'];
            $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => "Bearer $token"
        ])->json('GET', '/api/transfer');
        $response
            ->assertStatus(200)
            ;
            
    }
     
    /**
     * Missing email parameter.
     *
     * @return void
     */
    public function testIndexUser()
    {
        
        $response = $this->withHeaders([
                'Accept' => 'application/json',
            ])->json('POST', '/api/login', ['email' => 'user@credpal.com', 'password'=> 'credpal']);
            $token = $response->json()['data']['token'];
            $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => "Bearer $token"
        ])->json('GET', '/api/transfer');
        $response
            ->assertStatus(200)
            ;
            
    }
    public function teststoreAdmin()
    {
        
        $response = $this->withHeaders([
                'Accept' => 'application/json',
            ])->json('POST', '/api/login', ['email' => 'admin@credpal.com', 'password'=> 'credpal']);
            $token = $response->json()['data']['token'];
            $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => "Bearer $token"
        ])->json('POST', '/api/transfer',['mode'=> 'instant', "amount"=> "1200","transfer_time"=>"2020:20:30"]);
        $response
            ->assertStatus(403)
            ;
            
    }

    public function teststoreLimitUserNoKyc()
    {
        
        $response = $this->withHeaders([
                'Accept' => 'application/json',
            ])->json('POST', '/api/login', ['email' => 'user@credpal.com', 'password'=> 'credpal']);
            $token = $response->json()['data']['token'];
            $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => "Bearer $token"
        ])->json('POST', '/api/transfer',['mode'=> 'instant', "amount"=> "51000","transfer_time"=>"2020:02:30"]);
        $response
            ->assertStatus(422)
            ;
            
    }
    public function teststoreMoreThanWalletUser()
    {
        
        $response = $this->withHeaders([
                'Accept' => 'application/json',
            ])->json('POST', '/api/login', ['email' => 'user@credpal.com', 'password'=> 'credpal']);
            $token = $response->json()['data']['token'];
            $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => "Bearer $token"
        ])->json('POST', '/api/transfer',['mode'=> 'instant', "amount"=> "41000","transfer_time"=>"2020:02:30"]);
        $response
            ->assertStatus(422)
            ;
            
    }

    
    public function teststoreValidInstantUser()
    {
        
        $response = $this->withHeaders([
                'Accept' => 'application/json',
            ])->json('POST', '/api/login', ['email' => 'user@credpal.com', 'password'=> 'credpal']);
            $token = $response->json()['data']['token'];
            $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => "Bearer $token"
        ])->json('POST', '/api/transfer',['mode'=> 'instant', "amount"=> "2000","transfer_time"=>"2020:02:30"]);
        $response
            ->assertStatus(200)
            ;
            
    }

    public function teststoreValidFutureUser()
    {
        
        $response = $this->withHeaders([
                'Accept' => 'application/json',
            ])->json('POST', '/api/login', ['email' => 'user@credpal.com', 'password'=> 'credpal']);
            $token = $response->json()['data']['token'];
            $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => "Bearer $token"
        ])->json('POST', '/api/transfer',['mode'=> 'future', "amount"=> "2000","transfer_time"=>"2020:02:30"]);
        $response
            ->assertStatus(200)
            ;
            
    }

}
