<?php

namespace Database\Seeders;

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
            'password' => 'alp11111'
        ]);

        User::factory(2)->create();
    }
}
