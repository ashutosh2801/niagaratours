<?php

namespace App\Livewire\Front;

use App\Models\Category;
use App\Models\Tour;
use Livewire\Component;
use Livewire\WithPagination;

class TourSearch extends Component
{
    use WithPagination;

    public $search = '';
    public $category_id = '';
    public $min_price = '';
    public $max_price = '';

    protected $queryString = [
        'search' => ['except' => ''],
        'category_id' => ['except' => ''],
        'min_price' => ['except' => ''],
        'max_price' => ['except' => ''],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingCategoryId()
    {
        $this->resetPage();
    }

    public function updatingMinPrice()
    {
        $this->resetPage();
    }

    public function updatingMaxPrice()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = Tour::where('is_active', true);

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('title', 'like', '%' . $this->search . '%')
                  ->orWhere('short_description', 'like', '%' . $this->search . '%')
                  ->orWhere('location', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->category_id) {
            $query->where('category_id', $this->category_id);
        }

        if ($this->min_price !== '') {
            $query->where('price', '>=', $this->min_price);
        }

        if ($this->max_price !== '') {
            $query->where('price', '<=', $this->max_price);
        }

        $tours = $query->with('category')->paginate(12);
        $categories = Category::where('is_active', true)->orderBy('name')->get();

        return view('components.front.tour-search', [
            'tours' => $tours,
            'categories' => $categories,
        ]);
    }
}
