<?php

namespace App\Livewire\Admin;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Order;

#[Title('Orders')]
#[Layout('layouts.admin')]
class OrderList extends Component
{
    use WithPagination;

    public $search = '';
    public $status = '';

    public function render()
    {
        $orders = Order::query()
            ->when($this->search, function ($query) {
                $query->where('order_number', 'like', '%'.$this->search.'%')
                    ->orWhere('customer_name', 'like', '%'.$this->search.'%')
                    ->orWhere('customer_email', 'like', '%'.$this->search.'%');
            })
            ->when($this->status, function ($query) {
                $query->where('status', $this->status);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.orders.index', compact('orders'));
    }
}
