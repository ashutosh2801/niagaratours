<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Update sort orders for existing sections to make room
        DB::table('homepage_sections')->where('key', 'why_choose_us')->update(['sort_order' => 6]);
        DB::table('homepage_sections')->where('key', 'cta')->update(['sort_order' => 11]);
        DB::table('homepage_sections')->where('key', 'popular_destinations')->update(['sort_order' => 12]);
        DB::table('homepage_sections')->where('key', 'faq')->update(['sort_order' => 8]);
        DB::table('homepage_sections')->where('key', 'popular_tours')->update(['sort_order' => 2]);
        DB::table('homepage_sections')->where('key', 'browse_categories')->update(['sort_order' => 13]);
        DB::table('homepage_sections')->where('key', 'reviews')->update(['sort_order' => 7]);
        DB::table('homepage_sections')->where('key', 'featured_promo')->update(['sort_order' => 9]);
        DB::table('homepage_sections')->where('key', 'blog')->update(['sort_order' => 10]);

        // Insert new section types
        DB::table('homepage_sections')->insertOrIgnore([
            [
                'key' => 'features',
                'title' => 'Features (Icon Grid)',
                'is_enabled' => true,
                'sort_order' => 3,
                'settings' => json_encode([
                    'title' => 'Why Choose Niagara Tours',
                    'subtitle' => 'Experience the best with our premium services',
                    'features' => [
                        ['icon' => 'images/icons/icon-1.png', 'title' => 'Discover the possibilities', 'description' => 'With nearly half a million attractions, hotels & more, you\'re sure to find joy.'],
                        ['icon' => 'images/icons/icon-2.png', 'title' => 'Enjoy deals & delights', 'description' => 'Quality activities. Great prices. Plus, earn credits to save more.'],
                        ['icon' => 'images/icons/icon-3.png', 'title' => 'Exploring made easy', 'description' => 'Book last minute, skip lines & get free cancellation for easier exploring.'],
                        ['icon' => 'images/icons/icon-4.png', 'title' => 'Travel you can trust', 'description' => 'Read reviews & get reliable customer support. We\'re with you at every step.'],
                    ],
                ]),
            ],
            [
                'key' => 'destinations',
                'title' => 'Destinations Slider',
                'is_enabled' => true,
                'sort_order' => 4,
                'settings' => json_encode([
                    'title' => 'Destinations Around the World',
                    'subtitle' => 'Niagaratours is a platform designed to connect fans with exclusive experiences.',
                    'destinations' => [
                        ['title' => 'India', 'image' => 'images/destinations/agra.jpg'],
                        ['title' => 'New York', 'image' => 'images/destinations/new-york.jpg'],
                        ['title' => 'Houston', 'image' => 'images/destinations/houston.jpg'],
                        ['title' => 'Ottawa', 'image' => 'images/destinations/ottawa.jpg'],
                        ['title' => 'Toronto', 'image' => 'images/destinations/toronto.jpg'],
                    ],
                ]),
            ],
            [
                'key' => 'policies',
                'title' => 'Policies / Guarantees',
                'is_enabled' => true,
                'sort_order' => 5,
                'settings' => json_encode([
                    'items' => [
                        [
                            'image' => 'images/banners/home-banner-1.jpg',
                            'badge' => 'Premium Benefits',
                            'title' => 'Flexible Booking',
                            'description' => 'Reserve elite experiences now and pay later with complete freedom to plan your journey your way.',
                            'overlay_from' => '#0ad6c7',
                            'overlay_to' => '#0c8d89',
                        ],
                        [
                            'image' => 'images/banners/home-banner-2.jpg',
                            'badge' => 'Worry Free',
                            'title' => 'Free Cancellation',
                            'description' => 'Receive a complete refund when cancelling eligible experiences at least 24 hours before departure.',
                            'overlay_from' => '#2b175c',
                            'overlay_to' => '#122e79',
                        ],
                    ],
                ]),
            ],
        ]);
    }

    public function down(): void
    {
        DB::table('homepage_sections')->whereIn('key', ['features', 'destinations', 'policies'])->delete();

        // Restore original sort orders
        DB::table('homepage_sections')->where('key', 'why_choose_us')->update(['sort_order' => 2]);
        DB::table('homepage_sections')->where('key', 'cta')->update(['sort_order' => 3]);
        DB::table('homepage_sections')->where('key', 'popular_destinations')->update(['sort_order' => 4]);
        DB::table('homepage_sections')->where('key', 'faq')->update(['sort_order' => 4]);
        DB::table('homepage_sections')->where('key', 'popular_tours')->update(['sort_order' => 5]);
        DB::table('homepage_sections')->where('key', 'browse_categories')->update(['sort_order' => 6]);
        DB::table('homepage_sections')->where('key', 'reviews')->update(['sort_order' => 6]);
        DB::table('homepage_sections')->where('key', 'featured_promo')->update(['sort_order' => 7]);
        DB::table('homepage_sections')->where('key', 'blog')->update(['sort_order' => 8]);
    }
};
