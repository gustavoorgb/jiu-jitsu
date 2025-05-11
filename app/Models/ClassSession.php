<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassSession extends Model {
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'date',
        'time',
        'academy_id'
    ];

    protected function casts() {
        return [
            'date' => 'date',
            'time' => 'time'
        ];
    }

    public function academies() {
        return $this->belongsTo(Academies::class);
    }
}
