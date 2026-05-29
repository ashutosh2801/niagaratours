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
        session()->flash('message', 'Destination deleted successfully.');
        ActivityLogger::log('deleted', 'Destination', "Destination '{$name}' deleted");
    }

    public function render()
    {
        $query = Destination::where('name', 'like', '%'.$this->search.'%');

        if ($this->popular) {
            $query->where('is_popular', true);
        }

        $destinations = $query->orderBy('sort_order')->orderBy('name')->paginate(10);

        return view('admin.destinations.index', compact('destinations'));
    }
}
