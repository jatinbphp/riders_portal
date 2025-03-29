<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Uploads extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'type',
        'path',
    ];

    const TYPE_IMAGE = 1;
    const TYPE_VIDEO = 2;
    
    const TYPE_IMAGE_TEXT = "Image";
    const TYPE_VIDEO_TEXT = "Video";

    const uploadType  = [
        self::TYPE_IMAGE => self::TYPE_IMAGE_TEXT,
        self::TYPE_VIDEO => self::TYPE_VIDEO_TEXT,
    ];
}
