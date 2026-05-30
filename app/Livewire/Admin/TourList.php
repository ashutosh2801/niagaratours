<?php

namespace App\Livewire\Admin;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Tour;
use App\Helpers\ActivityLogger;
use Illuminate\Support\Str;

#[Title('Tours')]
#[Layout('layouts.admin')]
class TourList extends Component
{
    use WithPagination;

    public $search = '';
    public $selectedIds = [];

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
            ->orderBy('created_at', 'desc');
    }

    public function render()
    {
        $user = auth()->user();
        $canSeeAll = $user->hasRole('administrator') || $user->hasRole('admin');

        return view('admin.tours.index', [
            'tours' => $this->query()->paginate(10),
            'canSeeAll' => $canSeeAll,
        ]);
    }
}
