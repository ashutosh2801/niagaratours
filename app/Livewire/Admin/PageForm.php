<?php

namespace App\Livewire\Admin;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use App\Models\Page;
use Illuminate\Support\Str;
use App\Helpers\ActivityLogger;

#[Title('Page Form')]
#[Layout('layouts.admin')]
class PageForm extends Component
{
    public $pageId = null;

    protected $listeners = ['mediaSelected' => 'insertMedia'];

    public function insertMedia($urls)
    {
        $url = is_array($urls) ? ($urls[0] ?? null) : $urls;
        if ($url) {
            $this->content .= "\n<img src=\"" . $url . "\" alt=\"\">\n";
        }
    }

    public function openMediaPicker()
    {
        $this->dispatch('openMediaPicker');
    }

    public $title;
    public $slug;
    public $content;
    public $sections = [];
    public $template = 'default';
    public $is_active = true;
    public $meta_title;
    public $meta_description;

    public function mount($pageId = null)
    {
        $this->pageId = $pageId;

        if ($this->pageId) {
            $page = Page::findOrFail($this->pageId);
            $this->title = $page->title;
            $this->slug = $page->slug;
            $this->content = $page->content;
            $this->sections = $page->sections ?: [];
            $this->template = $page->template;
            $this->is_active = $page->is_active;
            $this->meta_title = $page->meta_title;
            $this->meta_description = $page->meta_description;
        }
    }

    public function updatedTitle($value)
    {
        if (empty($this->slug) || $this->pageId === null) {
            $this->slug = Str::slug($value);
        }
    }

    public function save()
    {
        $this->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:pages,slug,' . $this->pageId,
            'template' => 'required|string|max:50',
            'is_active' => 'boolean',
        ]);

        $data = [
            'title' => $this->title,
            'slug' => $this->slug,
            'content' => $this->content,
            'sections' => $this->sections,
            'template' => $this->template,
            'is_active' => $this->is_active,
            'meta_title' => $this->meta_title,
            'meta_description' => $this->meta_description,
        ];

        if ($this->pageId) {
            $page = Page::findOrFail($this->pageId);
            $page->update($data);
            session()->flash('message', 'Page updated successfully.');
            ActivityLogger::log('updated', 'Page', "Page '{$this->title}' updated");
        } else {
            Page::create($data);
            session()->flash('message', 'Page created successfully.');
            ActivityLogger::log('created', 'Page', "Page '{$this->title}' created");
        }

        return redirect()->route('admin.pages');
    }

    public function render()
    {
        return view('components.admin.page-form');
    }
}
