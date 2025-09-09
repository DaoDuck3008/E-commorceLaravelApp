<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Tạo admin
        User::create([
            'FullName' => 'Administrator',
            'Email' => 'admin@example.com',
            'PasswordHash' => Hash::make('password'),
            'PhoneNumber' => '0123456789',
            'Address' => 'Admin Address',
            'Role' => 'Admin',
        ]);

        // Tạo staff
        User::create([
            'FullName' => 'Staff User',
            'Email' => 'staff@example.com',
            'PasswordHash' => Hash::make('password'),
            'PhoneNumber' => '0987654321',
            'Address' => 'Staff Address',
            'Role' => 'Staff',
        ]);

        // Tạo customer
        User::create([
            'FullName' => 'Customer User',
            'Email' => 'customer@example.com',
            'PasswordHash' => Hash::make('password'),
            'PhoneNumber' => '0555666777',
            'Address' => 'Customer Address',
            'Role' => 'Customer',
        ]);
    }
}