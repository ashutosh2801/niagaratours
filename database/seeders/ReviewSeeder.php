<?php

namespace Database\Seeders;

use App\Models\Review;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    public function run(): void
    {
        $reviews = [
            ['name' => 'Sarah M.', 'location' => 'Toronto, ON', 'content' => 'Absolutely incredible experience! The tour guide was knowledgeable and friendly. The views of Niagara Falls were breathtaking. Highly recommend this tour to anyone visiting the area!', 'rating' => 5, 'sort_order' => 0],
            ['name' => 'James K.', 'location' => 'New York, NY', 'content' => 'Booked the Niagara Wine Tour and it exceeded all expectations. The wineries were amazing, and the guide made the experience truly special. Will definitely book again!', 'rating' => 5, 'sort_order' => 1],
            ['name' => 'Emily R.', 'location' => 'Chicago, IL', 'content' => 'The sunset tour was magical! Seeing the falls lit up at night was unforgettable. Professional service from start to finish. Worth every penny!', 'rating' => 5, 'sort_order' => 2],
            ['name' => 'Michael P.', 'location' => 'Boston, MA', 'content' => 'We booked the private tour for our anniversary and it was perfect. The guide customized the day to our preferences. Five star service all the way!', 'rating' => 5, 'sort_order' => 3],
            ['name' => 'Jessica L.', 'location' => 'Vancouver, BC', 'content' => 'The boat cruise was the highlight of our trip. Getting up close to the falls was an experience we will never forget. The entire family loved it!', 'rating' => 5, 'sort_order' => 4],
            ['name' => 'David W.', 'location' => 'Los Angeles, CA', 'content' => 'Excellent tour company! From booking to the actual tour, everything was seamless. Our guide was knowledgeable and went above and beyond.', 'rating' => 5, 'sort_order' => 5],
        ];

        foreach ($reviews as $review) {
            Review::create($review);
        }
    }
}
