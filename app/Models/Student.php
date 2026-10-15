<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = ['name', 'classroom_id', 'user_id'];
    public function classroom(): BelongsTo
    {
        return $this->belongsTo(Classroom::class);
    }


    public function courses(): BelongsToMany
    {
        return $this->belongsToMany(Course::class);
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
