<?php

namespace App\Livewire\Admin;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use App\Models\Menu;
use App\Models\Tour;
use App\Models\Category;

#[Title('Menu Manager')]
#[Layout('layouts.admin')]
class MenuList extends Component
{
    public $editId = null;
    public $label = '';
    public $url = '';
    public $route = '';
    public $parent_id = '';
    public $sort_order = 0;
    public $is_active = true;
    public $showForm = false;

    public function create()
    {
        $this->resetForm();
        $this->editId = null;
        $this->sort_order = Menu::max('sort_order') + 1;
        $this->showForm = true;
    }

    public function edit($id)
    {
        $menu = Menu::findOrFail($id);
        $this->editId = $menu->id;
        $this->label = $menu->label;
        $this->url = $menu->getRawOriginal('url');
        $this->route = $menu->route;
        $this->parent_id = $menu->parent_id ?? '';
        $this->sort_order = $menu->sort_order;
        $this->is_active = $menu->is_active;
        $this->showForm = true;
    }

    public function save()
    {
        $this->validate([
            'label' => 'required|string|max:255',
            'url' => 'nullable|string|max:255',
            'route' => 'nullable|string|max:255',
            'parent_id' => 'nullable|exists:menus,id',
            'sort_order' => 'required|integer|min:0',
            'is_active' => 'boolean',
        ]);

        $data = [
            'label' => $this->label,
            'url' => $this->url,
            'route' => $this->route,
            'parent_id' => $this->parent_id ?: null,
            'sort_order' => $this->sort_order,
            'is_active' => $this->is_active,
        ];

        if ($this->editId) {
            Menu::findOrFail($this->editId)->update($data);
            session()->flash('message', 'Menu item updated.');
        } else {
            Menu::create($data);
            session()->flash('message', 'Menu item created.');
        }

        $this->showForm = false;
        $this->resetForm();
    }

    public function delete($id)
    {
        Menu::findOrFail($id)->delete();
        session()->flash('message', 'Menu item deleted.');
    }

    public function cancel()
    {
        $this->showForm = false;
        $this->resetForm();
    }

    private function resetForm()
    {
        $this->label = '';
        $this->url = '';
        $this->route = '';
        $this->parent_id = '';
        $this->sort_order = 0;
        $this->is_active = true;
        $this->editId = null;
    }

    public function addTour($id)
    {
        $tour = Tour::findOrFail($id);
        $exists = Menu::where('label', $tour->title)->exists();
        if ($exists) {
            session()->flash('message', '"' . $tour->title . '" is already in the menu.');
            return;
        }
        Menu::create([
            'label' => $tour->title,
            'url' => '/tour/' . $tour->slug,
            'sort_order' => Menu::max('sort_order') + 1,
            'is_active' => true,
        ]);
        session()->flash('message', '"' . $tour->title . '" added to menu.');
    }

    public function addCategory($id)
    {
        $category = Category::findOrFail($id);
        $exists = Menu::where('label', $category->name)->exists();
        if ($exists) {
            session()->flash('message', '"' . $category->name . '" is already in the menu.');
            return;
        }
        Menu::create([
            'label' => $category->name,
            'url' => '/tours?category=' . $category->slug,
            'sort_order' => Menu::max('sort_order') + 1,
            'is_active' => true,
        ]);
        session()->flash('message', '"' . $category->name . '" added to menu.');
    }

    public function render()
    {
        return view('components.admin.menu-list', [
            'menus' => Menu::with('children')->whereNull('parent_id')->orderBy('sort_order')->get(),
            'parentOptions' => Menu::whereNull('parent_id')->orderBy('sort_order')->get(),
            'tours' => Tour::where('is_active', true)->orderBy('title')->get(['id', 'title', 'slug']),
            'categories' => Category::where('is_active', true)->orderBy('name')->get(['id', 'name', 'slug']),
        ]);
    }
}
