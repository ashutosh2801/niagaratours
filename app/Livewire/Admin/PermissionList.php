<?php

namespace App\Livewire\Admin;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use App\Models\Permission;
use App\Helpers\ActivityLogger;

#[Title('Permissions')]
#[Layout('layouts.admin')]
class PermissionList extends Component
{
    public $search = '';

    public function delete($id)
    {
        if (!auth()->user()->hasPermission('permissions')) {
            abort(403, 'Unauthorized access.');
        }

        $permission = Permission::findOrFail($id);
        $name = $permission->name;
        $permission->roles()->detach();
        $permission->delete();
        session()->flash('message', "Permission '{$name}' deleted successfully.");
        ActivityLogger::log('deleted', 'Permission', "Permission '{$name}' deleted");
    }

    public function render()
    {
        $permissions = Permission::when($this->search, function ($q) {
            $q->where('name', 'like', '%'.$this->search.'%')
              ->orWhere('slug', 'like', '%'.$this->search.'%');
        })->orderBy('group')->orderBy('name')->get()->groupBy('group');

        return view('admin.permissions.index', compact('permissions'));
    }
}
