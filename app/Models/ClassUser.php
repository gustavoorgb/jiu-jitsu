<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassUser extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'class_id',
        'is_instructor',
    ];

    protected function casts()
    {
        return [
            'is_instructor' => 'int',
        ];
    }
}
