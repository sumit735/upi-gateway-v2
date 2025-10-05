<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\UserDetail;
use App\Models\Role;
use App\Enums\RoleEnum;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get roles
        $adminRole = Role::where('name', RoleEnum::ADMIN->value)->first();
        $userRole = Role::where('name', RoleEnum::USER->value)->first();

        // Create Admin User
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'phone' => '9876543210',
            'aadhaar' => '123456789012',
            'pancard' => 'ABCDE1234F',
            'password' => Hash::make('password'),
            'role_id' => $adminRole->id,
            'invalid_attempts' => 0,
            'is_blocked' => false,
        ]);

        UserDetail::create([
            'user_id' => $admin->id,
            'company_name' => 'Admin Company',
            'district' => 'Mumbai',
            'state' => 'Maharashtra',
            'pincode' => '400001',
        ]);

        // Create Regular User
        $user = User::create([
            'name' => 'Regular User',
            'email' => 'user@example.com',
            'phone' => '9876543211',
            'aadhaar' => '123456789013',
            'pancard' => 'ABCDE1234G',
            'password' => Hash::make('password'),
            'role_id' => $userRole->id,
            'invalid_attempts' => 0,
            'is_blocked' => false,
        ]);

        UserDetail::create([
            'user_id' => $user->id,
            'company_name' => 'User Company',
            'district' => 'Delhi',
            'state' => 'Delhi',
            'pincode' => '110001',
        ]);

        // Create Test User (for testing)
        $testUser = User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'phone' => '9876543212',
            'aadhaar' => '123456789014',
            'pancard' => 'ABCDE1234H',
            'password' => Hash::make('password'),
            'role_id' => $userRole->id,
            'invalid_attempts' => 0,
            'is_blocked' => false,
        ]);

        UserDetail::create([
            'user_id' => $testUser->id,
            'company_name' => 'Test Company',
            'district' => 'Bangalore',
            'state' => 'Karnataka',
            'pincode' => '560001',
        ]);

        $this->command->info('✅ Users created successfully!');
        $this->command->info('');
        $this->command->info('Login Credentials:');
        $this->command->info('─────────────────────────────────────');
        $this->command->info('👑 Admin:');
        $this->command->info('   Email: admin@example.com');
        $this->command->info('   Password: password');
        $this->command->info('');
        $this->command->info('👤 User:');
        $this->command->info('   Email: user@example.com');
        $this->command->info('   Password: password');
        $this->command->info('');
        $this->command->info('🧪 Test:');
        $this->command->info('   Email: test@example.com');
        $this->command->info('   Password: password');
        $this->command->info('─────────────────────────────────────');
    }
}
