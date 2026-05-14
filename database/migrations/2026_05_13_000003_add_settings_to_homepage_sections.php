<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('homepage_sections', function (Blueprint $table) {
            $table->json('settings')->nullable()->after('sort_order');
        });

        DB::table('homepage_sections')->where('key', 'hero')->update([
            'settings' => json_encode([
                'slides' => [
                    [
                        'image' => 'https://images.unsplash.com/photo-1564507004663-b6dfb3c824d5?w=1920',
                        'title' => 'Discover Niagara Falls',
                        'description' => 'Experience the majesty of Niagara Falls with our expertly curated tours.',
                        'link_type' => 'tours',
                        'link_value' => null,
                    ],
                ],
            ]),
        ]);

        DB::table('homepage_sections')->where('key', 'cta')->update([
            'settings' => json_encode([
                'title' => 'Ready for an Unforgettable Adventure?',
                'description' => 'Book your Niagara Falls tour today and create memories that will last a lifetime.',
                'button_text' => 'Start Your Adventure',
                'button_link' => '/tours',
                'background_image' => 'https://images.unsplash.com/photo-1564507004663-b6dfb3c824d5?w=1920',
            ]),
        ]);

        DB::table('homepage_sections')->where('key', 'why_choose_us')->update([
            'settings' => json_encode([
                'title' => 'Why Choose Us',
                'subtitle' => 'We make your Niagara Falls experience unforgettable',
                'features' => [
                    ['title' => 'Best Price Guarantee', 'description' => 'We match any competitor\'s price on the exact same tour package.'],
                    ['title' => 'Free Cancellation', 'description' => 'Cancel up to 48 hours before your tour for a full refund, no questions asked.'],
                    ['title' => 'Reserve Now Pay Later', 'description' => 'Secure your spot today with zero upfront payment. Pay when you arrive.'],
                    ['title' => '24/7 Customer Support', 'description' => 'Our dedicated team is available around the clock to assist you.'],
                ],
            ]),
        ]);

        DB::table('homepage_sections')->where('key', 'popular_destinations')->update([
            'settings' => json_encode([
                'title' => 'Popular Destinations',
                'subtitle' => 'Explore the most loved spots around Niagara',
                'tour_ids' => [],
            ]),
        ]);
    }

    public function down(): void
    {
        Schema::table('homepage_sections', function (Blueprint $table) {
            $table->dropColumn('settings');
        });
    }
};
