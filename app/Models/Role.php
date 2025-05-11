<?php

namespace App\Models;

use App\Enums\Roles;
use Illuminate\Database\Eloquent\Model;

class Role extends Model {
    protected $fillable = [
        'role'
    ];

    protected $casts = [
        'role' => Roles::class,
    ];

    public function userRoles() {
        return $this->hasMany(UserRole::class);
    }
}
