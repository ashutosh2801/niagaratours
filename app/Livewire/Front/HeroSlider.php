<?php

namespace App\Livewire\Front;

use App\Models\HomepageSection;
use Livewire\Component;

class HeroSlider extends Component
{
    public function render()
    {
        $settings = HomepageSection::getSettings('hero');
        $slides = $settings['slides'] ?? [];

        return view('components.front.hero-slider', [
            'slides' => $slides,
        ]);
    }
}
