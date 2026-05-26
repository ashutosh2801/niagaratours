<?php

namespace Database\Seeders;

use App\Models\HomepageSection;
use Illuminate\Database\Seeder;

class HomepageSectionSeeder extends Seeder
{
    public function run(): void
    {
        $sections = [
            [
                'key' => 'hero',
                'title' => 'Hero Slider',
                'is_enabled' => true,
                'sort_order' => 1,
                'settings' => [
                    'slides' => [
                        ['image' => 'https://images.unsplash.com/photo-1564507004663-b6dfb3c824d5?w=1920', 'title' => 'Discover Niagara Falls & Beyond', 'description' => 'Experience the majesty of Niagara Falls with our expertly curated tours.', 'link_type' => 'tours', 'link_value' => null],
                        ['image' => 'https://images.unsplash.com/photo-1536844384178-2bb103f0d57d?w=1920', 'title' => 'Boat Cruises & Adventures', 'description' => 'Get up close to the thundering waters on our signature boat tours.', 'link_type' => 'tour', 'link_value' => 'niagara-falls-adventure-tour'],
                        ['image' => 'https://images.unsplash.com/photo-1544551763-46a013bb70d5?w=1920', 'title' => 'Sunset Dinner Experiences', 'description' => 'Romantic evening cruises with breathtaking sunset views.', 'link_type' => 'tour', 'link_value' => 'sunset-dinner-cruise'],
                    ],
                ],
            ],
            [
                'key' => 'popular_tours',
                'title' => 'Popular Tours',
                'is_enabled' => true,
                'sort_order' => 2,
                'settings' => [
                    'title' => 'Popular Tours',
                    'subtitle' => 'Check out our most popular tours',
                    'tour_ids' => [1, 2, 3],
                ],
            ],
            [
                'key' => 'features',
                'title' => 'Features (Icon Grid)',
                'is_enabled' => true,
                'sort_order' => 3,
                'settings' => [
                    'title' => 'Why Choose Niagara Tours',
                    'subtitle' => 'Experience the best with our premium services',
                    'features' => [
                        ['icon' => 'images/icons/icon-1.png', 'title' => 'Discover the possibilities', 'description' => 'With nearly half a million attractions, hotels & more, you\'re sure to find joy.'],
                        ['icon' => 'images/icons/icon-2.png', 'title' => 'Enjoy deals & delights', 'description' => 'Quality activities. Great prices. Plus, earn credits to save more.'],
                        ['icon' => 'images/icons/icon-3.png', 'title' => 'Exploring made easy', 'description' => 'Book last minute, skip lines & get free cancellation for easier exploring.'],
                        ['icon' => 'images/icons/icon-4.png', 'title' => 'Travel you can trust', 'description' => 'Read reviews & get reliable customer support. We\'re with you at every step.'],
                    ],
                ],
            ],
            [
                'key' => 'destinations',
                'title' => 'Destinations Slider',
                'is_enabled' => true,
                'sort_order' => 4,
                'settings' => [
                    'title' => 'Destinations Around the World',
                    'subtitle' => 'Niagaratours is a platform designed to connect fans with exclusive experiences.',
                    'destination_ids' => [1, 2, 3, 4, 5],
                ],
            ],
            [
                'key' => 'policies',
                'title' => 'Policies / Guarantees',
                'is_enabled' => true,
                'sort_order' => 5,
                'settings' => [
                    'items' => [
                        ['image' => 'images/banners/home-banner-1.jpg', 'badge' => 'Premium Benefits', 'title' => 'Flexible Booking', 'description' => 'Reserve elite experiences now and pay later with complete freedom to plan your journey your way.', 'overlay_from' => '#0ad6c7', 'overlay_to' => '#0c8d89'],
                        ['image' => 'images/banners/home-banner-2.jpg', 'badge' => 'Worry Free', 'title' => 'Free Cancellation', 'description' => 'Receive a complete refund when cancelling eligible experiences at least 24 hours before departure.', 'overlay_from' => '#2b175c', 'overlay_to' => '#122e79'],
                    ],
                ],
            ],
            [
                'key' => 'why_choose_us',
                'title' => 'Why Choose Us',
                'is_enabled' => true,
                'sort_order' => 6,
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
            ],
            [
                'key' => 'reviews',
                'title' => 'Reviews Section',
                'is_enabled' => true,
                'sort_order' => 7,
                'settings' => [
                    'badge' => 'WHAT PEOPLE ARE SAYING',
                    'title' => '5 Star Niagara Tours',
                    'subtitle' => '',
                ],
            ],
            [
                'key' => 'faq',
                'title' => 'FAQ Section',
                'is_enabled' => true,
                'sort_order' => 8,
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
            ],
            [
                'key' => 'featured_promo',
                'title' => 'Featured Promo Section',
                'is_enabled' => true,
                'sort_order' => 9,
                'settings' => [
                    'badge' => 'Now Featuring',
                    'title' => 'Elevate Your Senses',
                    'description' => 'Wine, food, adventure... it\'s all about making your senses pop. We\'ve partnered with the top Niagara producers to offer unparalleled experiences that will have you craving more!',
                    'button_text' => 'Learn More',
                    'button_link' => '/tours',
                    'background_image' => 'https://images.unsplash.com/photo-1564507004663-b6dfb3c824d5?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80',
                ],
            ],
            [
                'key' => 'blog',
                'title' => 'Blog Section',
                'is_enabled' => true,
                'sort_order' => 10,
                'settings' => [
                    'badge' => 'LATEST NEWS & TRENDS',
                    'title' => 'From Our Blog',
                    'view_all_link' => '#',
                ],
            ],
            [
                'key' => 'cta',
                'title' => 'Call to Action',
                'is_enabled' => true,
                'sort_order' => 11,
                'settings' => [
                    'title' => 'Ready for an Unforgettable Adventure?',
                    'description' => 'Book your Niagara Falls tour today and create memories that will last a lifetime.',
                    'button_text' => 'Start Your Adventure',
                    'button_link' => '/tours',
                    'background_image' => 'https://images.unsplash.com/photo-1564507004663-b6dfb3c824d5?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80',
                ],
            ],
            [
                'key' => 'popular_destinations',
                'title' => 'Popular Destinations',
                'is_enabled' => true,
                'sort_order' => 12,
                'settings' => [
                    'title' => 'Popular Destinations',
                    'subtitle' => 'Explore the most loved spots around Niagara',
                    'tour_ids' => [],
                ],
            ],
            [
                'key' => 'browse_categories',
                'title' => 'Browse by Category',
                'is_enabled' => true,
                'sort_order' => 13,
                'settings' => [
                    'title' => 'Browse by Category',
                    'subtitle' => 'Find the perfect tour for your style',
                ],
            ],
        ];

        foreach ($sections as $data) {
            HomepageSection::create($data);
        }
    }
}
