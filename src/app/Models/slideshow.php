<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class slideshow extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'title',   
        'description', 
        'link',
        'image_desktop', 
        'deleted_at',
    ];
}
