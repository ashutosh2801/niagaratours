<?php

namespace App\Livewire\Admin;

use App\Models\NewsletterSubscription;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Newsletter Subscribers')]
#[Layout('layouts.admin')]
class NewsletterList extends Component
{
    use WithPagination;

    public function delete($id)
    {
        NewsletterSubscription::findOrFail($id)->delete();
    }

    public function render()
    {
        return view('components.admin.newsletter-list', [
            'subscribers' => NewsletterSubscription::orderBy('created_at', 'desc')->paginate(20),
        ]);
    }
}
