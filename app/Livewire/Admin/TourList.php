<?php

namespace App\Livewire\Admin;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Tour;
use App\Helpers\ActivityLogger;

#[Title('Tours')]
#[Layout('layouts.admin')]
class TourList extends Component
{
    use WithPagination;

    public $search = '';

    public function delete($id)
    {
        if (!auth()->user()->hasPermission('tours')) {
            abort(403, 'Unauthorized access.');
        }

        $tour = Tour::findOrFail($id);
        $title = $tour->title;
        $tour->delete();
        session()->flash('message', 'Tour deleted successfully.');
        ActivityLogger::log('deleted', 'Tour', "Tour '{$title}' deleted");
    }

    public function render()
    {
        return view('admin.tours.index', [
            'tours' => Tour::with('category', 'destination')
                ->where(function ($q) {
                    $q->where('title', 'like', '%'.$this->search.'%')
                      ->orWhere('location', 'like', '%'.$this->search.'%');
                })
                ->orderBy('created_at', 'desc')
                ->paginate(10)
        ]);
    }
}
