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
    public $selectedIds = [];

    public function delete($id)
    {
        if (!auth()->user()->hasPermission('pages')) {
            abort(403, 'Unauthorized access.');
        }

        $page = Page::findOrFail($id);
        $title = $page->title;
        $page->delete();
        $this->selectedIds = array_diff($this->selectedIds, [$id]);
        session()->flash('message', 'Page deleted successfully.');
        ActivityLogger::log('deleted', 'Page', "Page '{$title}' deleted");
    }

    public function deleteSelected()
    {
        if (!auth()->user()->hasPermission('pages')) {
            abort(403, 'Unauthorized access.');
        }

        $pages = Page::whereIn('id', $this->selectedIds)->get();
        foreach ($pages as $page) {
            $page->delete();
            ActivityLogger::log('deleted', 'Page', "Page '{$page->title}' deleted");
        }

        $count = count($this->selectedIds);
        $this->selectedIds = [];
        session()->flash('message', "{$count} page(s) deleted successfully.");
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
        return Page::where('title', 'like', '%'.$this->search.'%')
            ->orderBy('created_at', 'desc');
    }

    public function render()
    {
        return view('components.admin.page-list', [
            'pages' => $this->query()->paginate(10),
        ]);
    }
}
