<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

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
    }
