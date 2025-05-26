<?php

namespace App\Models;

use App\Enums\RolesEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Role extends Model {

    public $timestamps = false;

    protected $fillable = [
        'role'
    ];

    protected $casts = [
        'role' => RolesEnum::class,
    ];

    public function userRoles(): HasMany {
        return $this->hasMany(UserRole::class);
    }

    public function getRoleLabelAttribute(): string {
        return $this->role->label();
    }
}
