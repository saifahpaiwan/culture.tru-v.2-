<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class menu_mg extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'list',  
        
        'deleted_at',
    ]; 
}
