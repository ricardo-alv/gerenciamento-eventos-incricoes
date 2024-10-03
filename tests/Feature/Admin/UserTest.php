<?php

namespace Tests\Feature\Admin;

use App\Models\{Role, User};
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class UserTest extends TestCase
{
    private User $superAdmin;

    protected function setUp(): void
    {
        parent::setUp();

        // Criar um super administrador o qual tem permissão para criar os usuarios
        $this->superAdmin = User::factory()->create([
            'email' => 'super.admin@com.br',
        ]);
    }

    /**
     * Testa se a página de listagem de usuários é exibida corretamente.
     */

    public function test_index_displays_users()
    {
        $response = $this->actingAs($this->superAdmin)->get(route('users.index'));

        $response->assertStatus(200);
        $response->assertViewHas('users');
    }

    /**
     * Testa se o formulário de criação de usuários é exibido corretamente.
     */

    public function test_create_displays_form()
    {
        $response = $this->actingAs($this->superAdmin)->get(route('users.create'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.pages.users.create');
    }

    /**
     * Testa se a criação de um usuário funciona corretamente.
     */

    public function test_store_creates_user()
    {
        $data = [
            'name' => 'Ricardo Alves',
            'email' => 'ricardoalv.88@gmail.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'cpf' => '12345678900',
            'address' => '123 Main St',
            'data_birth' => '1990-01-01',
        ];

        $response = $this->actingAs($this->superAdmin)->post(route('users.store'), $data);

        $this->assertDatabaseHas('users', ['email' => 'ricardoalv.88@gmail.com']);
        $response->assertRedirect(route('users.index'));
        $response->assertSessionHas('success', 'Criado com sucesso.');
    }


    /**
     * Testa a visualização de usuario.
     */
    public function test_show_displays_user()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($this->superAdmin)->get(route('users.show', $user->id));

        $response->assertStatus(200);
        $response->assertViewHas('user');
    }

    /**
     * Testa se o formulário de edição de usuário é exibido corretamente
     */

    public function test_edit_displays_edit_form()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($this->superAdmin)->get(route('users.edit', $user->id));

        $response->assertStatus(200);
        $response->assertViewHas('user');
    }

    /**
     * Testa a atualização de usuario existente.
     */

    public function test_update_user()
    {
        $user = User::factory()->create();
        $data = [
            'name' => 'Updated Name',
            'data_birth' => '1990-01-01',
            'address' => '456 Main St',
        ];

        $response = $this->actingAs($this->superAdmin)->put(route('users.update', $user->id), $data);

        $this->assertDatabaseHas('users', ['name' => 'Updated Name']);
        $response->assertRedirect(route('users.index'));
        $response->assertSessionHas('success', 'Atualizada com sucesso.');
    }

    /**
     * Testa a exclusão de um usuario existente.
     */

    public function test_destroy_user()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($this->superAdmin)->delete(route('users.destroy', $user->id));

        $response->assertRedirect(route('users.index'));
        $response->assertSessionHas('success', 'Excluído com sucesso.');
    }
}
