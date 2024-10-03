<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'url', 'description', 'location', 'start_date', 'end_date', 'capacity', 'category_id', 'user_id'];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }

    public function searchEvent($filter = null)
    {
        return  $this->where(function ($query) use ($filter) {
            if ($filter) {
                $query->where('name', 'LIKE',  "%$filter%");
                $query->orWhere('description', $filter);
            }
        })->latest()
            ->paginate();
    }
}
