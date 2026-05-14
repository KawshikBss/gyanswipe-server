<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    protected $guarded = [];
    protected $casts = [
        'body' => 'array',
    ];

    protected $appends = ['summary'];

    public function getSummaryAttribute()
    {
        // $data = json_decode($this->body, true);
        if (isset($this->body['blocks']) && is_array($this->body['blocks'])) {
            $text = '';
            foreach ($this->body['blocks'] as $block) {
                if (isset($block['type']) && $block['type'] === 'text' && isset($block['value'])) {
                    $text .= strip_tags($block['value']) . ' ';
                }
            }
            return substr(trim($text), 0, 200) . (strlen($text) > 200 ? '...' : '');
        }
        return null;
    }

    public function activities()
    {
        return $this->hasMany(UserActivity::class);
    }
}
