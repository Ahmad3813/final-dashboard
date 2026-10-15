<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;



class Teacher extends Model
{
    protected $fillable = ['user_id', 'name', 'course_id'];
    public function classrooms(): BelongsToMany
    {
        return $this->belongsToMany(Classroom::class, 'classroom_course_teacher')
            ->withPivot('course_id');
    }
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
