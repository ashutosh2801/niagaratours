<?php

namespace App\Livewire\Front;

use App\Models\Category;
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
    public $min_price = 0;
    public $max_price = 1000;
    public $selectedDurations = [];
    public $sortBy = 'latest';

    protected $queryString = [
        'search' => ['except' => ''],
        'selectedCategories' => ['except' => []],
        'min_price' => ['except' => 0],
        'max_price' => ['except' => 1000],
        'selectedDurations' => ['except' => []],
        'sortBy' => ['except' => 'latest'],
    ];

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
        if ($this->min_price > $this->max_price) {
            $this->min_price = $this->max_price;
        }
        $this->resetPage();
    }

    public function updatingMaxPrice()
    {
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
        $this->reset(['search', 'selectedCategories', 'min_price', 'max_price', 'selectedDurations', 'sortBy']);
        $this->min_price = 0;
        $this->max_price = 1000;
        $this->resetPage();
    }

    public function render()
    {
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

        if ($this->min_price > 0) {
            $query->where('price', '>=', $this->min_price);
        }
        if ($this->max_price < 1000) {
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

        return view('front.tours', [
            'tours' => $tours,
            'categories' => $categories,
        ]);
    }
}
