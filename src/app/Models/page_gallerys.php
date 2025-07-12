<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class page_gallerys extends Model
{
    use HasFactory;
    protected $fillable = [ 
        'id',
        'page_id',
        'image_desktop',  
        
        'created_at',
        'deleted_at',
    ];
}
