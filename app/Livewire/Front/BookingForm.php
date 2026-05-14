<?php

namespace App\Livewire\Front;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Tour;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class BookingForm extends Component
{
    public $tour_id;
    public $customer_name;
    public $customer_email;
    public $customer_phone;
    public $travel_date;
    public $special_requests;
    public $bookingConfirmed = false;
    public $orderNumber;

    public $bookingData = [];
    public $pricingCategories = [];
    public $pricingType = 'per_person';

    protected function rules()
    {
        return [
            'customer_name' => ['required', 'string', 'max:255'],
            'customer_email' => ['required', 'email', 'max:255'],
            'customer_phone' => ['required', 'string', 'max:20'],
            'travel_date' => ['required', 'date', 'after:today'],
            'special_requests' => ['nullable', 'string', 'max:1000'],
        ];
    }

    public function mount($tour_id = null)
    {
        $data = session('booking_data', []);
        $this->bookingData = $data;
        $this->tour_id = $data['tour_id'] ?? $tour_id;
        $this->travel_date = $data['travel_date'] ?? now()->addDay()->format('Y-m-d');

        if ($this->tour_id) {
            $tour = Tour::find($this->tour_id);
            if ($tour) {
                $this->pricingCategories = $tour->pricing_categories;
                $this->pricingType = $tour->pricing_type;
            }
        }
    }

    public function incrementQuantity($category)
    {
        $qty = ($this->bookingData['quantities'][$category] ?? 0) + 1;
        $this->bookingData['quantities'][$category] = $qty;
        session()->put('booking_data', $this->bookingData);
    }

    public function decrementQuantity($category)
    {
        $current = $this->bookingData['quantities'][$category] ?? 0;
        $this->bookingData['quantities'][$category] = max(0, $current - 1);
        session()->put('booking_data', $this->bookingData);
    }

    public function getSubtotalProperty()
    {
        $quantities = $this->bookingData['quantities'] ?? [];
        $total = 0;
        foreach ($this->pricingCategories as $item) {
            $qty = $quantities[$item['category']] ?? 0;
            if ($qty < 1) continue;
            $price = $item['sale_price'] ?? $item['price'] ?? 0;
            $total += $price * $qty;
        }
        return $total;
    }

    public function getServiceFeeProperty()
    {
        return $this->subtotal * 0.05;
    }

    public function getGrandTotalProperty()
    {
        return $this->subtotal + $this->serviceFee;
    }

    public function getTotalGuestsProperty()
    {
        return array_sum($this->bookingData['quantities'] ?? []);
    }

    public function submit()
    {
        $this->validate();

        $tour = Tour::findOrFail($this->tour_id);
        $quantities = $this->bookingData['quantities'] ?? [];

        $totalGuests = array_sum($quantities);
        if ($totalGuests < 1) {
            $this->addError('travel_date', 'No guests selected. Please select at least one guest.');
            return;
        }

        $categories = $tour->pricing_categories;
        $subtotal = 0;
        $orderItemsData = [];

        foreach ($categories as $item) {
            $qty = $quantities[$item['category']] ?? 0;
            $minQty = $item['min_qty'] ?? 0;
            if ($qty > 0 && $qty < $minQty) {
                $this->addError('travel_date', $item['label'] . ' requires a minimum of ' . $minQty . ' guests.');
                return;
            }
            if ($qty < 1) continue;

            $price = $item['sale_price'] ?? $item['price'] ?? 0;
            $lineTotal = $price * $qty;
            $subtotal += $lineTotal;

            $orderItemsData[] = [
                'category' => $item['category'],
                'label' => $item['label'],
                'price' => $price,
                'quantity' => $qty,
                'line_total' => $lineTotal,
            ];
        }

        $serviceFee = $subtotal * 0.05;
        $total = $subtotal + $serviceFee;

        $order = Order::create([
            'order_number' => 'ORD-' . strtoupper(Str::random(8)),
            'user_id' => Auth::id(),
            'customer_name' => $this->customer_name,
            'customer_email' => $this->customer_email,
            'customer_phone' => $this->customer_phone,
            'subtotal' => $subtotal,
            'tax' => $serviceFee,
            'total' => $total,
            'status' => 'pending',
            'travel_details' => [
                'travel_date' => $this->travel_date,
                'pricing_type' => $this->pricingType,
                'categories' => $orderItemsData,
            ],
        ]);

        foreach ($orderItemsData as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'tour_id' => $tour->id,
                'tour_title' => $tour->title . ' (' . $item['label'] . ')',
                'price' => $item['price'],
                'quantity' => $item['quantity'],
                'subtotal' => $item['line_total'],
                'options' => json_encode([
                    'category' => $item['category'],
                    'label' => $item['label'],
                    'travel_date' => $this->travel_date,
                    'special_requests' => $this->special_requests,
                ]),
            ]);
        }

        session()->forget('booking_data');

        $this->orderNumber = $order->order_number;
        $this->bookingConfirmed = true;
    }

    public function render()
    {
        $tour = Tour::find($this->tour_id);
        return view('components.front.booking-form', [
            'tour' => $tour,
        ]);
    }
}
