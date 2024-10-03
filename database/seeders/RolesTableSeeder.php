<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create([
            'name' => 'admin',
            'description' => 'Usuário do sistema pode cadastrar, excluir e editar eventos e categorias',
        ]);

        // Criação da role "participante"
        Role::create([
            'name' => 'participante',
            'description' => 'Participante cadastrado para se inscrever nos eventos',
        ]);
    }
}
