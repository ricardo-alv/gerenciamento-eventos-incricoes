<?php

namespace Tests\Feature\Admin;

use App\Models\{Category, Event, Role, User};
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class EventTest extends TestCase
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
    /**
     * Test index method
     */
    public function test_list_events(): void
    {
        Auth::login($this->adminUser);

        Event::factory(10)->create(); // Criando 10 eventos de exemplo

        $response = $this->get(route('events.index'));

        $response->assertStatus(200);
        $response->assertViewHas('events');
    }

    /**
     * Test create method
     */
    public function test_create_event(): void
    {
        Auth::login($this->adminUser);

        Category::factory(5)->create(); // Criando 5 categorias de exemplo

        $response = $this->get(route('events.create'));

        $response->assertStatus(200);
        $response->assertViewHas('categories');
    }

    /**
     * Test store method
     */
    public function test_store_new_event(): void
    {
        Auth::login($this->adminUser);

        $category = Category::factory()->create();

        $data = [
            'name' => 'Event Test',
            'description' => 'Event description',
            'url' => 'event-url',
            'category_id' => $category->id,
            'location' => 'location',
            'start_date' => now(),
            'end_date' => now(),
            'capacity' => 50    
        ];

        $response = $this->post(route('events.store'), $data);

        $response->assertRedirect(route('events.index'));
        $this->assertDatabaseHas('events', ['name' => 'Event Test']);
    }

    /**
     * Test show method
     */
    public function test_show_event(): void
    {
        Auth::login($this->adminUser);

        $event = Event::factory()->create();

        $response = $this->get(route('events.show', $event->url));

        $response->assertStatus(200);
        $response->assertViewHas('event');
    }

    /**
     * Test update method
     */
    public function test_update_event(): void
    {
        Auth::login($this->adminUser);    

        $category = Category::factory()->create();
        $event = Event::factory()->create(['user_id' => auth()->user()->id]);

        $data = [
            'name' => 'Updated Event Name',
            'description' => 'Updated description',
            'category_id' => $category->id,
            'location' => 'location',
            'start_date' => now(),
            'end_date' => now(),
            'capacity' => 50    
        ];

        $response = $this->put(route('events.update', $event->id), $data);

        $response->assertRedirect(route('events.index'));
        $this->assertDatabaseHas('events', ['name' => 'Updated Event Name']);
    }

    /**
     * Test destroy method
     */
    public function test_destroy_event(): void
    {
        Auth::login($this->adminUser);
        $event = Event::factory()->create(['user_id' => auth()->user()->id]);

        $response = $this->delete(route('events.destroy', $event->id));

        $response->assertRedirect(route('events.index')); 
    }

    public function test_search_events()
    {
        Auth::login($this->adminUser);

        $category = Category::factory()->create();
        $event = Event::factory()->create();      

        // Testa a busca pelo nome
        $response = $this->get(route('events.search', ['filter' => $event->name]));
        $response->assertStatus(200);


        //Testa a busca sem filtro
        $response = $this->get(route('events.search', ['filter' => '']));
        $response->assertStatus(200);   
    }
}
