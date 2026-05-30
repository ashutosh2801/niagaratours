<?php

namespace App\Livewire\Admin;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use App\Models\Permission;
use Illuminate\Support\Str;
use App\Helpers\ActivityLogger;

#[Title('Permission Form')]
#[Layout('layouts.admin')]
class PermissionForm extends Component
{
    public $permissionId = null;
    public $name;
    public $slug;
    public $group;

    public function mount($permissionId = null)
    {
        $this->permissionId = $permissionId;

        if ($this->permissionId) {
            $permission = Permission::findOrFail($this->permissionId);
            $this->name = $permission->name;
            $this->slug = $permission->slug;
            $this->group = $permission->group;
        }
    }

    public function updatedName($value)
    {
        if (empty($this->slug) || $this->permissionId === null) {
            $this->slug = Str::slug($value);
        }
    }

    public function save()
    {
        if (!auth()->user()->hasPermission('permissions')) {
            abort(403, 'Unauthorized access.');
        }

        $this->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:permissions,slug,' . $this->permissionId,
            'group' => 'required|string|max:255',
        ]);

        $data = [
            'name' => $this->name,
            'slug' => $this->slug,
            'group' => $this->group,
        ];

        if ($this->permissionId) {
            $permission = Permission::findOrFail($this->permissionId);
            $permission->update($data);
            session()->flash('message', 'Permission updated successfully.');
            ActivityLogger::log('updated', 'Permission', "Permission '{$this->name}' updated");
        } else {
            Permission::create($data);
            session()->flash('message', 'Permission created successfully.');
            ActivityLogger::log('created', 'Permission', "Permission '{$this->name}' created");
        }

        return redirect()->route('admin.permissions');
    }

    public function render()
    {
        $existingGroups = Permission::distinct()->pluck('group')->sort()->values();

        return view('admin.permissions.form', [
            'existingGroups' => $existingGroups,
        ]);
    }
}
