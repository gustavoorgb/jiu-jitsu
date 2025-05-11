<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model {
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'city',
        'state_id'
    ];

    public function state() {
        return $this->belongsTo(State::class);
    }

    public function academyAddresses() {
        return $this->hasMany(AcademyAddress::class);
    }
}
