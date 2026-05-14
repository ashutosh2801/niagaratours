<?php

namespace App\Livewire\Front;

use App\Models\Page;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class PageShow extends Component
{
    public Page $page;

    public function mount($page)
    {
        $this->page = Page::where('slug', $page)->where('is_active', true)->firstOrFail();
    }

    public function render()
    {
        return view('front.page-show');
    }
}
