<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'url', 'description', 'location', 'start_date', 'end_date', 'capacity', 'category_id', 'user_id'];

    public function searchEvent($filter = null)
    {
        return  $this->where(function ($query) use ($filter) {
            if ($filter) {
                $query->where('name', 'LIKE',  "%$filter%");
                $query->orWhere('description', $filter);
            }
        })
            ->paginate();
    }
}
