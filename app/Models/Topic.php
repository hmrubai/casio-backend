<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    use HasFactory;

    protected $fillable = [
        "title",
        "title_bn",
        "description",
        "description_bn",
        "class_id",
        "chapter_id",
        "created_by",
        "author_name",
        "author_details",
        "raw_url",
        "s3_url",
        "youtube_url",
        "download_url",
        "thumbnail",
        "duration",
        "rating",
        "sequence",
        "is_active"
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];
}
