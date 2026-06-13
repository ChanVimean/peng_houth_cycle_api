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
            'firstname' => 'Admin',
            'lastname' => 'Account',
            'email' => 'admin@pengHouth.com',
            'role' => 'admin',
            'phone' => null,
            'password' => Hash::make('password'),
        ]);

        User::create([
            'firstname' => 'Customer',
            'lastname' => 'Account',
            'email' => 'customer@pengHouth.com',
            'role' => 'customer',
            'phone' => null,
            'password' => Hash::make('password'),
        ]);
    }
}