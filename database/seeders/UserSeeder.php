<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Master (2)
        User::create([
            'name' => 'Master Admin',
            'username' => 'master',
            'email' => 'master@fofimart.com',
            'password' => Hash::make('master123'),
            'phone' => '081111111111',
            'address' => 'Jl. Master No. 1',
            'role' => 'master',
            'phone_verified_at' => now(),
            'is_first_login' => false,
        ]);

        User::create([
            'name' => 'Master Admin 2',
            'username' => 'master2',
            'email' => 'master2@fofimart.com',
            'password' => Hash::make('master123'),
            'phone' => '081111111112',
            'address' => 'Jl. Master No. 2',
            'role' => 'master',
            'phone_verified_at' => now(),
            'is_first_login' => false,
        ]);

        // Admin (2)
        User::create([
            'name' => 'Admin Fofi Mart',
            'username' => 'admin',
            'email' => 'admin@fofimart.com',
            'password' => Hash::make('admin123'),
            'phone' => '081111111113',
            'address' => 'Jl. Admin No. 1',
            'role' => 'admin',
            'phone_verified_at' => now(),
            'is_first_login' => false,
        ]);

        User::create([
            'name' => 'Admin Fofi Mart 2',
            'username' => 'admin2',
            'email' => 'admin2@fofimart.com',
            'password' => Hash::make('admin123'),
            'phone' => '081111111114',
            'address' => 'Jl. Admin No. 2',
            'role' => 'admin',
            'phone_verified_at' => now(),
            'is_first_login' => false,
        ]);

        // Kurir (2)
        User::create([
            'name' => 'Kurir Satu',
            'username' => 'kurir1',
            'email' => 'kurir1@fofimart.com',
            'password' => Hash::make('kurir123'),
            'phone' => '081111111115',
            'address' => 'Jl. Kurir No. 1',
            'role' => 'kurir',
            'phone_verified_at' => now(),
            'is_first_login' => false,
        ]);

        User::create([
            'name' => 'Kurir Dua',
            'username' => 'kurir2',
            'email' => 'kurir2@fofimart.com',
            'password' => Hash::make('kurir123'),
            'phone' => '081111111116',
            'address' => 'Jl. Kurir No. 2',
            'role' => 'kurir',
            'phone_verified_at' => now(),
            'is_first_login' => false,
        ]);

        // User (2)
        User::create([
            'name' => 'Pelanggan Satu',
            'username' => 'user1',
            'email' => 'user1@fofimart.com',
            'password' => Hash::make('user123'),
            'phone' => '081111111117',
            'address' => 'Jl. User No. 1',
            'role' => 'user',
            'phone_verified_at' => now(),
            'is_first_login' => false,
        ]);

        User::create([
            'name' => 'Pelanggan Dua',
            'username' => 'user2',
            'email' => 'user2@fofimart.com',
            'password' => Hash::make('user123'),
            'phone' => '081111111118',
            'address' => 'Jl. User No. 2',
            'role' => 'user',
            'phone_verified_at' => now(),
            'is_first_login' => false,
        ]);
    }
}
