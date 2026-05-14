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
        'destination_id',
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

    public function destination(): BelongsTo
    {
        return $this->belongsTo(Destination::class);
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
            'type' => 'per_person',
            'categories' => [
                ['category' => 'adult', 'label' => 'Adult', 'price' => null, 'sale_price' => null, 'min_qty' => 1],
            ],
        ];
    }

    public function getPricingCategoriesAttribute(): array
    {
        $raw = $this->pricing;
        if (is_array($raw) && isset($raw['type'])) {
            return $raw['categories'] ?? [];
        }
        if (is_array($raw) && isset($raw[0])) {
            return collect($raw)->map(fn($item) => [
                'category' => $item['category'] ?? '',
                'label' => $item['label'] ?? '',
                'price' => $item['price'] ?? null,
                'sale_price' => $item['sale_price'] ?? null,
                'min_qty' => $item['min_qty'] ?? 0,
            ])->values()->toArray();
        }
        return [];
    }

    public function getPricingTypeAttribute(): string
    {
        $raw = $this->pricing;
        if (is_array($raw) && isset($raw['type'])) {
            return $raw['type'];
        }
        return 'per_person';
    }

    public function getStartingPriceAttribute(): ?float
    {
        $prices = collect($this->pricing_categories)
            ->pluck('sale_price')
            ->merge(collect($this->pricing_categories)->pluck('price'))
            ->filter(fn($v) => !is_null($v) && $v > 0)
            ->sort()
            ->values();

        return $prices->first();
    }

    public function getRatingAttribute(): float
    {
        return 5.0;
    }

    public function getReviewCountAttribute(): int
    {
        return $this->orderItems()->count() ?: 0;
    }
}
