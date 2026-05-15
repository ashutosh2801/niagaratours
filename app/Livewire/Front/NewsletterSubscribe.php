<?php

namespace App\Livewire\Front;

use App\Models\NewsletterSubscription;
use Livewire\Component;

class NewsletterSubscribe extends Component
{
    public $email = '';
    public $successMessage = '';
    public $errorMessage = '';

    public function subscribe()
    {
        $this->validate(['email' => 'required|email|max:255']);

        $exists = NewsletterSubscription::where('email', $this->email)->first();
        if ($exists) {
            $this->errorMessage = 'This email is already subscribed.';
            return;
        }

        NewsletterSubscription::create(['email' => $this->email]);
        $this->successMessage = 'Thank you for subscribing!';
        $this->email = '';
    }

    public function render()
    {
        return view('components.front.newsletter-subscribe');
    }
}
