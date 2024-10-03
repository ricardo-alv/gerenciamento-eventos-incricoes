<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateEvent;
use Illuminate\Support\Facades\Gate;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Event;

class EventController extends Controller
{
    public function __construct(
        private Event $event,
        private Category $category

    ) {
        $this->middleware(['can:is-admin']);
    }

    public function index()
    {
        $events = $this->event->latest()->paginate();
        return view('admin.pages.events.index', compact('events',));
    }

    public function create()
    {
        $categories = $this->category->latest()->get();
        return view('admin.pages.events.create', compact('categories'));
    }

    public function store(StoreUpdateEvent $request)
    {
        $this->event->create($request->all());
        return redirect()->route('events.index')
            ->with('success', 'Criado com sucesso.');
    }

    public function show(string $url)
    {
        if (!$event = $this->event->where('url', $url)->first()) {
            return redirect()->back();
        }
        return view('admin.pages.events.show', compact('event'));
    }

    public function edit(string $url)
    {
        if (!$event = $this->event->where('url', $url)->first()) {
            return redirect()->route('events.index');
        }

        $categories = $this->category->latest()->get();

        return view('admin.pages.events.edit', compact('event', 'categories'));
    }

    public function update(StoreUpdateEvent $request, string $id)
    {
        if (!$event = $this->event->find($id)) {
            return redirect()->back();
        }

        if ($event->user_id !== auth()->id() && !auth()->user()->isAdmin()) {
            return redirect()->route('events.index')
                ->with('error', 'Você não tem permissão para atualizar este evento.');
        }

        // Obtém o número atual de inscrições
        $currentRegistrationsCount = $event->registrations()->count();
        // Obtém a nova capacidade proposta
        $newCapacity = $request['capacity'];
        // Verifica se a capacidade está sendo diminuída
        if ($newCapacity < $currentRegistrationsCount) {
            return redirect()
                ->back()
                ->with('error', 'A nova capacidade não pode ser menor que a quantidade de inscritos (' . $currentRegistrationsCount . ').');
        }

        $event->update($request->all());

        return redirect()->route('events.index')
            ->with('success', 'Atualizado com sucesso.');
    }

    public function destroy(string $id)
    {
        if (!$event = $this->event->find($id)) {
            return redirect()->back();
        }

        if ($event->user_id !== auth()->id() && !auth()->user()->isAdmin()) {
            return redirect()->route('events.index')
                ->with('error', 'Você não tem permissão para excluir este evento.');
        }

        $event->delete();

        return redirect()->route('events.index')
            ->with('success', 'Excluído com sucesso.');
    }

    public function search(Request $request)
    {
        $filters = $request->only('filter');
        $events =  $this->event->searchEvents($filters['filter'] ?? '');

        return view('admin.pages.events.index', compact('events', 'filters'));
    }
}
