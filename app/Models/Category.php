<?php

namespace App\Models;

use App\Traits\HasChildren;
use App\Traits\IsOrderable;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasChildren, IsOrderable;

    protected $guarded = [];

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id', 'id');
    }
}
