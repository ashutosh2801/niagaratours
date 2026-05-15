<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('homepage_sections')->insertOrIgnore([
            [
                'key' => 'faq',
                'title' => 'FAQ Section',
                'is_enabled' => true,
                'sort_order' => 4,
                'settings' => json_encode([
                    'badge_text' => 'All Tasting Fees Are Included!',
                    'title' => 'FREQUENTLY ASKED QUESTIONS?',
                    'faqs' => [
                        ['question' => 'Is transportation included for all tours?', 'answer' => 'Yes, all tours include complimentary pick-up and drop-off from your accommodation within the Niagara region. If guests are wondering if their location is included within our pick-up zone, we encourage them to reach out to our team for confirmation.'],
                        ['question' => 'Can we request specific attractions on our tour?', 'answer' => 'Yes, we always attempt to ensure your preferences are met. Guests can communicate their wish list when making a reservation, or can connect with our team to let us know your priorities. We will always do our best to accommodate.'],
                        ['question' => 'Which tour is best for scenic views?', 'answer' => 'Our Niagara Grand Tour is widely recognized as the most scenic experience. Located minutes from the falls, this tour offers incredible views of the surrounding gorge and vineyards.'],
                        ['question' => 'Do tours run year-round?', 'answer' => 'Yes, we operate year-round. Spring and fall offer incredible views with fewer crowds. Summer is perfect for boat cruises. Fall tours offer an opportunity to witness the harvest season.'],
                        ['question' => 'What is the difference between a public and private tour?', 'answer' => 'Both options include pickup, drop-off, a guide and all fees. Public tour groups are between 8-14 people. Private tours are exclusive to your group, offering a more curated and flexible experience.'],
                        ['question' => 'Are tasting fees included in wine tours?', 'answer' => 'Yes, all tasting fees are included in the price of our wine tours. Everything is included so you can focus on enjoying your experience.'],
                    ],
                ]),
            ],
            [
                'key' => 'reviews',
                'title' => 'Reviews Section',
                'is_enabled' => true,
                'sort_order' => 6,
                'settings' => json_encode([
                    'badge' => 'WHAT PEOPLE ARE SAYING',
                    'title' => '5 Star Niagara Tours',
                    'subtitle' => '',
                ]),
            ],
            [
                'key' => 'featured_promo',
                'title' => 'Featured Promo Section',
                'is_enabled' => true,
                'sort_order' => 7,
                'settings' => json_encode([
                    'badge' => 'Now Featuring',
                    'title' => 'Elevate Your Senses',
                    'description' => 'Wine, food, adventure... it\'s all about making your senses pop. We\'ve partnered with the top Niagara producers to offer unparalleled experiences that will have you craving more!',
                    'button_text' => 'Learn More',
                    'button_link' => '/tours',
                    'background_image' => 'https://images.unsplash.com/photo-1564507004663-b6dfb3c824d5?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80',
                ]),
            ],
            [
                'key' => 'blog',
                'title' => 'Blog Section',
                'is_enabled' => true,
                'sort_order' => 8,
                'settings' => json_encode([
                    'badge' => 'LATEST NEWS & TRENDS',
                    'title' => 'From Our Blog',
                    'view_all_link' => '#',
                ]),
            ],
        ]);
    }

    public function down(): void
    {
        DB::table('homepage_sections')->whereIn('key', ['faq', 'reviews', 'featured_promo', 'blog'])->delete();
    }
};
