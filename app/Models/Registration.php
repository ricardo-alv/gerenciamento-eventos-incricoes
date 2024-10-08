<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'user_id',
        'participant_name',
        'participant_email',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class)->with('category');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
