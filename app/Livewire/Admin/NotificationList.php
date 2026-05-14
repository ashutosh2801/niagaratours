<?php

namespace App\Livewire\Admin;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\TourNotification;

#[Title('Notifications')]
#[Layout('layouts.admin')]
class NotificationList extends Component
{
    use WithPagination;

    public $filter = 'all';

    public function markAsRead($id)
    {
        $notification = TourNotification::findOrFail($id);
        $notification->update(['is_read' => true]);
    }

    public function markAllAsRead()
    {
        TourNotification::where('is_read', false)->update(['is_read' => true]);
    }

    public function delete($id)
    {
        TourNotification::findOrFail($id)->delete();
    }

    public function render()
    {
        $notifications = TourNotification::query()
            ->when($this->filter === 'unread', function ($query) {
                $query->where('is_read', false);
            })
            ->when($this->filter === 'read', function ($query) {
                $query->where('is_read', true);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('components.admin.notification-list', compact('notifications'));
    }
}
