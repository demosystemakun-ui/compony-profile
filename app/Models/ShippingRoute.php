<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippingRoute extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'country',
        'region',
        'category',
        'latitude',
        'longitude',
        'color',
        'flag',
        'description',
        'transit_days',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'latitude' => 'float',
        'longitude' => 'float',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }
}