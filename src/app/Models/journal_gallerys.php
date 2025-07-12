<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class journal_gallerys extends Model
{
    use HasFactory;
    protected $fillable = [ 
        'id',
        'journal_id',
        'image_desktop',  
        
        'created_at',
        'deleted_at',
    ];
}
