<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Destination;
use App\Models\Tour;
use App\Models\Page;
use Database\Seeders\HomepageSectionSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin user
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@niagaratours.com',
            'password' => bcrypt('password'),
            'is_admin' => true,
        ]);

        // Regular user
        User::factory()->create([
            'name' => 'User',
            'email' => 'user@niagaratours.com',
            'password' => bcrypt('password'),
            'is_admin' => false,
        ]);

        // Categories
        $categories = [
            ['name' => 'Adventure Tours', 'slug' => 'adventure-tours', 'description' => 'Thrilling adventures and outdoor activities'],
            ['name' => 'Boat Cruises', 'slug' => 'boat-cruises', 'description' => 'Scenic boat tours and cruises'],
            ['name' => 'Wine Tours', 'slug' => 'wine-tours', 'description' => 'Wine tasting and vineyard tours'],
            ['name' => 'Family Tours', 'slug' => 'family-tours', 'description' => 'Fun for the whole family'],
            ['name' => 'Helicopter Tours', 'slug' => 'helicopter-tours', 'description' => 'Aerial views and helicopter experiences'],
            ['name' => 'Walking Tours', 'slug' => 'walking-tours', 'description' => 'Guided walking experiences'],
        ];

        foreach ($categories as $cat) {
            Category::create($cat);
        }

        // Destinations
        $destinations = [
            ['name' => 'Niagara Falls', 'slug' => 'niagara-falls', 'description' => 'Experience the majesty of Niagara Falls', 'sort_order' => 1],
            ['name' => 'Niagara-on-the-Lake', 'slug' => 'niagara-on-the-lake', 'description' => 'Charming historic town with wineries', 'sort_order' => 2],
            ['name' => 'Toronto', 'slug' => 'toronto', 'description' => 'Canada\'s largest city', 'sort_order' => 3],
            ['name' => 'Wine Country', 'slug' => 'wine-country', 'description' => 'World-class wineries and vineyards', 'sort_order' => 4],
        ];

        foreach ($destinations as $dest) {
            Destination::create($dest);
        }

        // Sample tours
        $tours = [
            [
                'category_id' => 1,
                'destination_id' => 1,
                'title' => 'Niagara Falls Adventure Tour',
                'slug' => 'niagara-falls-adventure-tour',
                'short_description' => 'Experience the thrill of Niagara Falls up close',
                'description' => 'An unforgettable adventure taking you to the heart of Niagara Falls. Feel the mist on your face as you cruise to the base of the falls, explore the Cave of the Winds, and enjoy breathtaking views from the observation deck.',
                'location' => 'Niagara Falls, Ontario',
                'duration' => 4,
                'duration_type' => 'hours',
                'price' => 89.99,
                'sale_price' => 69.99,
                'max_people' => 20,
                'images' => json_encode(['https://images.unsplash.com/photo-1536844384178-2bb103f0d57d?w=800']),
                'highlights' => json_encode(['Boat cruise to the falls', 'Cave of the Winds experience', 'Observation deck access', 'Professional guide']),
                'inclusions' => json_encode(['Hotel pickup & drop-off', 'Professional guide', 'Boat cruise ticket', 'Poncho']),
                'exclusions' => json_encode(['Meals & drinks', 'Personal expenses', 'Tips']),
                'itinerary' => json_encode([['day' => 1, 'title' => 'Niagara Adventure', 'description' => 'Morning pickup, boat cruise, Cave of the Winds, afternoon free time']]),
                'faqs' => json_encode([['question' => 'What should I bring?', 'answer' => 'Comfortable shoes, camera, and a waterproof jacket.']]),
                'is_featured' => true,
                'is_active' => true,
            ],
            [
                'category_id' => 2,
                'destination_id' => 1,
                'title' => 'Sunset Dinner Cruise',
                'slug' => 'sunset-dinner-cruise',
                'short_description' => 'Romantic dinner cruise with stunning sunset views',
                'description' => 'Enjoy a magical evening on the water with a delicious dinner buffet, live entertainment, and spectacular views of the Niagara skyline at sunset.',
                'location' => 'Niagara River',
                'duration' => 3,
                'duration_type' => 'hours',
                'price' => 129.99,
                'sale_price' => 99.99,
                'max_people' => 50,
                'images' => json_encode(['https://images.unsplash.com/photo-1544551763-46a013bb70d5?w=800']),
                'highlights' => json_encode(['Sunset views', 'Dinner buffet', 'Live entertainment', 'Open bar option']),
                'inclusions' => json_encode(['3-hour cruise', 'Dinner buffet', 'Live music', 'Coffee & tea']),
                'exclusions' => json_encode(['Alcoholic beverages', 'Gratuities', 'Hotel transfer']),
                'itinerary' => json_encode([['day' => 1, 'title' => 'Evening Cruise', 'description' => 'Boarding at 6pm, dinner at 7pm, sunset viewing, return at 9pm']]),
                'faqs' => json_encode([['question' => 'Is there parking?', 'answer' => 'Yes, free parking is available at the dock.']]),
                'is_featured' => true,
                'is_active' => true,
            ],
            [
                'category_id' => 3,
                'destination_id' => 2,
                'title' => 'Niagara Wine Country Tour',
                'slug' => 'niagara-wine-country-tour',
                'short_description' => 'Explore world-class wineries in Niagara',
                'description' => 'Discover the award-winning wines of the Niagara Peninsula. Visit 4 premium wineries, enjoy exclusive tastings, and learn about the winemaking process from expert sommeliers.',
                'location' => 'Niagara-on-the-Lake',
                'duration' => 6,
                'duration_type' => 'hours',
                'price' => 149.99,
                'sale_price' => null,
                'max_people' => 15,
                'images' => json_encode(['https://images.unsplash.com/photo-1506377247377-2a5b3b417ebb?w=800']),
                'highlights' => json_encode(['4 winery visits', 'Exclusive tastings', 'Cheese pairings', 'Sommelier guide']),
                'inclusions' => json_encode(['Winery tours', 'Wine tastings', 'Cheese platter', 'Transportation']),
                'exclusions' => json_encode(['Additional wine purchases', 'Lunch', 'Hotel pickup']),
                'itinerary' => json_encode([['day' => 1, 'title' => 'Wine Tour', 'description' => 'Visit 4 wineries with tastings and a cheese pairing session']]),
                'faqs' => json_encode([['question' => 'Can I buy wine?', 'answer' => 'Yes, all wineries offer bottles for purchase.']]),
                'is_featured' => true,
                'is_active' => true,
            ],
            [
                'category_id' => 5,
                'destination_id' => 1,
                'title' => 'Niagara Helicopter Tour',
                'slug' => 'niagara-helicopter-tour',
                'short_description' => 'Breathtaking aerial views of Niagara Falls',
                'description' => 'Soar above Niagara Falls in a state-of-the-art helicopter for a once-in-a-lifetime experience. See the falls, the whirlpool, and the Niagara River from a bird\'s eye view.',
                'location' => 'Niagara Falls, Ontario',
                'duration' => 20,
                'duration_type' => 'minutes',
                'price' => 199.99,
                'sale_price' => 179.99,
                'max_people' => 6,
                'images' => json_encode(['https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=800']),
                'highlights' => json_encode(['Aerial views', 'Professional pilot', 'Photo opportunities', 'Safety briefing']),
                'inclusions' => json_encode(['Helicopter ride', 'Headsets', 'Safety briefing', 'Photo stop']),
                'exclusions' => json_encode(['Hotel transfer', 'Video recording']),
                'itinerary' => json_encode([['day' => 1, 'title' => 'Helicopter Experience', 'description' => 'Safety briefing, 20-minute flight, photo opportunity']]),
                'faqs' => json_encode([['question' => 'Is it safe?', 'answer' => 'Yes, all our helicopters are regularly maintained and piloted by licensed professionals.']]),
                'is_featured' => false,
                'is_active' => true,
            ],
            [
                'category_id' => 4,
                'destination_id' => 1,
                'title' => 'Family Fun Package',
                'slug' => 'family-fun-package',
                'short_description' => 'Perfect family day out at Niagara Falls',
                'description' => 'A complete family package including visits to Clifton Hill, the Butterfly Conservatory, and a Maid of the Mist boat tour. Fun for all ages!',
                'location' => 'Niagara Falls, Ontario',
                'duration' => 8,
                'duration_type' => 'hours',
                'price' => 249.99,
                'sale_price' => 199.99,
                'max_people' => 10,
                'images' => json_encode(['https://images.unsplash.com/photo-1580137189272-c9379f8864fd?w=800']),
                'highlights' => json_encode(['Maid of the Mist', 'Butterfly Conservatory', 'Clifton Hill attractions', 'Family-friendly guide']),
                'inclusions' => json_encode(['All attraction tickets', 'Lunch voucher', 'Professional guide', 'Hotel transfer']),
                'exclusions' => json_encode(['Souvenirs', 'Extra snacks']),
                'itinerary' => json_encode([['day' => 1, 'title' => 'Family Day', 'description' => 'Morning at Butterfly Conservatory, afternoon Maid of the Mist, evening Clifton Hill']]),
                'faqs' => json_encode([['question' => 'Is this suitable for toddlers?', 'answer' => 'Yes, all activities are family-friendly and suitable for children of all ages.']]),
                'is_featured' => true,
                'is_active' => true,
            ],
            [
                'category_id' => 6,
                'destination_id' => 2,
                'title' => 'Niagara Walking History Tour',
                'slug' => 'niagara-walking-history-tour',
                'short_description' => 'Discover the rich history of Niagara',
                'description' => 'Walk through history with our expert guides as you explore historic sites, learn about the War of 1812, and discover the stories behind Niagara\'s most famous landmarks.',
                'location' => 'Niagara-on-the-Lake',
                'duration' => 2,
                'duration_type' => 'hours',
                'price' => 49.99,
                'sale_price' => 39.99,
                'max_people' => 25,
                'images' => json_encode(['https://images.unsplash.com/photo-1573821663912-569905455b1c?w=800']),
                'highlights' => json_encode(['Historic sites', 'War of 1812 stories', 'Expert guide', 'Photo stops']),
                'inclusions' => json_encode(['Guided walking tour', 'Historical sites entry', 'Audio headsets']),
                'exclusions' => json_encode(['Meals', 'Hotel transfer']),
                'itinerary' => json_encode([['day' => 1, 'title' => 'Walking Tour', 'description' => 'Meet at the Clock Tower, explore historic district, visit Fort George']]),
                'faqs' => json_encode([['question' => 'How much walking is involved?', 'answer' => 'Approximately 3km at a leisurely pace with multiple stops.']]),
                'is_featured' => false,
                'is_active' => true,
            ],
        ];

        foreach ($tours as $tourData) {
            Tour::create($tourData);
        }

        // Homepage Sections
        $this->call(HomepageSectionSeeder::class);

        // Settings
        $this->call(SettingSeeder::class);

        // Menus
        $this->call(MenuSeeder::class);

        // Pages
        Page::create([
            'title' => 'About Us',
            'slug' => 'about',
            'content' => '<h2>Welcome to Niagara Tours</h2><p>We are your premier tour operator in the Niagara region, offering unforgettable experiences since 2010.</p>',
            'is_active' => true,
        ]);

        Page::create([
            'title' => 'Privacy Policy',
            'slug' => 'privacy-policy',
            'content' => '<h2>Privacy Policy</h2><p>Your privacy is important to us. This policy outlines how we collect, use, and protect your personal information.</p>',
            'is_active' => true,
        ]);

        Page::create([
            'title' => 'Terms & Conditions',
            'slug' => 'terms-conditions',
            'content' => '<h2>Terms & Conditions</h2><p>Please read these terms carefully before booking any tour with us.</p>',
            'is_active' => true,
        ]);
    }
}
