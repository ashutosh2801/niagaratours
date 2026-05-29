<?php

namespace App\Livewire\Admin;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Page;
use App\Helpers\ActivityLogger;

#[Title('Pages')]
#[Layout('layouts.admin')]
class PageList extends Component
{
    use WithPagination;

    public $search = '';

    public function delete($id)
    {
        if (!auth()->user()->hasPermission('pages')) {
            abort(403, 'Unauthorized access.');
        }

        $page = Page::findOrFail($id);
        $title = $page->title;
        $page->delete();
        session()->flash('message', 'Page deleted successfully.');
        ActivityLogger::log('deleted', 'Page', "Page '{$title}' deleted");
    }

    public function render()
    {
        $pages = Page::where('title', 'like', '%'.$this->search.'%')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('components.admin.page-list', compact('pages'));
    }
}
