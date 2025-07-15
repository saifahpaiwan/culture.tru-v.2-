<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class satisfaction extends Model
{
    use HasFactory;
    protected $table = 'satisfaction';
    protected $fillable = [ 
        'id',
        'value',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}
