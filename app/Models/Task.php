<?php

namespace App\Models;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
    'name',
    'duration_hours',
    'assigned_to',
    'added_by',
    'comment',
];
public function assignee(): BelongsTo
{
    return $this->belongsTo(User::class, 'assigned_to');
}
public function addedBy(): BelongsTo
{
    return $this->belongsTo(User::class, 'added_by');
}
}
