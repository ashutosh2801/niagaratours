<?php

namespace App\Livewire\Admin;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Role;

#[Title('Roles')]
#[Layout('layouts.admin')]
class RoleList extends Component
{
    use WithPagination;

    public $search = '';

    public function delete($id)
    {
        $role = Role::findOrFail($id);
        if ($role->slug === 'administrator') {
            session()->flash('error', 'Cannot delete the Administrator role.');
            return;
        }
        $role->permissions()->detach();
        $role->users()->detach();
        $role->delete();
        session()->flash('message', 'Role deleted successfully.');
    }

    public function render()
    {
        $roles = Role::where('name', 'like', '%'.$this->search.'%')
            ->withCount('users', 'permissions')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.roles.index', compact('roles'));
    }
}
