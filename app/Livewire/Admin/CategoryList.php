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

    public function delete($id)
    {
        $category = Category::findOrFail($id);
        $name = $category->name;
        $category->delete();
        session()->flash('message', 'Category deleted successfully.');
        ActivityLogger::log('deleted', 'Category', "Category '{$name}' deleted");
    }

    public function render()
    {
        $categories = Category::where('name', 'like', '%'.$this->search.'%')
            ->orderBy('sort_order')
            ->orderBy('name')
            ->paginate(10);

        return view('admin.categories.index', compact('categories'));
    }
}
