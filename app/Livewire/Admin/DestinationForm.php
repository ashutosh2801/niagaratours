<?php

namespace App\Livewire\Admin;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Destination;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

#[Title('Destination Form')]
#[Layout('layouts.admin')]
class DestinationForm extends Component
{
    use WithFileUploads;

    public $destinationId = null;
    public $name;
    public $slug;
    public $description;
    public $image;
    public $existingImage;
    public $is_active = true;
    public $sort_order = 0;

    public function mount($destinationId = null)
    {
        $this->destinationId = $destinationId;

        if ($this->destinationId) {
            $destination = Destination::findOrFail($this->destinationId);
            $this->name = $destination->name;
            $this->slug = $destination->slug;
            $this->description = $destination->description;
            $this->existingImage = $destination->image;
            $this->is_active = $destination->is_active;
            $this->sort_order = $destination->sort_order ?? 0;
        }
    }

    public function updatedName($value)
    {
        if (empty($this->slug) || $this->destinationId === null) {
            $this->slug = Str::slug($value);
        }
    }

    public function save()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:destinations,slug,' . $this->destinationId,
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
            $path = $this->image->store('destinations', 'public');
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

        if ($this->destinationId) {
            $destination = Destination::findOrFail($this->destinationId);
            $destination->update($data);
            session()->flash('message', 'Destination updated successfully.');
        } else {
            Destination::create($data);
            session()->flash('message', 'Destination created successfully.');
        }

        return redirect()->route('admin.destinations');
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
        return view('admin.destinations.form');
    }
}
