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
    public $quantity = 1;
    public $travel_date;
    public $special_requests;
    public $bookingConfirmed = false;
    public $orderNumber;

    protected function rules()
    {
        return [
            'customer_name' => ['required', 'string', 'max:255'],
            'customer_email' => ['required', 'email', 'max:255'],
            'customer_phone' => ['required', 'string', 'max:20'],
            'quantity' => ['required', 'integer', 'min:1'],
            'travel_date' => ['required', 'date', 'after:today'],
            'special_requests' => ['nullable', 'string', 'max:1000'],
        ];
    }

    public function mount($tour_id = null)
    {
        $this->tour_id = $tour_id;
    }

    public function submit()
    {
        $this->validate();

        $tour = Tour::findOrFail($this->tour_id);

        if ($this->quantity > ($tour->max_people ?? 999)) {
            $this->addError('quantity', 'The number of guests cannot exceed ' . $tour->max_people . '.');
            return;
        }

        $unitPrice = $tour->sale_price ?? $tour->price;
        $subtotal = $unitPrice * $this->quantity;
        $serviceFee = $subtotal * 0.05;

        $order = Order::create([
            'order_number' => 'ORD-' . strtoupper(Str::random(8)),
            'user_id' => Auth::id(),
            'customer_name' => $this->customer_name,
            'customer_email' => $this->customer_email,
            'customer_phone' => $this->customer_phone,
            'subtotal' => $subtotal,
            'tax' => $serviceFee,
            'total' => $subtotal + $serviceFee,
            'status' => 'pending',
        ]);

        OrderItem::create([
            'order_id' => $order->id,
            'tour_id' => $tour->id,
            'tour_title' => $tour->title,
            'price' => $unitPrice,
            'quantity' => $this->quantity,
            'subtotal' => $subtotal,
            'options' => json_encode(['travel_date' => $this->travel_date, 'special_requests' => $this->special_requests]),
        ]);

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
