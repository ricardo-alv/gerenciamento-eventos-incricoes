<?php

namespace Tests\Feature\Admin;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Category;
use App\Models\Role;
use App\Models\User;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    protected $adminUser;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed();

        $this->adminUser = $this->createAdminUser();
    }

    protected function createAdminUser()
    {
        $user = User::factory()->create();

        $adminRole = Role::where('name', 'admin')->first();

        if ($adminRole) {
            $user->roles()->attach($adminRole->id);
        }

        return $user;
    }

    public function test_list_categories(): void
    {
        Auth::login($this->adminUser);

        $categories = Category::factory()->count(3)->create();

        $response = $this->get(route('categories.index'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.pages.categories.index');
    }

    /**
     * Testa a criação de uma nova categoria.
     */
    public function test_create_category(): void
    {
        Auth::login($this->adminUser);

        $data = [
            'name' => 'Nova Categoria',
            'description' => 'Descrição da nova categoria', 
        ];

        $response = $this->post(route('categories.store'), $data);

        $response->assertRedirect(route('categories.index')); 
        $this->assertDatabaseHas('categories', $data); 
    }

    /**
     * Testa a visualização de uma categoria específica.
     */
    public function test_show_category(): void
    {
        Auth::login($this->adminUser);
        
        $category = Category::factory()->create(); 

        $response = $this->get(route('categories.show', $category->url));

        $response->assertStatus(200);
        $response->assertViewIs('admin.pages.categories.show'); 
        $response->assertSee($category->name); 
    }

    /**
     * Testa a atualização de uma categoria existente.
     */
    public function test_update_category(): void
    {
        Auth::login($this->adminUser);

        $category = Category::factory()->create(); // Cria uma categoria

        $data = [
            'name' => 'Categoria Atualizada',
            'description' => 'Descrição atualizada', // Se houver um campo de descrição
        ];

        $response = $this->put(route('categories.update', $category->id), $data);

        $response->assertRedirect(route('categories.index')); // Redireciona após a atualização
        $this->assertDatabaseHas('categories', $data); // Verifica se a categoria foi atualizada no banco de dados
    }

    /**
     * Testa a exclusão de uma categoria existente.
     */
    public function test_delete_category(): void
    {
        Auth::login($this->adminUser);

        $category = Category::factory()->create(); 

        $response = $this->delete(route('categories.destroy', $category->id));
  
        $response->assertStatus(302);
        $response->assertRedirect(route('categories.index'));  
        $this->assertDatabaseMissing('categories', ['id' => $category->id]);  
    }

    /**
     * Testa a pesquisa de categorias.
     */
    public function test_search_category(): void
    {
        Auth::login($this->adminUser);

        $category = Category::factory()->create(['name' => 'Categoria para pesquisa']);

        $response = $this->get(route('categories.search', ['query' => 'Categoria']));

        $response->assertStatus(200);
        $response->assertSee($category->name); 
    }
}
