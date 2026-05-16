<?php

namespace Database\Seeders;

use App\Models\HomepageSection;
use Illuminate\Database\Seeder;

class HomepageSectionSeeder extends Seeder
{
    public function run(): void
    {
        HomepageSection::create([
            'key' => 'hero',
            'title' => 'Hero Slider',
            'is_enabled' => true,
            'sort_order' => 1,
            'settings' => [
                'slides' => [
                    [
                        'image' => 'https://images.unsplash.com/photo-1564507004663-b6dfb3c824d5?w=1920',
                        'title' => 'Discover Niagara Falls & Beyond',
                        'description' => 'Experience the majesty of Niagara Falls with our expertly curated tours.',
                        'link_type' => 'tours',
                        'link_value' => null,
                    ],
                    [
                        'image' => 'https://images.unsplash.com/photo-1536844384178-2bb103f0d57d?w=1920',
                        'title' => 'Boat Cruises & Adventures',
                        'description' => 'Get up close to the thundering waters on our signature boat tours.',
                        'link_type' => 'tour',
                        'link_value' => 'niagara-falls-adventure-tour',
                    ],
                    [
                        'image' => 'https://images.unsplash.com/photo-1544551763-46a013bb70d5?w=1920',
                        'title' => 'Sunset Dinner Experiences',
                        'description' => 'Romantic evening cruises with breathtaking sunset views.',
                        'link_type' => 'tour',
                        'link_value' => 'sunset-dinner-cruise',
                    ],
                ],
            ],
        ]);

        HomepageSection::create([
            'key' => 'why_choose_us',
            'title' => 'Why Choose Us',
            'is_enabled' => true,
            'sort_order' => 2,
            'settings' => [
                'title' => 'Why Choose Us',
                'subtitle' => 'We make your Niagara Falls experience unforgettable',
                'features' => [
                    ['title' => 'Best Price Guarantee', 'description' => 'We match any competitor\'s price on the exact same tour package.'],
                    ['title' => 'Free Cancellation', 'description' => 'Cancel up to 48 hours before your tour for a full refund, no questions asked.'],
                    ['title' => 'Reserve Now Pay Later', 'description' => 'Secure your spot today with zero upfront payment. Pay when you arrive.'],
                    ['title' => '24/7 Customer Support', 'description' => 'Our dedicated team is available around the clock to assist you.'],
                ],
            ],
        ]);

        HomepageSection::create([
            'key' => 'cta',
            'title' => 'Call to Action',
            'is_enabled' => true,
            'sort_order' => 3,
            'settings' => [
                'title' => 'Ready for an Unforgettable Adventure?',
                'description' => 'Book your Niagara Falls tour today and create memories that will last a lifetime.',
                'button_text' => 'Start Your Adventure',
                'button_link' => '/tours',
                'background_image' => 'https://images.unsplash.com/photo-1564507004663-b6dfb3c824d5?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80',
            ],
        ]);

        HomepageSection::create([
            'key' => 'popular_destinations',
            'title' => 'Popular Destinations',
            'is_enabled' => true,
            'sort_order' => 4,
            'settings' => [
                'title' => 'Popular Destinations',
                'subtitle' => 'Explore the most loved spots around Niagara',
                'tour_ids' => [],
            ],
        ]);

        HomepageSection::create([
            'key' => 'popular_tours',
            'title' => 'Popular Tours',
            'is_enabled' => true,
            'sort_order' => 5,
            'settings' => [
                'title' => 'Popular Tours',
                'subtitle' => 'Check out our most popular tours',
                'tour_ids' => [1, 2, 3],
            ],
        ]);

        HomepageSection::create([
            'key' => 'browse_categories',
            'title' => 'Browse by Category',
            'is_enabled' => true,
            'sort_order' => 6,
            'settings' => [
                'title' => 'Browse by Category',
                'subtitle' => 'Find the perfect tour for your style',
            ],
        ]);

        HomepageSection::create([
            'key' => 'faq',
            'title' => 'FAQ Section',
            'is_enabled' => true,
            'sort_order' => 4,
            'settings' => [
                'badge_text' => 'All Tasting Fees Are Included!',
                'title' => 'FREQUENTLY ASKED QUESTIONS?',
                'faqs' => [
                    ['question' => 'Is transportation included for all tours?', 'answer' => 'Yes, all tours include complimentary pick-up and drop-off from your accommodation within the Niagara region.'],
                    ['question' => 'Can we request specific attractions on our tour?', 'answer' => 'Yes, we always attempt to ensure your preferences are met. Guests can communicate their wish list when making a reservation.'],
                    ['question' => 'Which tour is best for scenic views?', 'answer' => 'Our Niagara Grand Tour is widely recognized as the most scenic experience. Located minutes from the falls, this tour offers incredible views of the surrounding gorge and vineyards.'],
                    ['question' => 'Do tours run year-round?', 'answer' => 'Yes, we operate year-round. Spring and fall offer incredible views with fewer crowds. Summer is perfect for boat cruises.'],
                    ['question' => 'What is the difference between a public and private tour?', 'answer' => 'Both options include pickup, drop-off, a guide and all fees. Public tour groups are between 8-14 people. Private tours are exclusive to your group.'],
                    ['question' => 'Are tasting fees included in wine tours?', 'answer' => 'Yes, all tasting fees are included in the price of our wine tours. Everything is included so you can focus on enjoying your experience.'],
                ],
            ],
        ]);

        HomepageSection::create([
            'key' => 'reviews',
            'title' => 'Reviews Section',
            'is_enabled' => true,
            'sort_order' => 6,
            'settings' => [
                'badge' => 'WHAT PEOPLE ARE SAYING',
                'title' => '5 Star Niagara Tours',
                'subtitle' => '',
            ],
        ]);

        HomepageSection::create([
            'key' => 'featured_promo',
            'title' => 'Featured Promo Section',
            'is_enabled' => true,
            'sort_order' => 7,
            'settings' => [
                'badge' => 'Now Featuring',
                'title' => 'Elevate Your Senses',
                'description' => 'Wine, food, adventure... it\'s all about making your senses pop. We\'ve partnered with the top Niagara producers to offer unparalleled experiences that will have you craving more!',
                'button_text' => 'Learn More',
                'button_link' => '/tours',
                'background_image' => 'https://images.unsplash.com/photo-1564507004663-b6dfb3c824d5?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80',
            ],
        ]);

        HomepageSection::create([
            'key' => 'blog',
            'title' => 'Blog Section',
            'is_enabled' => true,
            'sort_order' => 8,
            'settings' => [
                'badge' => 'LATEST NEWS & TRENDS',
                'title' => 'From Our Blog',
                'view_all_link' => '#',
            ],
        ]);
    }
}
