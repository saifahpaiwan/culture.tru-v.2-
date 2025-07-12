<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class activity_gallerys extends Model
{
    use HasFactory;
    protected $fillable = [ 
        'id',
        'activity_id',
        'image_desktop',  
        
        'created_at',
        'deleted_at',
    ];
}
