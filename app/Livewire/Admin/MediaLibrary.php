<?php

namespace App\Livewire\Admin;

use App\Models\Media;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\Setting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

#[Title('Media Library')]
#[Layout('layouts.admin')]
class MediaLibrary extends Component
{
    use WithPagination, WithFileUploads;

    public $uploads = [];

    protected function rules()
    {
        return [
            'uploads.*' => ['required', 'file', 'image', 'max:10240'],
        ];
    }

    public function updatedUploads()
    {
        $this->validate();

        $disk = Setting::get('storage_disk', 'public');
        $count = count($this->uploads);

        foreach ($this->uploads as $file) {
            $fileName = Str::random(40) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('media', $fileName, $disk);

            Media::create([
                'name' => $file->getClientOriginalName(),
                'file_name' => $fileName,
                'mime_type' => $file->getMimeType(),
                'disk' => $disk,
                'path' => $path,
                'size' => $file->getSize(),
                'user_id' => Auth::id(),
            ]);
        }

        $this->uploads = [];
        session()->flash('message', $count . ' file(s) uploaded successfully.');
    }

    public function getDisk(): string
    {
        return Setting::get('storage_disk', 'public');
    }

    public function delete($id)
    {
        $media = Media::findOrFail($id);
        Storage::disk($media->disk ?? Setting::get('storage_disk', 'public'))->delete($media->path);
        $media->delete();
        session()->flash('message', 'File deleted successfully.');
    }

    public function render()
    {
        $media = Media::orderBy('created_at', 'desc')->paginate(24);
        return view('components.admin.media-library', compact('media'));
    }
}
