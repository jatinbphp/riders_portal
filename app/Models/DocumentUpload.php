<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentUpload extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'speed',
        'strength',
        'agility',
        'endurance',
        'flexibility',
        'document_path',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
