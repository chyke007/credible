<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginTest extends TestCase
{

    
    /**
     * Missing email parameter.
     *
     * @return void
     */
    public function testLoginMissingEmail()
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->json('POST', '/api/login', ['password' => 'Sally']);
        $response
            ->assertStatus(500)
            ;
            
    }
    
    /**
     * Missing password parameter.
     *
     * @return void
     */
    public function testLoginissingpassword()
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->json('POST', '/api/login', ['email' => 'Sally@err.com']);

        $response
            ->assertStatus(500)
            ;
            
    }
    /**Invalid email parameter.
     *
     * @return void
     */
    public function testLoginInvalidEmail()
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->json('POST', '/api/login', ['email' => 'Sally', 'password'=> 'djfjjfjfjf']);

        $response
            ->assertStatus(500)
            ;
    }

     
    /**Valid Login.
     *
     * @return void
     */
    public function testValidLogin()
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->json('POST', '/api/register', ['email' => 'Sally2@test.com', 'first_name'=> 'fjfjj', 'last_name'=> 'kdkffkkf', 'password'=> 'credpal']);

        
            $response
                ->assertStatus(200)
                ;
                var_dump($response->json()['data']);
                $response = $this->withHeaders([
                    'Accept' => 'application/json',
                ])->json('POST', '/api/login', 
                ['email' => 'Sally2@test.com', 'password'=> 'credpal']);
                $this->assertEquals($response->json()['data']['user']['email'], 'Sally2@test.com');
    }

     /**Invalid email credential.
     *
     * @return void
     */
    public function testInvalidCredentials()
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->json('POST', '/api/register', ['email' => 'Sally2@test.com', 'first_name'=> 'fjfjj', 'last_name'=> 'kdkffkkf', 'password'=> 'credpal']);

        
            $response
                ->assertStatus(200)
                ;
        
                $response = $this->withHeaders([
                    'Accept' => 'application/json',
                ])->json('POST', '/api/login', 
                ['email' => 'Sallyf2@test.com', 'password'=> 'credpal']);
                $response
                ->assertStatus(401)
                ;
            }
    
            
     /**Invalid password credential
     *
     * @return void
     */
    public function testInvalidpasswordCredentials()
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->json('POST', '/api/register', ['email' => 'Sally2@test.com', 'first_name'=> 'fjfjj', 'last_name'=> 'kdkffkkf', 'password'=> 'credpal']);

        
            $response
                ->assertStatus(200)
                ;
        
                $response = $this->withHeaders([
                    'Accept' => 'application/json',
                ])->json('POST', '/api/login', 
                ['email' => 'Sally2@test.com', 'password'=> 'cffredpal']);
                $response
                ->assertStatus(401)
                ;
            }
}
