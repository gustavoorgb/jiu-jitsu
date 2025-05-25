<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Enums\BeltsEnum;
use App\Enums\RolesEnum;
use App\Enums\UserStatusEnum;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class User extends Authenticatable implements FilamentUser {
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
        'is_active'
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
    protected function casts(): array {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => UserStatusEnum::class,
            'belt' => BeltsEnum::class
        ];
    }

    public function academies(): BelongsToMany {
        return $this->belongsToMany(Academy::class, 'academy_owners');
    }

    public function roles(): BelongsToMany{
        return $this->belongsToMany(Role::class, 'user_roles');
    }

    public function hasRole(RolesEnum $role): bool {
        return $this->roles->contains('role', $role);
    }

    public function canAccessPanel(Panel $panel): bool{
       return match($panel->getId()){
            'admin' => $this->hasRole(RolesEnum::ADMIN),
            'instrutor' => $this->hasRole(RolesEnum::INSTRUCTOR),
            'aluno' => $this->hasRole(RolesEnum::STUDENT),
            'default' => false,
        };
    }

}
