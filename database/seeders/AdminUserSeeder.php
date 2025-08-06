<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin user if doesn't exist
        $adminUser = User::firstOrCreate(
            ['email' => 'admin@adunmancing.com'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('admin123'),
                'phone_number' => '08123456789',
            ]
        );

        // Assign administrator role
        $adminUser->assignRole('administrator');

        // Create editor user for testing
        $editorUser = User::firstOrCreate(
            ['email' => 'editor@adunmancing.com'],
            [
                'name' => 'Editor',
                'password' => Hash::make('editor123'),
                'phone_number' => '08123456790',
            ]
        );

        // Assign editor role
        $editorUser->assignRole('editor');
    }
}