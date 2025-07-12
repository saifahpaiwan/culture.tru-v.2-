<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class learning_gallerys extends Model
{
    use HasFactory;
    protected $fillable = [ 
        'id',
        'learning_id',
        'image_desktop',  
        
        'created_at',
        'deleted_at',
    ];
}
