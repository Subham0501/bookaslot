<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create or update admin user
        $admin = User::updateOrCreate(
            ['email' => 'admin@hamroyaad.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('admin#100$$'),
                'is_admin' => true,
            ]
        );

        $this->command->info('Admin user created/updated successfully!');
        $this->command->info('Email: admin@hamroyaad.com');
        $this->command->info('Password: newpassword123');
    }
}
