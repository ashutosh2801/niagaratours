<?php

namespace App\Livewire\Front;

use App\Models\TourNotification;
use Livewire\Component;

class ContactForm extends Component
{
    public $name;
    public $email;
    public $message;
    public $submitted = false;

    protected function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'message' => ['required', 'string', 'max:5000'],
        ];
    }

    public function submit()
    {
        $this->validate();

        TourNotification::create([
            'type' => 'contact',
            'message' => 'Contact form submission from ' . $this->name . ': ' . $this->message,
        ]);

        $this->submitted = true;
    }

    public function render()
    {
        return view('components.front.contact-form');
    }
}
