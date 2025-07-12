<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class contact extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'title',   
        'description', 
        'file_text',
        'image_desktop', 
        'file_pdf', 
        'meta_title', 
        'meta_description', 
        'meta_keyword',

        'deleted_at',
    ]; 
}
