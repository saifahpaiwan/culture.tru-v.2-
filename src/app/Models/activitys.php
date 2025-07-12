<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class activitys extends Model
{
    use HasFactory;
    protected $fillable = [ 
        'activity_title',
        'activity_intro',
        'activity_file_text',
        'activity_date',
        'activity_year',
        'activity_slug', 
        'activity_image_desktop',
        'activity_status',   
        'file_pdf',
        'count_view',

        'activity_meta_title',
        'activity_meta_description',
        'activity_meta_keyword',
        
        'created_at',
        'deleted_at',
    ];
}
