<?php

namespace App\Livewire\Admin;

use Livewire\Attributes\Layout;
use Livewire\Component;
use App\Models\Tour;
use App\Models\Order;
use App\Models\User;
use App\Models\TourNotification;

#[Layout('layouts.admin')]
class DashboardStats extends Component
{
    public $totalTours;
    public $totalOrders;
    public $totalRevenue;
    public $pendingOrders;
    public $totalUsers;
    public $unreadNotifications;

    public function mount()
    {
        $this->totalTours = Tour::count();
        $this->totalOrders = Order::count();
        $this->totalRevenue = Order::where('status', 'completed')->sum('total');
        $this->pendingOrders = Order::where('status', 'pending')->count();
        $this->totalUsers = User::count();
        $this->unreadNotifications = TourNotification::where('is_read', false)->count();
    }

    public function render()
    {
        return view('components.admin.dashboard-stats');
    }
}
