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
        'updated_by',
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    public function updatedBy()
    {
        return $this->belongsTo(\App\Models\User::class, 'updated_by');
    }

    /**
     * URL gambar lewat route Laravel (stream dari Supabase).
     * ?v= membuat cache browser ikut ter-refresh saat gambar diganti.
     */
    public function getImageUrlAttribute(): ?string
    {
        return $this->image
            ? route('news.image', $this) . '?v=' . $this->updated_at?->timestamp
            : null;
    }
}