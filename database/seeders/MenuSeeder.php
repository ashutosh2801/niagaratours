<?php

namespace Database\Seeders;

use App\Models\Menu;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        Menu::create([
            'label' => 'Home',
            'route' => 'home',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        Menu::create([
            'label' => 'Tours',
            'route' => 'tours',
            'sort_order' => 2,
            'is_active' => true,
        ]);

        Menu::create([
            'label' => 'About Us',
            'route' => 'about',
            'sort_order' => 3,
            'is_active' => true,
        ]);

        Menu::create([
            'label' => 'Contact',
            'route' => 'contact',
            'sort_order' => 4,
            'is_active' => true,
        ]);
    }
}
