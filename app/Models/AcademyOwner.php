<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class academyOwner extends Model {
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'academy_id'
    ];

    public function academy() {
        return $this->hasOne(Academy::class);
    }

    public function owner() {
        return $this->hasOne(User::class);
    }
}
