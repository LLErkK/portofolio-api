<?php

namespace Tests\Feature;

use App\Models\Profile;
use App\Models\User;
use Database\Seeders\ProfileSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ProfileApiTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    
    public function testGetProfileSuccess()
{
    $this->seed([ProfileSeeder::class]);
    $response=$this->get('/api/profile',[
        'Authorization'=>'test'
    ]);
    $response->assertStatus(200)
    
    ->assertJson([
        'data'=>[
            'name' => 'Seeded Name',
            'bio' => 'Seeded Bio',
            'linkedin' => 'https://linkedin.com/in/seeded',
            'github' => 'https://github.com/seeded'
        ]
       ] );
}

    public function testGetProfileUnauthroized()
{
    $this->seed([ProfileSeeder::class]);
    $response=$this->get('/api/profile',[
        'Authorization'=>''
    ]);
    $response->assertStatus(401)
    
    ->assertJson([
        'errors' => [
            'message' => ['unauthorized']
            ]
       ] );
}
public function testUpdateProfileSuccess()
{
    $this->seed(ProfileSeeder::class);

    $response = $this->patch('/api/profile', [
        'name' => 'Updated Name',
        'bio' => 'Updated Bio',
        'linkedin' => 'https://linkedin.com/in/updated',
        'github' => 'https://github.com/updated',
    ], [
        'Authorization' => 'test'
    ]);

    $response->assertStatus(200)
             ->assertJsonFragment(['name' => 'Updated Name']);
}

public function testUpdateProfileNotFound()
{
    $this->seed(ProfileSeeder::class);

    $response = $this->patch('/api/profile', [
        'name' => 'Updated Name',
        'bio' => 'Updated Bio',
        'linkedin' => 'https://linkedin.com/in/updated',
        'github' => 'https://github.com/updated',
    ], [
        'Authorization' => ''
    ]);

    $response->assertStatus(401)
             ->assertJsonFragment([
                'errors' => [
                    'message' => ['unauthorized']
            ]]);
}

    public function testLogoutSuccess(){
    $this->seed([UserSeeder::class]);
    $this->delete(uri:'/api/users/logout',headers:[
        'Authorization'=> 'test'
    ])->assertStatus(200)
    ->assertJson([
        "data" =>true
    ]);
}


    
}
