<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Event;
use App\Models\Registration;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct(
        private Event $event,
        private Category $category

    ) {}

    public function index()
    {
        $categories = $this->category->latest()->get();

        $events = $this->event->with(['category', 'registrations' => function ($query) {
            $query->where('user_id', auth()->id()); // Verifica se o usuário está inscrito
        }])->withCount('registrations')
            ->latest()->paginate();

        return view('admin.pages.home.home', compact('events', 'categories'));
    }

    public function update(Request $request, string $event_id)
    {
        $event = Event::findOrFail($event_id);

        if ($event->registrations()->count() >= $event->capacity) {
            return redirect()->route('dashboard.index')
                ->with('warning', 'Desculpe, não há mais vagas disponíveis para este evento.');
        }

        if ($event->registrations()->where('user_id', auth()->id())->exists()) {
            return redirect()->route('dashboard.index')
                ->with('warning', 'Você já está inscrito neste evento.');
        }

        $registration = Registration::create([
            'event_id' => $event_id,
            'user_id' => auth()->id(),
            'participant_name' => auth()->user()->name,
            'participant_email' => auth()->user()->email,
        ]);

        return redirect()->route('dashboard.index')
            ->with('success', 'Inscrição realizada com sucesso!.');
    }

    public function destroy(string $event_id)
    {
        if (!$event = Event::findOrFail($event_id)) {
            return redirect()->back();
        }
        // Busca a inscrição do usuário para o evento
        $registration = Registration::where('event_id', $event_id)
            ->where('user_id', auth()->id())
            ->first();

        if (now()->greaterThanOrEqualTo($event->start_date)) {
            return redirect()
                ->back()
                ->with('error', 'Você não pode cancelar a inscrição após o início do evento.');
        }

        // Se não encontrar a inscrição, pode redirecionar com uma mensagem de erro
        if (!$registration) {
            return redirect()
                ->back()
                ->with('error', 'Você não está inscrito neste evento.');
        }

        $registration->delete();
        return redirect()->back()->with('success', 'Inscrição cancelada com sucesso.');
    }

    public function search(Request $request)
    {
        $filters = $request->only('category', 'start_date', 'end_date');
        $categories = $this->category->latest()->get();

        $events = $this->event->filterEventsDashboard($filters);

        return view('admin.pages.home.home', compact('events', 'categories', 'filters'));        
    }
}
