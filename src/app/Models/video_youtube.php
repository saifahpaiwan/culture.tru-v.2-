<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class video_youtube extends Model
{
    use HasFactory;
    protected $table = 'video_youtube';
    protected $fillable = [ 
        'id',
        'link', 
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}
