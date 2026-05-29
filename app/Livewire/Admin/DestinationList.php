<?php

namespace App\Livewire\Admin;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Destination;
use App\Helpers\ActivityLogger;

#[Title('Destinations')]
#[Layout('layouts.admin')]
class DestinationList extends Component
{
    use WithPagination;

    public $search = '';
    public $popular = false;
    public $selectedIds = [];

    public function mount()
    {
        $this->popular = request()->query('popular', false);
    }

    public function delete($id)
    {
        if (!auth()->user()->hasPermission('destinations')) {
            abort(403, 'Unauthorized access.');
        }

        $destination = Destination::findOrFail($id);
        $name = $destination->name;
        $destination->delete();
        $this->selectedIds = array_diff($this->selectedIds, [$id]);
        session()->flash('message', 'Destination deleted successfully.');
        ActivityLogger::log('deleted', 'Destination', "Destination '{$name}' deleted");
    }

    public function deleteSelected()
    {
        if (!auth()->user()->hasPermission('destinations')) {
            abort(403, 'Unauthorized access.');
        }

        $destinations = Destination::whereIn('id', $this->selectedIds)->get();
        foreach ($destinations as $destination) {
            $destination->delete();
            ActivityLogger::log('deleted', 'Destination', "Destination '{$destination->name}' deleted");
        }

        $count = count($this->selectedIds);
        $this->selectedIds = [];
        session()->flash('message', "{$count} destination(s) deleted successfully.");
    }

    public function toggleActive($id)
    {
        if (!auth()->user()->hasPermission('destinations')) {
            abort(403, 'Unauthorized access.');
        }

        $destination = Destination::findOrFail($id);
        $destination->update(['is_active' => !$destination->is_active]);
        $status = $destination->is_active ? 'activated' : 'deactivated';
        ActivityLogger::log('updated', 'Destination', "Destination '{$destination->name}' {$status}");
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
        $query = Destination::where('name', 'like', '%'.$this->search.'%');

        if ($this->popular) {
            $query->where('is_popular', true);
        }

        return $query->orderBy('sort_order')->orderBy('name');
    }

    public function render()
    {
        return view('admin.destinations.index', [
            'destinations' => $this->query()->paginate(10),
        ]);
    }
}
