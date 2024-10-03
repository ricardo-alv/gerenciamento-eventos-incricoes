<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Super Admin',
            'email' => 'super.admin@com.br',
            'password' => Hash::make(12345678), //senha 12345678
            'cpf' => 12345678910,
            'address' => 'address',
            'data_birth' => now(),
        ]);
    }
}
