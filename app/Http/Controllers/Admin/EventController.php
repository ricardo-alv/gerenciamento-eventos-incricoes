<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateEvent;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Event;

class EventController extends Controller
{
    private $repository, $category;

    public function __construct(Event $event, Category $category)
    {
        $this->repository = $event;
        $this->category = $category;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $events = $this->repository->latest()->paginate();
        return view('admin.pages.events.index', compact('events',));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = $this->category->latest()->get();
        return view('admin.pages.events.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUpdateEvent $request)
    {
        $this->repository->create($request->all());
        return redirect()->route('events.index')
            ->with('message', 'Criado com sucesso.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $url)
    {
        if (!$event = $this->repository->where('url', $url)->first()) {
            return redirect()->back();
        }
        return view('admin.pages.events.show', compact('event'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $url)
    {
        if (!$event = $this->repository->where('url', $url)->first()) {
            return redirect()->route('events.index');
        }

        $categories = $this->category->latest()->get();

        return view('admin.pages.events.edit', compact('event', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreUpdateEvent $request, string $id)
    {
        if (!$event = $this->repository->find($id)) {
            return redirect()->back();
        }

        $event->update($request->all());

        return redirect()->route('events.index')
            ->with('message', 'Atualizado com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (!$category = $this->repository->find($id)) {
            return redirect()->back();
        }

        $category->delete();

        return redirect()->route('events.index')
            ->with('message', 'Excluído com sucesso.');
    }

    public function search(Request $request)
    {      
         $filters = $request->only('filter');
         $events =  $this->repository->searchEvent($filters['filter'] ?? '');
         return view('admin.pages.events.index', compact('events', 'filters'));
    }
}
