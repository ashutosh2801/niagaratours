<?php

namespace App\Livewire\Admin;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use App\Models\Destination;
use Illuminate\Support\Str;

#[Title('Destination Form')]
#[Layout('layouts.admin')]
class DestinationForm extends Component
{
    protected $listeners = ['mediaSelected' => 'setImageFromMedia'];

    public $destinationId = null;
    public $name;
    public $slug;
    public $description;
    public $existingImage;
    public $is_active = true;
    public $is_popular = false;
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
            $this->is_popular = $destination->is_popular;
            $this->sort_order = $destination->sort_order ?? 0;
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
            'is_active' => 'boolean',
            'is_popular' => 'boolean',
            'sort_order' => 'integer|min:0',
        ]);

        $data = [
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'image' => $this->existingImage,
            'is_active' => $this->is_active,
            'is_popular' => $this->is_popular,
            'sort_order' => $this->sort_order,
        ];

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
        $this->existingImage = null;
    }

    public function render()
    {
        return view('admin.destinations.form');
    }
}
