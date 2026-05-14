<?php

namespace App\Livewire\Admin;

use App\Models\Media;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
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

        $count = count($this->uploads);

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
        session()->flash('message', $count . ' file(s) uploaded successfully.');
    }

    public function delete($id)
    {
        $media = Media::findOrFail($id);
        Storage::disk($media->disk)->delete($media->path);
        $media->delete();
        session()->flash('message', 'File deleted successfully.');
    }

    public function render()
    {
        $media = Media::orderBy('created_at', 'desc')->paginate(24);
        return view('components.admin.media-library', compact('media'));
    }
}
