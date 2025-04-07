<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'fullname' => 'Administrator', // Change the name as needed
            'username' => 'admin',
            'email' => 'markluisbonifacio@gmail.com',
            'password' => Hash::make('password123'), // Hash the password
            'role' => 1, // Example: role 1 for admin
        ]);
    }
}
