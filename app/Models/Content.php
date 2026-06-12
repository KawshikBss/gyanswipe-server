<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    protected $guarded = [];
    protected $casts = [
        'duration_seconds' => 'float',
        'like_count' => 'integer',
        'save_count' => 'integer',
        'view_count' => 'integer',
        'rating' => 'float',
        'body' => 'array',
    ];

    protected $appends = ['summary'];

    public function getSummaryAttribute(): string
    {
        $text = collect($this->body['blocks'] ?? [])
            ->where('type', 'text')
            ->pluck('value')
            ->implode(' ');

        return mb_substr(
            $text,
            0,
            200,
            'UTF-8'
        ) . '...';
    }

    public function activities()
    {
        return $this->hasMany(UserActivity::class);
    }

    public function translations()
    {
        return $this->hasMany(ContentTranslation::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
