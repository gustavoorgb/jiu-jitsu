<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Academy extends Model {
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'confederation',
        'description'
    ];


    public function adresses() {
        return $this->hasMany(AcademyAddress::class, 'academy_id');
    }

    public function classes() {
        return $this->hasMany(ClassSession::class);
    }

    public function owner() {
        return $this->belongsToMany(AcademyOwner::class);
    }
}
