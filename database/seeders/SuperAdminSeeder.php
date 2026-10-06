<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'superadmin@pict.com'],
            [
                'name'     => 'Super Admin',
                'password' => Hash::make('password123'),
                'role'     => 'super_admin',
            ]
        );

        $this->command->info('Super Admin berhasil dibuat:');
        $this->command->info('Email: superadmin@pict.com');
        $this->command->info('Password: password123');
    }
}