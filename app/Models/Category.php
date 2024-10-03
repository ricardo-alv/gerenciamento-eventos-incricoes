<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'url', 'description'];

    public function events()
    {
        return $this->hasMany(Event::class); 
    }

    public function searchCategory($filter = null)
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
