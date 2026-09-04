<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'category',
        'image_url',
        'description',
        'event_date',
        'is_featured',
    ];

    protected $casts = [
        'event_date'  => 'date',
        'is_featured' => 'boolean',
    ];
}
