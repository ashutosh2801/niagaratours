<?php

namespace App\Livewire\Front;

use App\Models\Tour;
use Livewire\Component;

class FeaturedTours extends Component
{
    public function render()
    {
        $tours = Tour::with('category')
            ->where('is_active', true)
            ->where('is_featured', true)
            ->take(6)
            ->get();

        return view('components.front.featured-tours', [
            'tours' => $tours,
        ]);
    }
}
