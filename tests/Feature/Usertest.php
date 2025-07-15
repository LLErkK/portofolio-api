<?php

namespace Tests\Feature;

use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class Usertest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testregisterUser()
    {
        $this->post('/api/users',[
          'username'=>'rozaq',
          'password'=>'admin123',
          'name' => 'Ahmad Subhan fattakurozaq'  
        ])->assertStatus(201)
        ->assertJson([
            "data"=>[
                'username'=>'rozaq',
                'name' => 'Ahmad Subhan fattakurozaq' 
            ]
        ]);
        
    }

    public function testregisterfailed()
    {
        $this->post('/api/users',[
          'username'=>'',
          'password'=>'',
          'name' => ''  
        ])->assertStatus(400)
        ->assertJson([
            "errors"=>[
                'username'=>[
                    'The username field is required.'
                ],
                'password'=>[
                    'The password field is required.'
                ] ,
                'name' => [
                    'The name field is required.'
                ]
                
            ]
        ]);
    }

    public function testregisterUsenameAlreadyExist()
    {
        $this->testregisterUser();
        $this->post('/api/users',[
          'username'=>'rozaq',
          'password'=>'admin123',
          'name' => 'Ahmad Subhan fattakurozaq'  
        ])->assertStatus(400)
        ->assertJson([
            "errors"=>[
                'username'=>[

                ] 
            ]
        ]);
    }

    public function testGetUserSuccess(){
        $this->seed([UserSeeder::class]);
        $this->get('/api/users/current',[
            'Authorization'=>'test'
        ])->assertStatus(200)
        ->assertJson([
            'data'=>[
                'username'=>'test',
                'name'=>'test',

            ]
        ]);
    }

    public function testGetUserUnauthorized(){
        $this->seed([UserSeeder::class]);
        $this->get('/api/users/current',[
            'Authorization'=>''
        ])->assertStatus(401)
        ->assertJson([
            'errors'=>[
                'message'=>[
                    'unauthorized'
                ]
                
            ]
        ]);
    }

    public function testgetUserInvalidToken(){
        $this->seed([UserSeeder::class]);
        $this->get('/api/users/current',[
            'Authorization'=>'salah'
        ])->assertStatus(401)
        ->assertJson([
            'errors'=>[
                'message'=>[
                    'unauthorized'
                ]
                
            ]
        ]);
    }

}
