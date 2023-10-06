<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QueryInformation extends Model
{
    use HasFactory;

    protected $fillable = [
        "name",
        "email",
        "phone",
        "title",
        "description",
        "is_active"
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];
}
