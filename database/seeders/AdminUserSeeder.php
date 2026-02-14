<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get seller email from environment or use default
        $sellerEmail = env('SELLER_EMAIL', 'admin@shiivaraa.com');

        // Create or update the admin/seller user
        User::updateOrCreate(
            ['email' => $sellerEmail],
            [
                'name' => 'Shiivaraa Admin',
                'password' => Hash::make('password'), // Change this in production!
                'role' => 'admin',
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );

        $this->command->info('Admin user created successfully!');
        $this->command->info('Email: ' . $sellerEmail);
        $this->command->info('Password: password (Please change this in production!)');
    }
}
