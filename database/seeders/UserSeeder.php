<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::insert([
            [
                'name' => 'Admin Kampus',
                'email' => 'admin@kampus.ac.id',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ],
            [
                'name' => 'User Akademik 1',
                'email' => 'user1@kampus.ac.id',
                'password' => Hash::make('password'),
                'role' => 'user',
            ],
            [
                'name' => 'User Akademik 2',
                'email' => 'user2@kampus.ac.id',
                'password' => Hash::make('password'),
                'role' => 'user',
            ],
            [
                'name' => 'User Event',
                'email' => 'event@kampus.ac.id',
                'password' => Hash::make('password'),
                'role' => 'user',
            ],
            [
                'name' => 'User Umum',
                'email' => 'guest@kampus.ac.id',
                'password' => Hash::make('password'),
                'role' => 'user',
            ],
        ]);
    }
}
