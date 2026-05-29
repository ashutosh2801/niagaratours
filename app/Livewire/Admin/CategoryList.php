<?php

namespace App\Livewire\Admin;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Category;
use App\Helpers\ActivityLogger;

#[Title('Categories')]
#[Layout('layouts.admin')]
class CategoryList extends Component
{
    use WithPagination;

    public $search = '';
    public $selectedIds = [];

    public function delete($id)
    {
        if (!auth()->user()->hasPermission('categories')) {
            abort(403, 'Unauthorized access.');
        }

        $category = Category::findOrFail($id);
        $name = $category->name;
        $category->delete();
        $this->selectedIds = array_diff($this->selectedIds, [$id]);
        session()->flash('message', 'Category deleted successfully.');
        ActivityLogger::log('deleted', 'Category', "Category '{$name}' deleted");
    }

    public function deleteSelected()
    {
        if (!auth()->user()->hasPermission('categories')) {
            abort(403, 'Unauthorized access.');
        }

        $categories = Category::whereIn('id', $this->selectedIds)->get();
        foreach ($categories as $category) {
            $category->delete();
            ActivityLogger::log('deleted', 'Category', "Category '{$category->name}' deleted");
        }

        $count = count($this->selectedIds);
        $this->selectedIds = [];
        session()->flash('message', "{$count} category(ies) deleted successfully.");
    }

    public function toggleActive($id)
    {
        if (!auth()->user()->hasPermission('categories')) {
            abort(403, 'Unauthorized access.');
        }

        $category = Category::findOrFail($id);
        $category->update(['is_active' => !$category->is_active]);
        $status = $category->is_active ? 'activated' : 'deactivated';
        ActivityLogger::log('updated', 'Category', "Category '{$category->name}' {$status}");
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
        return Category::where('name', 'like', '%'.$this->search.'%')
            ->orderBy('sort_order')
            ->orderBy('name');
    }

    public function render()
    {
        return view('admin.categories.index', [
            'categories' => $this->query()->paginate(10),
        ]);
    }
}
