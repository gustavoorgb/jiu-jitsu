<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRole extends Model {
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'role_id',
        'user_id',
        'academy_id'
    ];


    public function role() {
        return $this->belongsTo(Role::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function academy() {
        return $this->belongsTo(Academy::class);
    }
}
