<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Post extends Model
{
    protected $fillable = [
        'title', 'slug', 'excerpt', 'content', 'featured_image',
        'author', 'is_active', 'is_featured', 'published_at',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
            'published_at' => 'datetime',
        ];
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopePublished($query)
    {
        return $query->whereNotNull('published_at')->where('published_at', '<=', now());
    }

    protected static function booted(): void
    {
        static::creating(function (Post $post) {
            if (empty($post->slug)) {
                $post->slug = Str::slug($post->title);
            }
        });
    }

    public function getExcerptHtmlAttribute(): string
    {
        return $this->excerpt ?: Str::limit(strip_tags($this->content ?? ''), 160);
    }

    public function getDateFormattedAttribute(): string
    {
        return $this->published_at?->format('M / Y') ?? $this->created_at->format('M / Y');
    }
}
