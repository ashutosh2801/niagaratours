<?php

namespace App\Livewire\Front;

use App\Models\Category;
use App\Models\Destination;
use App\Models\Tour;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Title('All Tours')]
#[Layout('layouts.app')]
class TourList extends Component
{
    use WithPagination;

    public $search = '';
    public $selectedCategories = [];
    public $selectedDestinations = [];
    public $min_price = 0;
    public $max_price = null;
    public $maxAvailablePrice = 0;
    public $selectedDurations = [];
    public $sortBy = 'latest';

    protected $queryString = [
        'search' => ['except' => ''],
        'selectedCategories' => ['except' => []],
        'selectedDestinations' => ['except' => []],
        'min_price' => ['except' => 0],
        'max_price' => ['except' => null],
        'selectedDurations' => ['except' => []],
        'sortBy' => ['except' => 'latest'],
    ];

    public function mount()
    {
        $this->maxAvailablePrice = $this->resolveMaxAvailablePrice();

        if (is_null($this->max_price)) {
            $this->max_price = $this->maxAvailablePrice;
        }
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingSelectedCategories()
    {
        $this->resetPage();
    }

    public function updatingMinPrice()
    {
        $this->min_price = max(0, (int) $this->min_price);

        if ($this->min_price > $this->max_price) {
            $this->min_price = $this->max_price;
        }
        $this->resetPage();
    }

    public function updatingMaxPrice()
    {
        $this->max_price = min((int) $this->max_price, $this->maxAvailablePrice);

        if ($this->max_price < $this->min_price) {
            $this->max_price = $this->min_price;
        }
        $this->resetPage();
    }

    public function updatingSelectedDurations()
    {
        $this->resetPage();
    }

    public function updatingSortBy()
    {
        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->reset(['search', 'selectedCategories', 'selectedDestinations', 'min_price', 'max_price', 'selectedDurations', 'sortBy']);
        $this->min_price = 0;
        $this->maxAvailablePrice = $this->resolveMaxAvailablePrice();
        $this->max_price = $this->maxAvailablePrice;
        $this->resetPage();
    }

    private function resolveMaxAvailablePrice(): int
    {
        $maxPrice = (float) Tour::where('is_active', true)->max('price');

        if ($maxPrice <= 0) {
            return 0;
        }

        return (int) (ceil($maxPrice / 10) * 10);
    }

    public function render()
    {
        $this->maxAvailablePrice = $this->resolveMaxAvailablePrice();

        if (is_null($this->max_price) || $this->max_price > $this->maxAvailablePrice) {
            $this->max_price = $this->maxAvailablePrice;
        }

        if ($this->min_price > $this->max_price) {
            $this->min_price = $this->max_price;
        }

        $query = Tour::where('is_active', true)->with('category');

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('title', 'like', '%' . $this->search . '%')
                  ->orWhere('short_description', 'like', '%' . $this->search . '%')
                  ->orWhere('location', 'like', '%' . $this->search . '%');
            });
        }

        if (!empty($this->selectedCategories)) {
            $query->whereIn('category_id', $this->selectedCategories);
        }

        if (!empty($this->selectedDestinations)) {
            $query->whereIn('destination_id', $this->selectedDestinations);
        }

        if ($this->min_price > 0) {
            $query->where('price', '>=', $this->min_price);
        }
        if (!is_null($this->max_price) && $this->max_price < $this->maxAvailablePrice) {
            $query->where('price', '<=', $this->max_price);
        }

        if (!empty($this->selectedDurations)) {
            $query->where(function ($q) {
                foreach ($this->selectedDurations as $range) {
                    $parts = explode('-', $range);
                    $min = (int) $parts[0];
                    $max = $parts[1] !== '' && $parts[1] !== null ? (int) $parts[1] : null;
                    if ($max !== null) {
                        $q->orWhereBetween('duration', [$min, $max]);
                    } else {
                        $q->orWhere('duration', '>=', $min);
                    }
                }
            });
        }

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
        $categories = Category::where('is_active', true)->orderBy('name')->get();
        $destinations = Destination::where('is_active', true)->orderBy('name')->get();

        return view('front.tours', [
            'tours' => $tours,
            'categories' => $categories,
            'destinations' => $destinations,
        ]);
    }
}
