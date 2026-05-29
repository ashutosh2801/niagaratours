<?php

namespace App\Livewire\Admin;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;

#[Title('Users')]
#[Layout('layouts.admin')]
class UserList extends Component
{
    use WithPagination;

    public $search = '';

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        if ($user->hasRole('administrator')) {
            session()->flash('error', 'Cannot delete an Administrator user.');
            return;
        }
        $user->roles()->detach();
        $user->delete();
        session()->flash('message', 'User deleted successfully.');
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
