<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ClassAttendance extends Pivot
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'class_schedule_id',
        'attendance_date',
    ];

    public function classUser(): BelongsTo
    {
        return $this->belongsTo(ClassUser::class);
    }

    public function classSchedule(): BelongsTo
    {
        return $this->belongsTo(ClassSchedule::class);
    }
}
