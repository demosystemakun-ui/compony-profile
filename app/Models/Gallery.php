<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'tag',
        'date_info',
        'location',
        'description',
        'image',
        'page',
        'section',
        'sort_order',
    ];

    /**
     * URL gambar lewat route Laravel (stream dari Supabase).
     * ?v= membuat cache browser ikut ter-refresh saat gambar diganti.
     */
    public function getImageUrlAttribute(): ?string
    {
        return $this->image
            ? route('gallery.image', $this) . '?v=' . $this->updated_at?->timestamp
            : null;
    }
}