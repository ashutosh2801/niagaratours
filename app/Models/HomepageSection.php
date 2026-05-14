<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomepageSection extends Model
{
    protected $fillable = [
        'key',
        'title',
        'is_enabled',
        'sort_order',
        'settings',
    ];

    protected function casts(): array
    {
        return [
            'is_enabled' => 'boolean',
            'sort_order' => 'integer',
            'settings' => 'array',
        ];
    }

    public static function isEnabled(string $key): bool
    {
        return static::where('key', $key)->where('is_enabled', true)->exists();
    }

    public static function getSettings(string $key): ?array
    {
        $section = static::where('key', $key)->where('is_enabled', true)->first();
        return $section?->settings;
    }
}
