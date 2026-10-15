<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Classroom extends Model
{
    protected $fillable = ['name', 'capacity', 'class_year'];
    public function students(): HasMany
    {
        return $this->hasMany(Student::class);
    }
    public function courses() : BelongsToMany
    {
        return $this->belongsToMany(Course::class, 'classroom_course_teacher')
        ->withPivot('teacher_id');
    }
    
}
