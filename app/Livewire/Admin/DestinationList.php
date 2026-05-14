<?php

namespace App\Livewire\Admin;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Destination;

#[Title('Destinations')]
#[Layout('layouts.admin')]
class DestinationList extends Component
{
    use WithPagination;

    public $search = '';

    public function delete($id)
    {
        Destination::findOrFail($id)->delete();
        session()->flash('message', 'Destination deleted successfully.');
    }

    public function render()
    {
        $destinations = Destination::where('name', 'like', '%'.$this->search.'%')
            ->orderBy('sort_order')
            ->orderBy('name')
            ->paginate(10);

        return view('admin.destinations.index', compact('destinations'));
    }
}
