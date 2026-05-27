<?php

namespace App\Livewire\Front;

use App\Models\Destination;
use App\Models\Tour;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class DestinationTours extends Component
{
    use WithPagination;

    public $slug;
    public $destination;
    public $sortBy = 'latest';

    protected $queryString = [
        'sortBy' => ['except' => 'latest'],
    ];

    public function mount($slug)
    {
        $this->slug = $slug;
        $this->destination = Destination::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();
    }

    public function title()
    {
        return $this->destination->name . ' Tours';
    }

    public function updatingSortBy()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = Tour::where('is_active', true)
            ->where('destination_id', $this->destination->id)
            ->with('category');

        switch ($this->sortBy) {
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            case 'popular':
                $query->withCount('orderItems')->orderBy('order_items_count', 'desc');
                break;
            default:
                $query->latest();
                break;
        }

        $tours = $query->paginate(12);

        return view('front.destination-tours', [
            'tours' => $tours,
            'destination' => $this->destination,
        ]);
    }
}
