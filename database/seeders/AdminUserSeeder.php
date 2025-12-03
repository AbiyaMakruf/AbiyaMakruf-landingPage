<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'aabbiiyyaa@gmail.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('12345678'),
                // 'is_admin' => true, // Assuming you might add this column to users table later, or just rely on this specific email
            ]
        );
    }
}
