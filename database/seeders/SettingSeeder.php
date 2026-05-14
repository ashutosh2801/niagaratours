<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $defaults = [
            'site_name' => 'Niagara Tours',
            'site_tagline' => 'Experience the Magic of Niagara Falls',
            'site_description' => 'Book the best Niagara Falls tours with expert guides. Experience breathtaking views, boat cruises, and more.',
            'meta_title' => 'Niagara Tours - Book Your Niagara Falls Adventure',
            'meta_description' => 'Discover the best Niagara Falls tours, boat cruises, and attractions. Book your adventure today.',
            'meta_keywords' => 'niagara falls, tours, boat cruise, adventure, travel',
            'contact_email' => 'info@niagaratours.com',
            'contact_phone' => '+1 (555) 123-4567',
            'contact_address' => '123 Falls Avenue, Niagara Falls, ON, Canada',
            'social_facebook' => '#',
            'social_twitter' => '#',
            'social_instagram' => '#',
            'social_youtube' => '#',
            'logo' => '',
            'favicon' => '',
            'storage_disk' => 'public',
            'aws_key' => '',
            'aws_secret' => '',
            'aws_region' => 'us-east-1',
            'aws_bucket' => '',
        ];

        foreach ($defaults as $key => $value) {
            Setting::firstOrCreate(['key' => $key], ['value' => $value]);
        }
    }
}
