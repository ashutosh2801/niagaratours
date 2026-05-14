<?php

namespace App\Livewire\Front;

use App\Models\Tour;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class TourDetail extends Component
{
    public $slug;
    public $quantities = [];
    public $travelDate;

    public function mount($slug)
    {
        $this->slug = $slug;
        $this->travelDate = now()->addDay()->format('Y-m-d');
    }

    public function getTour()
    {
        return Tour::where('slug', $this->slug)
            ->where('is_active', true)
            ->with(['category', 'destination', 'orderItems'])
            ->first();
    }

    public function getPricingProperty()
    {
        $tour = $this->getTour();
        return $tour->pricing_categories;
    }

    public function getPricingTypeProperty()
    {
        $tour = $this->getTour();
        return $tour->pricing_type;
    }

    public function incrementQuantity($category)
    {
        $this->quantities[$category] = ($this->quantities[$category] ?? 0) + 1;
    }

    public function decrementQuantity($category)
    {
        $current = $this->quantities[$category] ?? 0;
        $this->quantities[$category] = max(0, $current - 1);
    }

    public function getSubtotalProperty()
    {
        $tour = $this->getTour();
        $pricing = $tour->pricing_categories;
        $total = 0;

        foreach ($pricing as $item) {
            $qty = $this->quantities[$item['category']] ?? 0;
            $price = $item['sale_price'] ?? $item['price'] ?? 0;
            $total += $price * $qty;
        }

        return $total;
    }

    public function getTaxProperty()
    {
        return $this->subtotal * 0.13;
    }

    public function getTotalProperty()
    {
        return $this->subtotal + $this->tax;
    }

    public function getTotalGuestsProperty()
    {
        return array_sum($this->quantities);
    }

    public function bookNow()
    {
        $tour = $this->getTour();

        if (!$tour) {
            abort(404);
        }

        if ($this->totalGuests < 1) {
            session()->flash('error', 'Please select at least one guest.');
            return;
        }

        $pricing = $tour->pricing_categories;
        foreach ($pricing as $item) {
            $qty = $this->quantities[$item['category']] ?? 0;
            $min = $item['min_qty'] ?? 0;
            if ($qty > 0 && $qty < $min) {
                session()->flash('error', $item['label'] . ' requires a minimum of ' . $min . ' guests.');
                return;
            }
        }

        session()->put('booking_data', [
            'tour_id' => $tour->id,
            'travel_date' => $this->travelDate,
            'quantities' => $this->quantities,
            'subtotal' => $this->subtotal,
            'tax' => $this->tax,
            'total' => $this->total,
        ]);

        return redirect()->route('booking', ['tour_id' => $tour->id]);
    }

    public function render()
    {
        $tour = $this->getTour();

        if (!$tour) {
            abort(404);
        }

        $pricing = $tour->pricing_categories;
        $pricingType = $tour->pricing_type;

        return view('components.front.tour-detail', [
            'tour' => $tour,
            'pricing' => $pricing,
            'pricingType' => $pricingType,
        ]);
    }
}
