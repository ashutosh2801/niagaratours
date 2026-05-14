<?php

namespace App\Livewire\Admin;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Payment;

#[Title('Payments')]
#[Layout('layouts.admin')]
class PaymentList extends Component
{
    use WithPagination;

    public $search = '';
    public $status = '';

    public function render()
    {
        $payments = Payment::with('order')
            ->when($this->search, function ($query) {
                $query->where('transaction_id', 'like', '%'.$this->search.'%')
                    ->orWhereHas('order', function ($q) {
                        $q->where('order_number', 'like', '%'.$this->search.'%');
                    });
            })
            ->when($this->status, function ($query) {
                $query->where('status', $this->status);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.payments.index', compact('payments'));
    }
}
