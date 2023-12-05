<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chapter extends Model
{
    use HasFactory;

    protected $fillable = [
        "name",
        "name_bn",
        "description",
        "description_bn",
        // "class_id",
        "created_by",
        "thumbnail",
        "is_active"
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];
}
