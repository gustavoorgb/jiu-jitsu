<?php

namespace App\Models;

use App\Enums\BeltsEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lesson extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'academy_id',
        'min_belt',
    ];

    protected function casts()
    {
        return [
            'min_belt' => BeltsEnum::class,
        ];
    }

    public function academy(): BelongsTo
    {
        return $this->belongsTo(Academy::class);
    }

    public function schedules(): HasMany
    {
        return $this->hasMany(ClassSchedule::class);
    }

    public function classUsers(): HasMany
    {
        return $this->hasMany(ClassUser::class);
    }
}
