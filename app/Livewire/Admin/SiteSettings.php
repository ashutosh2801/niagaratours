<?php

namespace App\Livewire\Admin;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use App\Models\Setting;

#[Title('Site Settings')]
#[Layout('layouts.admin')]
class SiteSettings extends Component
{
    public $site_name;
    public $site_tagline;
    public $site_description;
    public $meta_title;
    public $meta_description;
    public $meta_keywords;
    public $contact_email;
    public $contact_phone;
    public $contact_address;
    public $social_facebook;
    public $social_twitter;
    public $social_instagram;
    public $social_youtube;
    public $logo;
    public $favicon;

    protected $listeners = ['mediaSelected' => 'setMedia'];

    public function setMedia($urls)
    {
        $url = is_array($urls) ? ($urls[0] ?? null) : $urls;
        if (!$url) return;

        $target = session('mediaPickerTarget', 'logo');
        session()->forget('mediaPickerTarget');
        if ($target === 'logo') {
            $this->logo = $url;
        } elseif ($target === 'favicon') {
            $this->favicon = $url;
        }
    }

    public function openMediaPickerFor($target)
    {
        session()->put('mediaPickerTarget', $target);
    }

    public function mount()
    {
        $keys = [
            'site_name', 'site_tagline', 'site_description',
            'meta_title', 'meta_description', 'meta_keywords',
            'contact_email', 'contact_phone', 'contact_address',
            'social_facebook', 'social_twitter', 'social_instagram', 'social_youtube',
            'logo', 'favicon',
        ];
        foreach ($keys as $key) {
            $this->$key = Setting::get($key, '');
        }
    }

    public function save()
    {
        $this->validate([
            'site_name' => 'required|string|max:255',
            'contact_email' => 'nullable|email|max:255',
        ]);

        $data = [
            'site_name' => $this->site_name,
            'site_tagline' => $this->site_tagline,
            'site_description' => $this->site_description,
            'meta_title' => $this->meta_title,
            'meta_description' => $this->meta_description,
            'meta_keywords' => $this->meta_keywords,
            'contact_email' => $this->contact_email,
            'contact_phone' => $this->contact_phone,
            'contact_address' => $this->contact_address,
            'social_facebook' => $this->social_facebook,
            'social_twitter' => $this->social_twitter,
            'social_instagram' => $this->social_instagram,
            'social_youtube' => $this->social_youtube,
            'logo' => $this->logo,
            'favicon' => $this->favicon,
        ];

        foreach ($data as $key => $value) {
            Setting::set($key, $value);
        }

        session()->flash('message', 'Settings saved successfully.');
    }

    public function render()
    {
        return view('components.admin.site-settings');
    }
}
