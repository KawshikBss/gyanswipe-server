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

    function cleanUtf8($data)
    {
        if (is_array($data)) {
            return array_map('cleanUtf8', $data);
        }

        if (is_string($data)) {
            return mb_convert_encoding($data, 'UTF-8', 'UTF-8, ISO-8859-1, Windows-1252');
        }

        return $data;
    }

    public function setBodyAttribute($value)
    {
        $value = $this->cleanUtf8($value);
        $this->attributes['body'] = json_encode($value);
    }
}
