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

    public function searchEvents($filter = null)
    {
        return  $this->where(function ($query) use ($filter) {
            if ($filter) {
                $query->where('name', 'LIKE',  "%$filter%");
                $query->orWhere('description', $filter);
            }
        })->latest()
            ->paginate();
    }

    public function searchEventsById($filter = null)
    {
        return $this->whereHas('registrations', function ($query) use ($filter) {

            $query->where('user_id', auth()->id());

            if ($filter) {
                $query->where('name', 'LIKE',  "%$filter%");
                $query->orWhere('description', $filter);
            }
        })
            ->withCount('registrations')
            ->with('category')
            ->latest()
            ->paginate();
    }

    public function filterEventsDashboard(array $filters)
    {
        return $this->with(['category', 'registrations' => function ($query) {
            $query->where('user_id', auth()->id());
        }])
            ->withCount('registrations')
            ->where(function ($query) use ($filters) {
                if (!empty($filters['category'])) {
                    $query->where('category_id', $filters['category']);
                }

                if (!empty($filters['start_date']) && !empty($filters['end_date'])) {
                    $query->whereDate('start_date', '>=', $filters['start_date'])
                        ->whereDate('start_date', '<=', $filters['end_date']);
                } elseif (!empty($filters['start_date'])) {
                    $query->whereDate('start_date', '=', $filters['start_date']);
                }
            })->latest()->paginate();
    }
}
