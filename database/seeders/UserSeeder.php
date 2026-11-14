<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $admin = new User();
        $admin->name = 'Administrador';
        $admin->email = 'admin@loja.pt';
        $admin->password = Hash::make('password123');
        $admin->is_admin = true;
        $admin->save();

        $user = new User();
        $user->name = 'Cliente Teste';
        $user->email = 'cliente@loja.pt';
        $user->password = Hash::make('password123');
        $user->is_admin = false;
        $user->save();
    }
}
