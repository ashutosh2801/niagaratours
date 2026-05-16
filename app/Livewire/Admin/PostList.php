<?php

namespace App\Livewire\Admin;

use App\Models\Post;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Blog Posts')]
#[Layout('layouts.admin')]
class PostList extends Component
{
    use WithPagination;

    public $editId = null;
    public $title = '';
    public $slug = '';
    public $excerpt = '';
    public $content = '';
    public $author = '';
    public $featured_image = '';
    public $is_active = true;

    public function save()
    {
        $this->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string',
            'content' => 'nullable|string',
            'author' => 'nullable|string|max:255',
        ]);

        Post::updateOrCreate(['id' => $this->editId], [
            'title' => $this->title,
            'excerpt' => $this->excerpt,
            'content' => $this->content,
            'author' => $this->author,
            'featured_image' => $this->featured_image,
            'is_active' => $this->is_active,
            'published_at' => $this->editId ? null : now(),
        ]);

        $this->resetForm();
        $this->successMessage = 'Post saved successfully.';
    }

    public function edit($id)
    {
        $post = Post::findOrFail($id);
        $this->editId = $post->id;
        $this->title = $post->title;
        $this->slug = $post->slug;
        $this->excerpt = $post->excerpt;
        $this->content = $post->content;
        $this->author = $post->author;
        $this->featured_image = $post->featured_image;
        $this->is_active = $post->is_active;
    }

    public function delete($id)
    {
        Post::findOrFail($id)->delete();
    }

    public function toggleActive($id)
    {
        $post = Post::findOrFail($id);
        $post->update(['is_active' => !$post->is_active]);
    }

    public function resetForm()
    {
        $this->reset(['editId', 'title', 'slug', 'excerpt', 'content', 'author', 'featured_image', 'is_active']);
    }

    public function render()
    {
        return view('components.admin.post-list', [
            'posts' => Post::orderBy('created_at', 'desc')->paginate(10),
        ]);
    }
}
