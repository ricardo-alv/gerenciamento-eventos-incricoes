<?php

namespace App\Observers;

use App\Models\Event;
use Illuminate\Support\Str;

class EventObserver
{
    /**
     * Handle the Event "created" event.
     */
    public function creating(Event $event): void
    {
        $event->url = Str::kebab($event->name);
        $event->user_id = auth()->user()->id;
    }

    /**
     * Handle the Event "updated" event.
     */
    public function updating(Event $event): void
    {
        $event->url = Str::kebab($event->name);
      //  $event->user_id  = auth()->user()->id;
    }
}
