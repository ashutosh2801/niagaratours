<?php

namespace App\Livewire\Admin;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use App\Models\User;
use App\Models\Role;

#[Title('Edit User')]
#[Layout('layouts.admin')]
class UserForm extends Component
{
    public $userId;
    public $name;
    public $email;
    public $phone;
    public $selectedRoles = [];

    public function mount($userId)
    {
        $this->userId = $userId;
        $user = User::with('roles')->findOrFail($this->userId);
        $this->name = $user->name;
        $this->email = $user->email;
        $this->phone = $user->phone;
        $this->selectedRoles = $user->roles->pluck('id')->map(fn($id) => (string) $id)->toArray();
    }

    public function save()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $this->userId,
            'phone' => 'nullable|string|max:20',
            'selectedRoles' => 'array',
        ]);

        $user = User::findOrFail($this->userId);
        $user->update([
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
        ]);
        $user->roles()->sync($this->selectedRoles);

        session()->flash('message', 'User updated successfully.');
        return redirect()->route('admin.users');
    }

    public function render()
    {
        $roles = Role::orderBy('name')->get();
        return view('admin.users.form', compact('roles'));
    }
}
