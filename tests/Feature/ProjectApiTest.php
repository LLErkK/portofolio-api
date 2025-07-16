<?php

namespace Tests\Feature;

use Database\Seeders\ProfileSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProjectApiTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function testPostProjectSuccess()
    {
        $this->seed(ProfileSeeder::class);

        $projectData = [
            'name' => 'Project Test',
            'description' => '',
            'link' => '',
            'tech_stack' => '',
            // karena tidak upload file, images bisa kosong atau dilewatkan
        ];

        $response = $this->postJson('/api/project', $projectData, [
            'Authorization' => 'test'
        ]);

        $response->assertStatus(201)
                ->assertJsonStructure([
                    'data' => [
                        'id',
                        'name',
                        'description',
                        'link',
                        'tech_stack',
                        'images',
                        'user_id'
                    ]
                ])
                ->assertJsonFragment([
                    'name' => 'Project Test'
                ]);
    }
    public function testPostProjectUnauthorized()
    {
        $this->seed(ProfileSeeder::class);

        $projectData = [
            'name' => 'Project Test',
            'description' => '',
            'link' => '',
            'tech_stack' => '',
            // karena tidak upload file, images bisa kosong atau dilewatkan
        ];

        $response = $this->postJson('/api/project', $projectData, [
            'Authorization' => ''
        ]);

        $response->assertStatus(401)
                ->assertJsonFragment([
                    'errors' => [
                        'message' => ['unauthorized']
                    ]
                    ]);
                
    }
    public function testUpdateProjectSuccess()
{
    $this->seed(ProfileSeeder::class);

    // Tambahkan project baru terlebih dahulu
    $projectData = [
        'name' => 'Original Project',
        'description' => 'Desc',
        'link' => 'https://example.com',
        'tech_stack' => 'Laravel'
    ];

    $createResponse = $this->postJson('/api/project', $projectData, [
        'Authorization' => 'test'
    ]);

    $createResponse->assertStatus(201);
    $projectId = $createResponse->json('data.id');

    // Update project yang sudah dibuat
    $updatedData = [
        'name' => 'Updated Project',
        'description' => 'Updated Description',
        'link' => 'https://example.org',
        'tech_stack' => 'Laravel, Vue.js',
    ];

    $updateResponse = $this->patchJson("/api/project/{$projectId}", $updatedData, [
        'Authorization' => 'test'
    ]);

    $updateResponse->assertStatus(200)
        ->assertJsonFragment([
            'name' => 'Updated Project',
            'description' => 'Updated Description',
            'link' => 'https://example.org',
            'tech_stack' => 'Laravel, Vue.js',
            'user_id'=>''
        ])
        ->assertJsonStructure([
            'data' => [
                'id',
                'name',
                'description',
                'link',
                'tech_stack',
                'images',
                'user_id',
            ]
        ]);
}
public function testDeleteProjectSuccess()
{
    $this->seed(ProfileSeeder::class);

    // Buat project terlebih dahulu
    $projectData = [
        'name' => 'Project to Delete',
        'description' => 'Temporary',
        'link' => 'https://temp.test',
        'tech_stack' => 'PHP'
    ];

    $createResponse = $this->postJson('/api/project', $projectData, [
        'Authorization' => 'test'
    ]);

    $createResponse->assertStatus(201);

    $projectId = $createResponse->json('data.id');

    // Lakukan DELETE
    $deleteResponse = $this->deleteJson("/api/project/{$projectId}", [], [
        'Authorization' => 'test'
    ]);

    $deleteResponse->assertStatus(200)
        ->assertJsonFragment([
            'message' => 'Project deleted successfully'
        ]);

    // Pastikan project benar-benar hilang dari database
    $this->assertDatabaseMissing('Projects', [
        'id' => $projectId,
        'name' => 'Project to Delete'
    ]);
}


}
