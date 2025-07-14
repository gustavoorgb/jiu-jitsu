<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Enums\BeltsEnum;
use App\Enums\RolesEnum;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'belt',
        'is_active',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'int',
            'belt' => BeltsEnum::class,
        ];
    }

    // public function academies() {
    //     return $this->hasManyThrough(Academy::class, UserRole::class, 'user_id', 'id', 'id', 'academy_id');
    // }

    public function academies(): belongsToMany
    {
        return $this->belongsToMany(Academy::class, 'user_roles');
    }

    public function userRoles(): HasMany
    {
        return $this->hasMany(UserRole::class);
    }

    public function lessons(): BelongsToMany
    {
        return $this->belongsToMany(Lesson::class, 'class_users', 'user_id', 'lesson_id')
            ->withPivot('is_instructor')
            ->using(ClassUser::class);

    }

    public static function getUsersStudents(): Collection
    {
        return self::whereHas('userRoles', function ($query) {
            $query->where('role', RolesEnum::STUDENT->value);
        })
            ->get();

    }
}
