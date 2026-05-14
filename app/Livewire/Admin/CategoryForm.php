<?php

namespace App\Livewire\Admin;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use App\Models\Category;
use Illuminate\Support\Str;

#[Title('Category Form')]
#[Layout('layouts.admin')]
class CategoryForm extends Component
{
    protected $listeners = ['mediaSelected' => 'setImageFromMedia'];

    public $categoryId = null;
    public $name;
    public $slug;
    public $description;
    public $existingImage;
    public $is_active = true;
    public $sort_order = 0;

    public function mount($categoryId = null)
    {
        $this->categoryId = $categoryId;

        if ($this->categoryId) {
            $category = Category::findOrFail($this->categoryId);
            $this->name = $category->name;
            $this->slug = $category->slug;
            $this->description = $category->description;
            $this->existingImage = $category->image;
            $this->is_active = $category->is_active;
            $this->sort_order = $category->sort_order ?? 0;
        }
    }

    public function setImageFromMedia($urls)
    {
        $url = is_array($urls) ? ($urls[0] ?? null) : $urls;
        if ($url) {
            $this->existingImage = $url;
        }
    }

    public function updatedName($value)
    {
        if (empty($this->slug) || $this->categoryId === null) {
            $this->slug = Str::slug($value);
        }
    }

    public function save()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:categories,slug,' . $this->categoryId,
            'description' => 'nullable|string',
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0',
        ]);

        $data = [
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'image' => $this->existingImage,
            'is_active' => $this->is_active,
            'sort_order' => $this->sort_order,
        ];

        if ($this->categoryId) {
            $category = Category::findOrFail($this->categoryId);
            $category->update($data);
            session()->flash('message', 'Category updated successfully.');
        } else {
            Category::create($data);
            session()->flash('message', 'Category created successfully.');
        }

        return redirect()->route('admin.categories');
    }

    public function removeImage()
    {
        $this->existingImage = null;
    }

    public function render()
    {
        return view('admin.categories.form');
    }
}
