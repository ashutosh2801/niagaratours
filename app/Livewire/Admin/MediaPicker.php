<?php

namespace App\Livewire\Admin;

use App\Models\Media;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MediaPicker extends Component
{
    use WithFileUploads;

    public $show = false;
    public $uploads = [];
    public $selectedIds = [];

    protected $listeners = ['openMediaPicker' => 'open'];

    protected function rules()
    {
        return [
            'uploads.*' => ['required', 'file', 'image', 'max:10240'],
        ];
    }

    public function open()
    {
        $this->show = true;
        $this->selectedIds = [];
    }

    public function close()
    {
        $this->show = false;
    }

    public function toggleSelect($id)
    {
        if (in_array($id, $this->selectedIds)) {
            $this->selectedIds = array_values(array_diff($this->selectedIds, [$id]));
        } else {
            $this->selectedIds[] = $id;
        }
    }

    public function select()
    {
        if (empty($this->selectedIds)) return;

        $urls = Media::whereIn('id', $this->selectedIds)->pluck('path', 'id')->map(function ($path) {
            return asset('storage/' . $path);
        })->values()->toArray();

        $this->dispatch('mediaSelected', urls: $urls, ids: $this->selectedIds);
        $this->close();
    }

    public function updatedUploads()
    {
        $this->validate();

        foreach ($this->uploads as $file) {
            $fileName = Str::random(40) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('media', $fileName, 'public');

            Media::create([
                'name' => $file->getClientOriginalName(),
                'file_name' => $fileName,
                'mime_type' => $file->getMimeType(),
                'disk' => 'public',
                'path' => $path,
                'size' => $file->getSize(),
                'user_id' => Auth::id(),
            ]);
        }

        $this->uploads = [];
    }

    public function render()
    {
        $media = Media::orderBy('created_at', 'desc')->get();
        return view('components.admin.media-picker', compact('media'));
    }
}
