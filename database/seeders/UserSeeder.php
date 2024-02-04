<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            'fname' => 'Alp',
            'lname' => 'Arslan',
            'username' => 'alparslan1029',
            'email' => 'alp.arslan@gmail.com',
            'password' => 'password'
        ]);

        User::factory(2)
            ->hasPosts(5)
            ->hasComments(10)
            ->create();
    }
}
