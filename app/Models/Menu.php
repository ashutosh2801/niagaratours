<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Menu extends Model
{
    protected $fillable = [
        'label',
        'url',
        'route',
        'parent_id',
        'sort_order',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    public function children(): HasMany
    {
        return $this->hasMany(Menu::class, 'parent_id')->orderBy('sort_order');
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Menu::class, 'parent_id');
    }

    public function getUrlAttribute($value)
    {
        if ($this->route) {
            try {
                return route($this->route);
            } catch (\Exception $e) {
                return '#';
            }
        }
        return $value ?: '#';
    }

    public static function getActive(): \Illuminate\Support\Collection
    {
        return static::where('is_active', true)
            ->whereNull('parent_id')
            ->orderBy('sort_order')
            ->with('children')
            ->get();
    }
}
