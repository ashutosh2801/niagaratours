<?php

namespace App\Livewire\Front;

use App\Models\Destination;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Title('All Destinations')]
#[Layout('layouts.app')]
class DestinationList extends Component
{
    use WithPagination;

    public function render()
    {
        $destinations = Destination::where('is_active', true)
            ->withCount('tours')
            ->orderBy('sort_order')
            ->orderBy('name')
            ->paginate(12);

        return view('front.destinations', compact('destinations'));
    }
}
