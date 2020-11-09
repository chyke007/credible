<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegisterTest extends TestCase
{

    public $first_name = 'ddddddddddddddddddddddddddddddddddddddddddddddddddddd';
    public $last_name = 'ddddddddddddddddddddddddddddddddddddddddddddddddddddd';
    public $password = 'ddddddddddddddddddddddddddddddddddddddddddddddddddddd';
    /**
     * A basic feature test example.
     *
     * @return void
     */
   
    public function testHomePage()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
    /**
     * Missing email parameter.
     *
     * @return void
     */
    public function testRegiterMissingEmail()
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->json('POST', '/api/register', ['name' => 'Sally']);

        $response
            ->assertStatus(422)
            ;
            
    }
    
    /**
     * Missing first_name parameter.
     *
     * @return void
     */
    public function testRegiterMissingFirstName()
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->json('POST', '/api/register', ['email' => 'Sally@err.com']);

        $response
            ->assertStatus(422)
            ;
            
    }
    /**
     * Missing last_name parameter.
     *
     * @return void
     */
    public function testRegiterMissingLastName()
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->json('POST', '/api/register', ['email' => 'Sally@err.com', 'first_name' => 'fhfhfhhnf']);

        $response
            ->assertStatus(422)
            ;
            
    }

    
    /**
     * Missing password parameter.
     *
     * @return void
     */
    public function testRegiterMissingpassword()
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->json('POST', '/api/register', ['email' => 'Sally@err.com', 'first_name' => 'fhfhfhhnf', 'last_name']);

        $response
            ->assertStatus(422)
            ;
            
    }
    /**Invalid email parameter.
     *
     * @return void
     */
    public function testRegiterInvalidEmail()
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->json('POST', '/api/register', ['email' => 'Sally', 'first_name'=> 'fjfjj', 'last_name'=> 'kdkffkkf', 'password'=> 'djfjjfjfjf']);

        $response
            ->assertStatus(422)
            ;
    }
     /**Invalid first_name parameter.
     *
     * @return void
     */
    public function testRegiterInvalidFirstName()
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->json('POST', '/api/register', ['email' => 'Sally@test.com','first_name'=>$this->first_name, 'last_name'=> 'kdkffkkf', 'password'=> 'djfjjfjfjf']);

        $response
            ->assertStatus(422)
            ;
    }
     /**Invalid last_name parameter.
     *
     * @return void
     */
    public function testRegiterInvalidLastName()
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->json('POST', '/api/register', ['email' => 'Sally@test.com','first_name'=> 'fjfjj', 'password'=> 'djfjjfjfjf','last_name'=>$this->last_name]);

        $response
            ->assertStatus(422)
            ;
    }

    /**Invalid password parameter.
     *
     * @return void
     */
    public function testRegiterInvalidPassword()
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->json('POST', '/api/register', ['email' => 'Sally@fff.fff', 'first_name'=> 'fjfjj', 'last_name'=> 'kdkffkkf', 'password'=> $this->password]);

        $response
            ->assertStatus(422)
            ;
    }

     /**Valid Data.
     *
     * @return void
     */
    public function testRegiterValidData()
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Content-type' => 'application/json'
        ])->json('POST', '/api/register', ['email' => 'sally1@test.com', 'first_name'=> 'fjfjj', 'last_name'=> 'kdkffkkf', 'password'=> 'credpal']);

        $response
            ->assertStatus(200)
            ;
    }

    /**Increment referral.
     *
     * @return void
     */
    public function testRegisterReferral()
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->json('POST', '/api/register', ['email' => 'Sally2@test.com', 'first_name'=> 'fjfjj', 'last_name'=> 'kdkffkkf', 'password'=> 'credpal']);

        $response
            ->assertStatus(200)
            ;
            $referral = $response->json()['data']['user']['referral_code'];
            $response = $this->withHeaders([
                'Accept' => 'application/json',
            ])->json('POST', '/api/register', ['email' => 'Sally3@test.com', 'first_name'=> 'fjfjj', 'last_name'=> 'kdkffkkf', 'password'=> 'credpal',"referral"=>$referral]);
    
            $response
                ->assertStatus(200)
                ;
        
                $response = $this->withHeaders([
                    'Accept' => 'application/json',
                ])->json('POST', '/api/login', ['email' => 'Sally2@test.com', 'password'=> 'credpal']);
                   
                $this->assertEquals($response->json()['data']['user']['wallet'], 1000);
    }

    
}
