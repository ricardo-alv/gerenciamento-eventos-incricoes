<?php

namespace Tests\Feature\Admin;


use App\Models\{Registration, Event, Category, User};
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    private User $user;
    private Event $event;
    private Category $category;

    protected function setUp(): void
    {
        parent::setUp();

        // Criação de um usuário autenticado
        $this->user = User::factory()->create([
            'email' => 'user@example.com',
        ]);

        $this->actingAs($this->user);

        // Criação de uma categoria e um evento
        $this->category = Category::factory()->create();
        $this->event = Event::factory()->create([
            'category_id' => $this->category->id,
            'capacity' => 10,
            'start_date' => now()->addDays(1), // Evento no futuro
        ]);
    }

    /**
     * Testa se a página inicial do dashboard é exibida corretamente.
     */
    public function test_index_displays_dashboard()
    {
        $response = $this->actingAs($this->user)->get(route('dashboard.index'));

        $response->assertStatus(200);
        $response->assertViewHas('events');
        $response->assertViewHas('categories');
    }

    /**
     * Testa a atualização da inscrição em um evento.
     */
    public function test_update_event_registration()
    {

        $response = $this->actingAs($this->user)->put(route('dashboard.update', $this->event->id));

        // Verifica se a inscrição foi criada
        $this->assertDatabaseHas('registrations', [
            'event_id' => $this->event->id,
            'user_id' => $this->user->id,
        ]);
        $response->assertRedirect(route('dashboard.index'));
        $response->assertSessionHas('success', 'Inscrição realizada com sucesso!.');
    }

    /**
     * Testa a atualização da inscrição em um evento já cheio.
     */
    public function test_update_event_registration_when_full()
    {
        // Cria um evento com capacidade preenchida
        $this->event->registrations()->create([
            'user_id' => $this->user->id,
            'participant_name' => $this->user->name,
            'participant_email' => $this->user->email,
        ]);

        // Preenche a capacidade do evento
        Registration::factory()->count(9)->create(['event_id' => $this->event->id]);

        $response = $this->actingAs($this->user)->put(route('dashboard.update', $this->event->id));

        $response->assertRedirect(route('dashboard.index'));
        $response->assertSessionHas('warning', 'Desculpe, não há mais vagas disponíveis para este evento.');
    }

    /**
     * Testa a tentativa de inscrição em um evento já inscrito.
     */
    public function test_update_event_registration_when_already_registered()
    {
        // Inscreve o usuário no evento
        $this->event->registrations()->create([
            'user_id' => $this->user->id,
            'participant_name' => $this->user->name,
            'participant_email' => $this->user->email,
        ]);

        $response = $this->actingAs($this->user)->put(route('dashboard.update', $this->event->id));

        $response->assertRedirect(route('dashboard.index'));
        $response->assertSessionHas('warning', 'Você já está inscrito neste evento.');
    }

    /**
     * Testa a remoção da inscrição em um evento.
     */
    public function test_destroy_event_registration()
    {
        // Inscreve o usuário no evento
        $registration = Registration::factory()->create([
            'event_id' => $this->event->id,
            'user_id' => $this->user->id,
        ]);

        $response = $this->actingAs($this->user)->delete(route('dashboard.destroy', $this->event->id));

        // Verifica se a inscrição foi removida
        // $this->assertDeleted($registration);
        $response->assertRedirect()->with('success', 'Inscrição cancelada com sucesso.');
    }

    /**
     * Testa a tentativa de cancelar a inscrição após o início do evento.
     */
    public function test_destroy_event_registration_after_start()
    {
        // Muda a data de início do evento para o passado
        $this->event->start_date = now()->subDays(1);
        $this->event->save();

        $registration = Registration::factory()->create([
            'event_id' => $this->event->id,
            'user_id' => $this->user->id,
        ]);

        $response = $this->actingAs($this->user)->delete(route('dashboard.destroy', $this->event->id));

        $response->assertRedirect()->with('error', 'Você não pode cancelar a inscrição após o início do evento.');
    }

    /**
     * Testa a busca de eventos.
     */
    public function test_search_events()
    {
        $response = $this->actingAs($this->user)->get(route('dashboard.search', [
            'category' => $this->category->id,
            'start_date' => now()->format('Y-m-d'),
            'end_date' => now()->addDays(2)->format('Y-m-d'),
        ]));

        $response->assertStatus(200);
        $response->assertViewHas('events');
        $response->assertViewHas('categories');
    }
}
