<?php

namespace App\Livewire\Admin;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use App\Models\Tour;
use App\Models\Category;
use App\Models\Destination;
use Illuminate\Support\Str;
use App\Helpers\ActivityLogger;

#[Title('Tour Form')]
#[Layout('layouts.admin')]
class TourForm extends Component
{
    public $tourId = null;

    public $title;
    public $slug;
    public $short_description;
    public $description;
    public $category_id;
    public $destination_id;
    public $location;
    public $duration;
    public $duration_type = 'hours';
    public $price;
    public $sale_price;
    public $max_people;
    public $pricingType = 'per_person';
    public $pricing = [];
    public $images = [];
    public $featured_image;
    public $highlights = [];
    public $inclusions = [];
    public $exclusions = [];
    public $itinerary = [];
    public $faqs = [];
    public $is_featured = false;
    public $is_active = true;
    public $booking_type = 'internal';
    public $booking_url;
    public $meta_title;
    public $meta_description;

    protected $listeners = ['mediaSelected' => 'addMediaImages'];

    public function addMediaImages($urls)
    {
        if (is_array($urls)) {
            foreach ($urls as $url) {
                if (!in_array($url, $this->images)) {
                    $this->images[] = $url;
                }
            }
        }
    }

    public function mount($tourId = null)
    {
        $this->tourId = $tourId;

        $this->pricingType = 'per_person';
        $this->pricing = [['category' => 'adult', 'label' => 'Adult', 'price' => null, 'sale_price' => null, 'min_qty' => 1]];

        if ($this->tourId) {
            $tour = Tour::findOrFail($this->tourId);
            $this->title = $tour->title;
            $this->slug = $tour->slug;
            $this->short_description = $tour->short_description;
            $this->description = $tour->description;
            $this->category_id = $tour->category_id;
            $this->destination_id = $tour->destination_id;
            $this->location = $tour->location;
            $this->duration = $tour->duration;
            $this->duration_type = $tour->duration_type;
            $this->price = $tour->price;
            $this->sale_price = $tour->sale_price;
            $this->max_people = $tour->max_people;
            $this->images = $tour->images ?: [];
            $this->featured_image = $tour->featured_image;
            $this->highlights = $tour->highlights ?: [];
            $this->inclusions = $tour->inclusions ?: [];
            $this->exclusions = $tour->exclusions ?: [];
            $this->itinerary = $tour->itinerary ?: [];
            $this->faqs = $tour->faqs ?: [];
            $this->is_featured = $tour->is_featured;
            $this->is_active = $tour->is_active;
            $this->booking_type = $tour->booking_type ?? 'internal';
            $this->booking_url = $tour->booking_url;
            $this->meta_title = $tour->meta_title;
            $this->meta_description = $tour->meta_description;

            $raw = $tour->pricing;
            if (is_array($raw) && isset($raw['type'])) {
                $this->pricingType = $raw['type'];
                $this->pricing = $raw['categories'] ?? [];
            } elseif (is_array($raw) && isset($raw[0])) {
                $this->pricingType = 'per_person';
                $this->pricing = collect($raw)->map(fn($item) => [
                    'category' => $item['category'] ?? Str::slug($item['label'] ?? ''),
                    'label' => $item['label'] ?? '',
                    'price' => $item['price'] ?? null,
                    'sale_price' => $item['sale_price'] ?? null,
                    'min_qty' => $item['min_qty'] ?? 0,
                ])->values()->toArray();
            }
        }
    }

    public function updatedTitle($value)
    {
        if (empty($this->slug) || $this->tourId === null) {
            $this->slug = Str::slug($value);
        }
    }

    public function openMediaPicker()
    {
        $this->dispatch('openMediaPicker');
    }

    public function removeImage($index)
    {
        $removed = $this->images[$index] ?? null;
        array_splice($this->images, $index, 1);
        if ($this->featured_image === $removed) {
            $this->featured_image = !empty($this->images) ? $this->images[0] : null;
        }
    }

    public function setFeaturedImage($index)
    {
        $this->featured_image = $this->images[$index] ?? null;
    }

    public function addHighlight()
    {
        $this->highlights[] = '';
    }

    public function removeHighlight($index)
    {
        array_splice($this->highlights, $index, 1);
    }

    public function addInclusion()
    {
        $this->inclusions[] = '';
    }

    public function removeInclusion($index)
    {
        array_splice($this->inclusions, $index, 1);
    }

    public function addExclusion()
    {
        $this->exclusions[] = '';
    }

    public function removeExclusion($index)
    {
        array_splice($this->exclusions, $index, 1);
    }

    public function addItineraryItem()
    {
        $this->itinerary[] = ['title' => '', 'description' => ''];
    }

    public function removeItineraryItem($index)
    {
        array_splice($this->itinerary, $index, 1);
    }

    public function addFaq()
    {
        $this->faqs[] = ['question' => '', 'answer' => ''];
    }

    public function removeFaq($index)
    {
        array_splice($this->faqs, $index, 1);
    }

    public function addPricingRow()
    {
        $this->pricing[] = ['category' => '', 'label' => '', 'price' => null, 'sale_price' => null, 'min_qty' => 0];
    }

    public function removePricingRow($index)
    {
        array_splice($this->pricing, $index, 1);
    }

    public function save()
    {
        if (!auth()->user()->hasPermission('tours')) {
            abort(403, 'Unauthorized access.');
        }

        $this->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:tours,slug,' . $this->tourId,
            'category_id' => 'nullable|exists:categories,id',
            'destination_id' => 'nullable|exists:destinations,id',
            'location' => 'nullable|string|max:255',
            'duration' => 'nullable|integer|min:1',
            'duration_type' => 'required|in:minutes,hours,days,weeks',
            'max_people' => 'nullable|integer|min:1',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
            'booking_type' => 'required|in:internal,external',
            'booking_url' => 'nullable|required_if:booking_type,external|url|max:500',
            'pricingType' => 'required|in:per_person,fixed',
            'pricing.*.label' => 'required|string|max:255',
            'pricing.*.price' => 'nullable|numeric|min:0',
            'pricing.*.min_qty' => 'nullable|integer|min:0',
        ]);

        $pricingData = [
            'type' => $this->pricingType,
            'categories' => collect($this->pricing)->map(function ($item) {
                return [
                    'category' => $item['category'] ?: \Illuminate\Support\Str::slug($item['label']),
                    'label' => $item['label'],
                    'price' => $item['price'] ? (float) $item['price'] : null,
                    'sale_price' => isset($item['sale_price']) && $item['sale_price'] !== '' ? (float) $item['sale_price'] : null,
                    'min_qty' => (int) ($item['min_qty'] ?? 0),
                ];
            })->values()->toArray(),
        ];

        $prices = collect($pricingData['categories']);
        $this->price = $prices->pluck('sale_price')->merge($prices->pluck('price'))->filter(fn($v) => !is_null($v) && $v > 0)->sort()->first() ?? 0;
        $this->sale_price = $prices->pluck('sale_price')->filter(fn($v) => !is_null($v) && $v > 0)->sort()->first();

        $this->description = \Stevebauman\Purify\Facades\Purify::clean($this->description);
        $this->itinerary = collect($this->itinerary)->map(fn($day) => [
            ...$day,
            'description' => \Stevebauman\Purify\Facades\Purify::clean($day['description'] ?? ''),
        ])->toArray();
        $this->faqs = collect($this->faqs)->map(fn($faq) => [
            ...$faq,
            'answer' => \Stevebauman\Purify\Facades\Purify::clean($faq['answer'] ?? ''),
        ])->toArray();

        $data = [
            'title' => $this->title,
            'slug' => $this->slug,
            'short_description' => $this->short_description,
            'description' => $this->description,
            'category_id' => $this->category_id,
            'destination_id' => $this->destination_id,
            'location' => $this->location,
            'duration' => $this->duration,
            'duration_type' => $this->duration_type,
            'price' => $this->price,
            'sale_price' => $this->sale_price,
            'max_people' => $this->max_people !== '' ? $this->max_people : null,
            'pricing' => $pricingData,
            'images' => $this->images,
            'featured_image' => $this->featured_image,
            'highlights' => $this->highlights,
            'inclusions' => $this->inclusions,
            'exclusions' => $this->exclusions,
            'itinerary' => $this->itinerary,
            'faqs' => $this->faqs,
            'is_featured' => $this->is_featured,
            'is_active' => $this->is_active,
            'booking_type' => $this->booking_type,
            'booking_url' => $this->booking_url,
            'meta_title' => $this->meta_title,
            'meta_description' => $this->meta_description,
        ];

        if ($this->tourId) {
            $tour = Tour::findOrFail($this->tourId);
            $tour->update($data);
            session()->flash('message', 'Tour updated successfully.');
            ActivityLogger::log('updated', 'Tour', "Tour '{$this->title}' updated");
        } else {
            Tour::create($data);
            session()->flash('message', 'Tour created successfully.');
            ActivityLogger::log('created', 'Tour', "Tour '{$this->title}' created");
        }

        return redirect()->route('admin.tours');
    }

    public function render()
    {
        return view('admin.tours.form', [
            'categories' => Category::orderBy('name', 'asc')->get(),
            'destinations' => Destination::orderBy('name', 'asc')->get()
        ]);
    }
}
