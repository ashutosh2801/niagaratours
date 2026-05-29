<?php

namespace App\Livewire\Admin;

use Illuminate\Support\Carbon;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\TourNotification;
use App\Helpers\ActivityLogger;

#[Title('Notifications')]
#[Layout('layouts.admin')]
class NotificationList extends Component
{
    use WithPagination;

    public $filter = 'all';
    public $selectedNotificationId = null;

    public function viewNotification($id)
    {
        $this->selectedNotificationId = (int) $id;
    }

    public function closeNotificationView()
    {
        $this->selectedNotificationId = null;
    }

    public function markAsRead($id)
    {
        if (!auth()->user()->hasPermission('notifications')) {
            abort(403, 'Unauthorized access.');
        }

        $notification = TourNotification::findOrFail($id);
        $notification->update([
            'is_read' => true,
            'read_at' => Carbon::now(),
        ]);
        ActivityLogger::log('updated', 'Notification', "Notification #{$id} marked as read");
    }

    public function markAllAsRead()
    {
        if (!auth()->user()->hasPermission('notifications')) {
            abort(403, 'Unauthorized access.');
        }

        $count = TourNotification::where('is_read', false)->count();
        TourNotification::where('is_read', false)->update([
            'is_read' => true,
            'read_at' => Carbon::now(),
        ]);
        ActivityLogger::log('updated', 'Notification', "{$count} notification(s) marked as read");
    }

    public function delete($id)
    {
        if (!auth()->user()->hasPermission('notifications')) {
            abort(403, 'Unauthorized access.');
        }

        TourNotification::findOrFail($id)->delete();
        ActivityLogger::log('deleted', 'Notification', "Notification #{$id} deleted");

        if ($this->selectedNotificationId === (int) $id) {
            $this->selectedNotificationId = null;
        }
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

        $selectedNotification = $this->selectedNotificationId
            ? TourNotification::find($this->selectedNotificationId)
            : null;

        return view('components.admin.notification-list', compact('notifications', 'selectedNotification'));
    }
}
