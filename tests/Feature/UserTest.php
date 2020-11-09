<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class UserTest extends TestCase
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
        ])->json('GET', '/api/user');
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
        ])->json('GET', '/api/user');
        $response
            ->assertStatus(403)
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
        ])->json('POST', '/api/user');
        $response
            ->assertStatus(403)
            ;
            
    }
    public function teststoreValidUser()
    {
        
        $response = $this->withHeaders([
                'Accept' => 'application/json',
            ])->json('POST', '/api/login', ['email' => 'user@credpal.com', 'password'=> 'credpal']);
            $token = $response->json()['data']['token'];
            $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => "Bearer $token"
        ])->json('POST', '/api/user',["first_name"=> "Wale","last_name"=> "Adenuga","accountName"=> "fjffjfjff fj","accountNumber"=> "38849374930","bank"=>"FCMB"]);
        $response
            ->assertStatus(200)
            ;
            
    }
    public function teststoreInValidUser()
    {
        
        $response = $this->withHeaders([
                'Accept' => 'application/json',
            ])->json('POST', '/api/login', ['email' => 'user@credpal.com', 'password'=> 'credpal']);
            $token = $response->json()['data']['token'];
            $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => "Bearer $token"
        ])->json('POST', '/api/user',["last_name"=> "Adenuga","accountName"=> "fjffjfjff fj","accountNumber"=> "38849374930","bank"=>"FCMB"]);
        $response
            ->assertStatus(500)
            ;
            
    }

    
    public function teststoreValidUserWithFile()
    {
        
        Storage::fake('public');

        $identity = UploadedFile::fake()->image('avatar.jpg');

        $response = $this->withHeaders([
                'Accept' => 'application/json',
            ])->json('POST', '/api/login', ['email' => 'user@credpal.com', 'password'=> 'credpal']);
            $token = $response->json()['data']['token'];
            $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => "Bearer $token"
        ])->json('POST', '/api/user',["first_name"=> "Wale","last_name"=> "Adenuga","accountName"=> "fjffjfjff fj","accountNumber"=> "38849374930","bank"=>"FCMB","identity"=>$identity ]);
        $response
            ->assertStatus(200)
            ;
            
            Storage::disk('public')->assertExists("identity/".$identity->hashName());

       
            
    }
    public function testPutUser()
    {
        
        $response = $this->withHeaders([
                'Accept' => 'application/json',
            ])->json('POST', '/api/login', ['email' => 'user@credpal.com', 'password'=> 'credpal']);
            $token = $response->json()['data']['token'];
            $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => "Bearer $token"
        ])->json('PUT', '/api/user/2');
        $response
            ->assertStatus(403)
            ;
            
    }
    public function testPutByAdmin()
    {
        
        $response = $this->withHeaders([
                'Accept' => 'application/json',
            ])->json('POST', '/api/login', ['email' => 'admin@credpal.com', 'password'=> 'credpal']);
            $token = $response->json()['data']['token'];
            $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => "Bearer $token"
        ])->json('PUT', '/api/user/2');
        $response
            ->assertStatus(200)
            ;
            
    }

}
