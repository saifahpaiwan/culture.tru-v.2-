<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class learning extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'author',
        'type',
        'keyword',
        'year',
        'published',
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
 
    public function rLearningTypes(): BelongsTo
    {
        return $this->belongsTo(learning_types::class, 'type');
    }
}
