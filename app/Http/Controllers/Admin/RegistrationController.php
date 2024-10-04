<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Event;
use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    public function __construct(
        private Event $event,
        private Category $category

    ) {}

    public function index()
    {
        $events = $this->event->whereHas('registrations', function ($query) {
            $query->where('user_id', auth()->id());
        })
            ->withCount('registrations')
            ->with('category')
            ->latest()
            ->paginate();
        return view('admin.pages.registrations.index', compact('events'));
    }

    public function show(string $url)
    {
        if (!$event = $this->event->where('url', $url)->first()) {
            return redirect()->back();
        }
        return view('admin.pages.registrations.show', compact('event'));
    }
   
    public function search(Request $request)
    {
        $filter = $request['filter'];
        $events =  $this->event->searchEventsById($filter);

        return view('admin.pages.registrations.index', compact('events'));
    }
}
