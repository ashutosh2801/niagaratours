<?php

namespace App\Livewire\Admin;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

#[Title('Category Form')]
#[Layout('layouts.admin')]
class CategoryForm extends Component
{
    use WithFileUploads;

    protected $listeners = ['mediaSelected' => 'setImageFromMedia'];

    public $categoryId = null;
    public $name;
    public $slug;
    public $description;
    public $image;
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
            'image' => 'nullable|image|max:2048',
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0',
        ]);

        $data = [
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'is_active' => $this->is_active,
            'sort_order' => $this->sort_order,
        ];

        if ($this->image) {
            $path = $this->image->store('categories', 'public');
            $data['image'] = Storage::disk('public')->url($path);

            if ($this->existingImage) {
                $oldPath = str_replace(Storage::disk('public')->url('/'), '', $this->existingImage);
                if (Storage::disk('public')->exists($oldPath)) {
                    Storage::disk('public')->delete($oldPath);
                }
            }
        } else {
            $data['image'] = $this->existingImage;
        }

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
        if ($this->existingImage) {
            $oldPath = str_replace(Storage::disk('public')->url('/'), '', $this->existingImage);
            if (Storage::disk('public')->exists($oldPath)) {
                Storage::disk('public')->delete($oldPath);
            }
        }
        $this->existingImage = null;
        $this->image = null;
    }

    public function render()
    {
        return view('admin.categories.form');
    }
}
