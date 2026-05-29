<?php

namespace App\Livewire\Admin;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;
use App\Helpers\ActivityLogger;

#[Title('Users')]
#[Layout('layouts.admin')]
class UserList extends Component
{
    use WithPagination;

    public $search = '';

    public function toggleActive($id)
    {
        if (!auth()->user()->hasPermission('users')) {
            abort(403, 'Unauthorized access.');
        }

        $user = User::findOrFail($id);
        if ($user->hasRole('administrator')) {
            session()->flash('error', 'Cannot deactivate an Administrator user.');
            return;
        }
        if ($user->id === auth()->id()) {
            session()->flash('error', 'You cannot deactivate your own account.');
            return;
        }
        $user->update(['is_active' => !$user->is_active]);
        $status = $user->is_active ? 'activated' : 'deactivated';
        ActivityLogger::log('updated', 'User', "User '{$user->name}' {$status}");
    }

    public function deleteUser($id)
    {
        if (!auth()->user()->hasPermission('users')) {
            abort(403, 'Unauthorized access.');
        }

        $user = User::findOrFail($id);
        if ($user->hasRole('administrator')) {
            session()->flash('error', 'Cannot delete an Administrator user.');
            return;
        }
        $name = $user->name;
        $user->roles()->detach();
        $user->delete();
        session()->flash('message', 'User deleted successfully.');
        ActivityLogger::log('deleted', 'User', "User '{$name}' deleted");
    }

    public function render()
    {
        $users = User::where('name', 'like', '%'.$this->search.'%')
            ->orWhere('email', 'like', '%'.$this->search.'%')
            ->with('roles')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('components.admin.user-list', compact('users'));
    }
}
