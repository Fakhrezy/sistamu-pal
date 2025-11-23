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
            'name' => 'Admin Paljaya',
            'username' => 'admin',
            'email' => 'admin@paljaya.com',
            'password' => Hash::make('password@paljaya'),
        ]);
    }
}
