<?php

namespace App\Livewire\Admin;

use App\Models\NewsletterSubscription;
use App\Helpers\ActivityLogger;
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
        if (!auth()->user()->hasPermission('newsletter')) {
            abort(403, 'Unauthorized access.');
        }

        $subscriber = NewsletterSubscription::findOrFail($id);
        $email = $subscriber->email;
        $subscriber->delete();
        ActivityLogger::log('deleted', 'Newsletter', "Subscriber '{$email}' deleted");
    }

    public function render()
    {
        return view('components.admin.newsletter-list', [
            'subscribers' => NewsletterSubscription::orderBy('created_at', 'desc')->paginate(20),
        ]);
    }
}
