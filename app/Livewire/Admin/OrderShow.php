<?php

namespace App\Livewire\Admin;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use App\Models\Order;
use App\Helpers\ActivityLogger;

#[Title('Order Details')]
#[Layout('layouts.admin')]
class OrderShow extends Component
{
    public $orderId;
    public $newStatus;

    public function mount($orderId)
    {
        $this->orderId = $orderId;
        $order = Order::findOrFail($this->orderId);
        $this->newStatus = $order->status;
    }

    public function updateStatus()
    {
        $this->validate([
            'newStatus' => ['required', 'in:' . implode(',', [
                Order::STATUS_PENDING,
                Order::STATUS_CONFIRMED,
                Order::STATUS_PROCESSING,
                Order::STATUS_COMPLETED,
                Order::STATUS_CANCELLED,
                Order::STATUS_REFUNDED,
            ])],
        ]);

        $order = Order::findOrFail($this->orderId);
        $order->update(['status' => $this->newStatus]);
        session()->flash('message', 'Order status updated successfully.');
        ActivityLogger::log('updated', 'Order', "Order #{$order->id} status updated to {$this->newStatus}");
    }

    public function render()
    {
        $order = Order::with(['items.tour', 'payment'])->findOrFail($this->orderId);
        return view('admin.orders.show', compact('order'));
    }
}
