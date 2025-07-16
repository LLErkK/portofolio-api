<?php

namespace Tests\Feature;

use Database\Seeders\ProfileSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ExperienceApiTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function testGetExperienceSucces()
    {
        $this->seed(ProfileSeeder::class);
        $experienceData = [
            'company_name' => 'PT Contoh',
            'position' => 'Software Engineer',
            'start_date' => '2022-01-15',
            'end_date' => '2023-06-30',
            'description' => 'Mengembangkan aplikasi Laravel'
            
        ];


        $response = $this->postJson('/api/experience',$experienceData,[
            'Authorization' =>'test'
        ]);

        $response->assertStatus(201)
        ->assertJsonStructure([
            'data'=>[
                'id',
                'company_name',
                'position',
                'start_date',
                'end_date',
                'description',
                'user_id'
            ]
        ])
        ->assertJsonFragment([
            'company_name' => 'PT Contoh',
            'position' => 'Software Engineer',
            'start_date' => '2022-01-15',
            'end_date' => '2023-06-30',
            'description' => 'Mengembangkan aplikasi Laravel'

        ]);
    }
}
