<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class book_gallerys extends Model
{
    use HasFactory;
    protected $fillable = [ 
        'id',
        'research_id',
        'image_desktop',  
        
        'created_at',
        'deleted_at',
    ];
}
