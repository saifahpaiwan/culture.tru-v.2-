<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class appeals extends Model
{
    use HasFactory;
    protected $fillable = [ 
        'name',
        'email',
        'topic',
        'description',
         
        'ip_address',
        'created_at',
        'deleted_at',
    ];
}
