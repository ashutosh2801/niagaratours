<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tour extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'category_id',
        'short_description',
        'description',
        'location',
        'duration',
        'duration_type',
        'price',
        'sale_price',
        'max_people',
        'pricing',
        'images',
        'featured_image',
        'highlights',
        'inclusions',
        'exclusions',
        'itinerary',
        'faqs',
        'is_featured',
        'is_active',
        'booking_type',
        'booking_url',
        'meta_title',
        'meta_description',
    ];

    protected function casts(): array
    {
        return [
            'images' => 'array',
            'highlights' => 'array',
            'inclusions' => 'array',
            'exclusions' => 'array',
            'itinerary' => 'array',
            'faqs' => 'array',
            'pricing' => 'array',
            'price' => 'decimal:2',
            'sale_price' => 'decimal:2',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
            'max_people' => 'integer',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getFormattedPriceAttribute(): string
    {
        return '$' . number_format($this->price, 2);
    }

    public function getPricingDefaultsAttribute(): array
    {
        return [
            ['category' => 'adult', 'label' => 'Adult', 'price' => null, 'sale_price' => null],
            ['category' => 'senior', 'label' => 'Senior', 'price' => null, 'sale_price' => null],
            ['category' => 'child', 'label' => 'Child', 'price' => null, 'sale_price' => null],
            ['category' => 'infant', 'label' => 'Infant', 'price' => null, 'sale_price' => null],
            ['category' => 'group', 'label' => 'Group Tour', 'price' => null, 'sale_price' => null],
        ];
    }

    public function getStartingPriceAttribute(): ?float
    {
        $prices = collect($this->pricing ?? $this->pricingDefaults)
            ->pluck('sale_price')
            ->merge(collect($this->pricing ?? $this->pricingDefaults)->pluck('price'))
            ->filter(fn($v) => !is_null($v) && $v > 0)
            ->sort()
            ->values();

        return $prices->first();
    }
}
