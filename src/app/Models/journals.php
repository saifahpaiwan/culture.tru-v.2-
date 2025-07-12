<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class journals extends Model
{
    use HasFactory;
    protected $fillable = [ 
        'title',
        'month', 
        'intro',
        'file_text',
        'date',
        'slug', 
        'image_desktop',
        'status',   
        'file_pdf',
        'count_view',

        'meta_title',
        'meta_description',
        'meta_keyword',
        
        'created_at',
        'deleted_at',
    ];
}
