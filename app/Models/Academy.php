<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Academy extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'confederation',
        'description',
        'parent_academy_id',
    ];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Academy::class, 'parent_academy_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Academy::class, 'parent_academy_id');
    }

    public function address(): HasOne
    {

        return $this->hasOne(AcademyAddress::class, 'academy_id');
    }

    public function classes(): HasMany
    {
        return $this->hasMany(JiuJitsuClass::class);
    }

    public function userRoles(): HasMany
    {
        return $this->hasMany(UserRole::class);
    }

    // public function owners(): BelongsToMany
    // {
    //     return $this->belongsToMany(User::class, 'academy_owners');
    // }
}
