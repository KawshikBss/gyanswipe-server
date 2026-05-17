<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserCategoryScore extends Model
{
    protected $fillable = [
        'device_id',
        'category_id',
        'score',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
