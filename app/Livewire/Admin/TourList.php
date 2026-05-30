<?php

namespace App\Livewire\Admin;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Tour;
use App\Models\Category;
use App\Models\Destination;
use App\Helpers\ActivityLogger;
use Illuminate\Support\Str;

#[Title('Tours')]
#[Layout('layouts.admin')]
class TourList extends Component
{
    use WithPagination;

    public $search = '';
    public $selectedIds = [];
    public $filterCategory = '';
    public $filterDestination = '';
    public $filterStatus = '';
    public $filterFeatured = '';

    public function delete($id)
    {
        if (!auth()->user()->hasPermission('tours')) {
            abort(403, 'Unauthorized access.');
        }

        $tour = Tour::findOrFail($id);
        $title = $tour->title;
        $tour->delete();
        $this->selectedIds = array_diff($this->selectedIds, [$id]);
        session()->flash('message', 'Tour deleted successfully.');
        ActivityLogger::log('deleted', 'Tour', "Tour '{$title}' deleted");
    }

    public function deleteSelected()
    {
        if (!auth()->user()->hasPermission('tours')) {
            abort(403, 'Unauthorized access.');
        }

        $tours = Tour::whereIn('id', $this->selectedIds)->get();
        foreach ($tours as $tour) {
            $tour->delete();
            ActivityLogger::log('deleted', 'Tour', "Tour '{$tour->title}' deleted");
        }

        $count = count($this->selectedIds);
        $this->selectedIds = [];
        session()->flash('message', "{$count} tour(s) deleted successfully.");
    }

    public function toggleActive($id)
    {
        if (!auth()->user()->hasPermission('tours')) {
            abort(403, 'Unauthorized access.');
        }

        $tour = Tour::findOrFail($id);
        $tour->update(['is_active' => !$tour->is_active]);
        $status = $tour->is_active ? 'activated' : 'deactivated';
        ActivityLogger::log('updated', 'Tour', "Tour '{$tour->title}' {$status}");
    }

    public function clone($id)
    {
        if (!auth()->user()->hasPermission('tours')) {
            abort(403, 'Unauthorized access.');
        }

        $original = Tour::with('category', 'destination')->findOrFail($id);
        $clone = $original->replicate();
        $clone->title = $original->title . ' (Copy)';
        $clone->slug = $original->slug . '-copy-' . Str::random(4);
        $clone->is_active = false;
        $clone->created_by = auth()->id();
        $clone->created_at = now();
        $clone->updated_at = now();
        $clone->save();

        ActivityLogger::log('created', 'Tour', "Tour '{$clone->title}' cloned from '{$original->title}'");
        session()->flash('message', "Tour cloned successfully. You can now edit the copy.");

        return redirect()->route('admin.tours.edit', $clone);
    }

    public function toggleSelectAll()
    {
        $ids = $this->query()->pluck('id')->toArray();
        if (empty(array_diff($ids, $this->selectedIds))) {
            $this->selectedIds = array_values(array_diff($this->selectedIds, $ids));
        } else {
            $this->selectedIds = array_values(array_unique(array_merge($this->selectedIds, $ids)));
        }
    }

    private function query()
    {
        $user = auth()->user();
        $canSeeAll = $user->hasRole('administrator') || $user->hasRole('admin');

        return Tour::with('category', 'destination', 'creator')
            ->when(!$canSeeAll, function ($q) use ($user) {
                $q->where('created_by', $user->id);
            })
            ->where(function ($q) {
                $q->where('title', 'like', '%'.$this->search.'%')
                  ->orWhere('location', 'like', '%'.$this->search.'%');
            })
            ->when($this->filterCategory, fn($q) => $q->where('category_id', $this->filterCategory))
            ->when($this->filterDestination, fn($q) => $q->where('destination_id', $this->filterDestination))
            ->when($this->filterStatus === 'active', fn($q) => $q->where('is_active', true))
            ->when($this->filterStatus === 'inactive', fn($q) => $q->where('is_active', false))
            ->when($this->filterFeatured === 'featured', fn($q) => $q->where('is_featured', true))
            ->when($this->filterFeatured === 'not-featured', fn($q) => $q->where('is_featured', false))
            ->orderBy('created_at', 'desc');
    }

    public function resetFilters()
    {
        $this->reset(['filterCategory', 'filterDestination', 'filterStatus', 'filterFeatured', 'search']);
    }

    public function updatedSearch() { $this->resetPage(); }
    public function updatedFilterCategory() { $this->resetPage(); }
    public function updatedFilterDestination() { $this->resetPage(); }
    public function updatedFilterStatus() { $this->resetPage(); }
    public function updatedFilterFeatured() { $this->resetPage(); }

    public function render()
    {
        $user = auth()->user();
        $canSeeAll = $user->hasRole('administrator') || $user->hasRole('admin');

        return view('admin.tours.index', [
            'tours' => $this->query()->paginate(10),
            'canSeeAll' => $canSeeAll,
            'categories' => Category::select('id', 'name')->orderBy('name')->get(),
            'destinations' => Destination::select('id', 'name')->orderBy('name')->get(),
        ]);
    }
}
