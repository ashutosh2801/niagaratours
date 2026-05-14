<?php

namespace App\Livewire\Admin;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Tour;

#[Title('Tours')]
#[Layout('layouts.admin')]
class TourList extends Component
{
    use WithPagination;

    public $search = '';

    public function delete($id)
    {
        Tour::findOrFail($id)->delete();
        session()->flash('message', 'Tour deleted successfully.');
    }

    public function render()
    {
        return view('admin.tours.index', [
            'tours' => Tour::with('category')
                ->where('title', 'like', '%'.$this->search.'%')
                ->orWhere('location', 'like', '%'.$this->search.'%')
                ->orderBy('created_at', 'desc')
                ->paginate(10)
        ]);
    }
}
