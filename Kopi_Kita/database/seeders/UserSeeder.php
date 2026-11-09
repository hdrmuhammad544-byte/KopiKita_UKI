<?php

namespace Database\Seeders;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Akun Admin
        User::updateOrCreate(
            ['username' => 'admin'],
            [
                'name' => 'Administrator Kopi Kita',
                'email' => 'admin@kopikita.com',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
            ]
        );

        // Akun Kasir
        User::updateOrCreate(
            ['username' => 'kasir'],
            [
                'name' => 'Kasir Kopi Kita',
                'email' => 'kasir@kopikita.com',
                'password' => Hash::make('kasir1234'),
                'role' => 'kasir',
            ]
        );
    }
}
