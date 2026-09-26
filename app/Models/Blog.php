<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    protected $fillable = ['short_title',
        'title',
        'short_description',
        'content',
        'image',
        'published_at',
    ];
    
}
