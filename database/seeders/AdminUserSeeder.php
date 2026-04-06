<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Администратор',
            'email' => 'admin@tokyobloom.ru',
            'password' => Hash::make('admin123'),
            'bonuses' => 0,
            'is_admin' => true,
        ]);
        
        // Обычный пользователь для тестирования
        User::create([
            'name' => 'Тестовый пользователь',
            'email' => 'user@test.ru',
            'password' => Hash::make('user123'),
            'bonuses' => 500,
            'is_admin' => false,
        ]);
    }
}