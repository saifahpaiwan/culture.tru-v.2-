<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pages extends Model
{
    use HasFactory;
    protected $fillable = [ 
        'page_title',
        'page_intro',
        'page_file_text',
        'page_date',
        'page_slug', 
        'page_image_desktop',
        'page_status',   
        'file_pdf',

        'page_meta_title',
        'page_meta_description',
        'page_meta_keyword',
        
        'created_at',
        'deleted_at',
    ];
}
