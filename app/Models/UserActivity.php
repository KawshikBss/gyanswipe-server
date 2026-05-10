<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserActivity extends Model
{
    protected $fillable = [
        'device_id',
        'content_id',
        'action',
    ];

    public function content()
    {
        return $this->belongsTo(Content::class);
    }
}
