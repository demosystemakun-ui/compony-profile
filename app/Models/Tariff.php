<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Tariff extends Model
{
    protected $fillable = [
        'tag', 'title', 'description', 'icon', 'pdf_path', 'sort_order', 'is_active', 'updated_by',
    ];
    
public function updatedBy()
{
    return $this->belongsTo(\App\Models\User::class, 'updated_by');
}

    protected $casts = ['is_active' => 'boolean'];

    /** Pilihan kategori (dropdown di form admin) */
    public const TAGS = ['Domestic', 'International', 'Others'];

    /** Pilihan ikon di form admin => path SVG heroicons */
    public const ICONS = [
        'building' => 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4',
        'globe'    => 'M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
        'document' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z',
    ];

    public function iconPath(): string
    {
        return self::ICONS[$this->icon] ?? self::ICONS['document'];
    }

public function hasPdf(): bool
{
    return filled($this->pdf_path);
}

/** URL publik lewat route Laravel (stream dari Supabase). Query ?v= agar cache browser ikut ter-refresh saat file diganti. */
public function pdfUrl(): string
{
    return $this->hasPdf()
        ? route('tarif.stream', $this) . '?v=' . $this->updated_at?->timestamp
        : '#';
}

public function deletePdfFile(): void
{
    if ($this->pdf_path) {
        Storage::disk('supabase')->delete($this->pdf_path);
    }
}
