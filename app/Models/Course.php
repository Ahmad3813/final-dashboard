<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Course extends Model
{
   protected $fillable = ['name'];
    public function students(): BelongsToMany
    {
        return $this->belongsToMany(Student::class);
    }
    public function classrooms(): BelongsToMany
    {
        return $this->belongsToMany(Classroom::class, 'classroom_course_teacher')
            ->withPivot('teacher_id');
    }
    public function teachers(): HasMany
{
    return $this->hasMany(Teacher::class);
}
}
