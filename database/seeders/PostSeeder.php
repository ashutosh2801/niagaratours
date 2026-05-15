<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    public function run(): void
    {
        $posts = [
            [
                'title' => 'Best Time to Visit Niagara Falls: A Seasonal Guide',
                'slug' => 'best-time-to-visit-niagara-falls',
                'excerpt' => 'Planning your trip to Niagara Falls? Discover the best seasons, weather patterns, and crowd levels to make your visit unforgettable.',
                'author' => 'Tour Guide Team',
                'is_active' => true,
                'is_featured' => true,
                'published_at' => now()->subDays(5),
            ],
            [
                'title' => 'Top 10 Things to Do in Niagara Falls Beyond the Falls',
                'slug' => 'top-10-things-to-do-niagara-falls',
                'excerpt' => 'While the falls are the main attraction, Niagara offers so much more. From wine tasting to adventure parks, explore our top picks.',
                'author' => 'Tour Guide Team',
                'is_active' => true,
                'is_featured' => true,
                'published_at' => now()->subDays(12),
            ],
            [
                'title' => 'Niagara Wine Tour: A Complete Guide to the Best Wineries',
                'slug' => 'niagara-wine-tour-guide',
                'excerpt' => 'Explore Niagara\'s award-winning wine region with our comprehensive guide to the best wineries, tasting rooms, and wine tours.',
                'author' => 'Tour Guide Team',
                'is_active' => true,
                'is_featured' => true,
                'published_at' => now()->subDays(20),
            ],
        ];

        foreach ($posts as $post) {
            Post::create($post);
        }
    }
}
