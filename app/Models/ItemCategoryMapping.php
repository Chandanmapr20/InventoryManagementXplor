<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ItemCategoryMapping extends Model
{
    use HasFactory;
    
    public function info(): HasOne
    {
        return $this->hasOne(Category::class, 'id', 'cat_id');
    }
}