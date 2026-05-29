<?php

namespace App\Livewire\Admin;

use App\Models\Review;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Reviews')]
#[Layout('layouts.admin')]
class ReviewList extends Component
{
    use WithPagination;

    public $editId = null;
    public $showForm = false;
    public $name = '';
    public $location = '';
    public $content = '';
    public $rating = 5;

    public function save()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'content' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
            'location' => 'nullable|string|max:255',
        ]);

        Review::updateOrCreate(['id' => $this->editId], [
            'name' => $this->name,
            'location' => $this->location,
            'content' => $this->content,
            'rating' => $this->rating,
        ]);

        $this->resetForm();
        session()->flash('message', 'Review saved successfully.');
    }

    public function addNew()
    {
        $this->resetForm();
        $this->dispatch('show-review-form');
    }

    public function edit($id)
    {
        $review = Review::findOrFail($id);
        $this->editId = $review->id;
        $this->name = $review->name;
        $this->location = $review->location;
        $this->content = $review->content;
        $this->rating = $review->rating;
        $this->dispatch('show-review-form');
    }

    public function delete($id)
    {
        Review::findOrFail($id)->delete();
    }

    public function toggleActive($id)
    {
        $review = Review::findOrFail($id);
        $review->update(['is_active' => !$review->is_active]);
    }

    public function resetForm()
    {
        $this->reset(['editId', 'name', 'location', 'content', 'rating']);
        $this->rating = 5;
    }

    public function render()
    {
        return view('components.admin.review-list', [
            'reviews' => Review::orderBy('sort_order')->paginate(10),
        ]);
    }
}
