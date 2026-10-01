<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'category',
        'image',
        'excerpt',
        'content',
        'published_at',
        'updated_by'
    ];

    public function updatedBy()
{
    return $this->belongsTo(\App\Models\User::class, 'updated_by');
}

}