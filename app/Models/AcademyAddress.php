<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AcademyAddress extends Model {
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'street',
        'cep',
        'number',
        'complement',
        'academy_id',
        'city_id'
    ];

    public function academy() {
        return $this->belongsTo(Academies::class);
    }

    public function cities() {
        return $this->belongsTo(City::class);
    }
}
