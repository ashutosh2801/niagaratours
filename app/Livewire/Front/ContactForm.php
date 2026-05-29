<?php

namespace App\Livewire\Front;

use App\Models\TourNotification;
use Livewire\Component;

class ContactForm extends Component
{
    public $name = '';
    public $email = '';
    public $subject = '';
    public $message = '';
    public $submitted = false;
    public int $formKey = 0;

    protected function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'subject' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string', 'max:5000'],
        ];
    }

    public function submitContact(): void
    {
        $validated = $this->validate();

        TourNotification::create([
            'type' => 'contact',
            'name' => $validated['name'],
            'email' => $validated['email'],
            'subject' => $validated['subject'],
            'message' => $validated['message'],
        ]);

        $this->reset(['name', 'email', 'subject', 'message']);
        $this->resetValidation();
        $this->submitted = true;
        $this->formKey++;
    }

    public function render()
    {
        return view('components.front.contact-form');
    }
}
