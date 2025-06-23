<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ClassUser extends Pivot
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'class_users';

    protected $fillable = [
        'user_id',
        'lesson_id',
        'is_instructor',
    ];

    protected function casts()
    {
        return [
            'is_instructor' => 'boolean',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function lesson(): BelongsTo
    {
        return $this->belongsTo(Lesson::class);
    }

    public function attendances(): HasMany
    {
        return $this->hasMany(ClassAttendance::class);
    }

    public function isInstructor(): bool
    {
        return $this->is_instructor === 1;
    }
}
