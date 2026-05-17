<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserActivity extends Model
{
    protected $fillable = [
        'device_id',
        'content_id',
        'category_id',
        'action',
        'duration_seconds',
        'completion_percent',
        'source',
    ];

    public function content()
    {
        return $this->belongsTo(Content::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
