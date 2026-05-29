<?php

namespace App\Livewire\Admin;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Support\Str;
use App\Helpers\ActivityLogger;

#[Title('Role Form')]
#[Layout('layouts.admin')]
class RoleForm extends Component
{
    public $roleId = null;
    public $name;
    public $slug;
    public $description;
    public $selectedPermissions = [];

    public function mount($roleId = null)
    {
        $this->roleId = $roleId;

        if ($this->roleId) {
            $role = Role::with('permissions')->findOrFail($this->roleId);
            $this->name = $role->name;
            $this->slug = $role->slug;
            $this->description = $role->description;
            $this->selectedPermissions = $role->permissions->pluck('id')->map(fn($id) => (string) $id)->toArray();
        }
    }

    public function updatedName($value)
    {
        if (empty($this->slug) || $this->roleId === null) {
            $this->slug = Str::slug($value);
        }
    }

    public function toggleAllPermissions($group)
    {
        $groupPermissions = Permission::where('group', $group)->pluck('id')->map(fn($id) => (string) $id)->toArray();
        $allSelected = empty(array_diff($groupPermissions, $this->selectedPermissions));

        if ($allSelected) {
            $this->selectedPermissions = array_diff($this->selectedPermissions, $groupPermissions);
        } else {
            $this->selectedPermissions = array_merge($this->selectedPermissions, $groupPermissions);
        }
    }

    public function save()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:roles,slug,' . $this->roleId,
            'description' => 'nullable|string',
            'selectedPermissions' => 'array',
        ]);

        $data = [
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
        ];

        if ($this->roleId) {
            $role = Role::findOrFail($this->roleId);
            $role->update($data);
            $role->permissions()->sync($this->selectedPermissions);
            session()->flash('message', 'Role updated successfully.');
            ActivityLogger::log('updated', 'Role', "Role '{$this->name}' updated");
        } else {
            $role = Role::create($data);
            $role->permissions()->sync($this->selectedPermissions);
            session()->flash('message', 'Role created successfully.');
            ActivityLogger::log('created', 'Role', "Role '{$this->name}' created");
        }

        return redirect()->route('admin.roles');
    }

    public function render()
    {
        $permissionGroups = Permission::all()->groupBy('group');
        return view('admin.roles.form', [
            'permissionGroups' => $permissionGroups,
        ]);
    }
}
