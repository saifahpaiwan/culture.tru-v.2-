<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class related_sites extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'title',
        'slug',
        'image_desktop',

        'created_at',
        'deleted_at',
    ];
}
