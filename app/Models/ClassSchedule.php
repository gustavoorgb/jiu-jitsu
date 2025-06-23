<?php

namespace App\Models;

use App\Enums\DayOfWeekEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ClassSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'day_of_week',
        'start_time',
        'end_time',
        'academy_id',
        'lesson_id',
    ];

    protected function casts()
    {
        return [
            'day_of_week' => DayOfWeekEnum::class,
        ];
    }

    public function lesson(): BelongsTo
    {
        return $this->belongsTo(Lesson::class);
    }

    public function attendances(): HasMany
    {
        return $this->hasMany(ClassAttendance::class, 'class_schedule_id');
    }

    public function formatDay()
    {
        return $this->day_of_week->label();
    }
}
