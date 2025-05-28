<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassSchedule extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'day_of_week',
        'start_time',
        'end_time',
        'academy_id',
        'class_id',
    ];

    protected function casts()
    {
        return [
            // 'date' => 'date',
            // 'time' => 'time',
        ];
    }
}
