<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'content',
        'sections',
        'template',
        'meta_title',
        'meta_description',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'sections' => 'array',
            'is_active' => 'boolean',
        ];
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
