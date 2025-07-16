<?php

namespace Database\Seeders;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {   $user = User::create([
        'username' => 'test',
        'password' => bcrypt('password'),
        'name'     => 'Seeded Name',
        'token'    => 'test'
    ]);

    Profile::create([
        'user_id' => $user->id,
        'name' => 'Seeded Name',
        'bio' => 'Seeded Bio',
        'linkedin' => 'https://linkedin.com/in/seeded',
        'github' => 'https://github.com/seeded',
    ]);
    }
}
