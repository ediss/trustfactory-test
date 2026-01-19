<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@trustfactory.com',
            'password' => Hash::make('password'),
            'is_admin' => true,
        ]);

        // Create a regular test user
        User::create([
            'name' => 'Test User',
            'email' => 'user@trustfactory.com',
            'password' => Hash::make('password'),
            'is_admin' => false,
        ]);
    }
}
