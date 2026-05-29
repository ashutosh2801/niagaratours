<?php

namespace App\Livewire\Admin;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use App\Models\User;
use App\Models\Role;
use App\Helpers\ActivityLogger;

#[Layout('layouts.admin')]
class UserForm extends Component
{
    public $userId = null;
    public $name;
    public $email;
    public $phone;
    public $password;
    public $password_confirmation;
    public $selectedRole = '';

    public function mount($userId = null)
    {
        $this->userId = $userId;

        if ($this->userId) {
            $user = User::with('roles')->findOrFail($this->userId);
            $this->name = $user->name;
            $this->email = $user->email;
            $this->phone = $user->phone;
            $this->selectedRole = $user->roles->first()?->id ? (string) $user->roles->first()->id : '';
        }
    }

    public function save()
    {
        if (!auth()->user()->hasPermission('users')) {
            abort(403, 'Unauthorized access.');
        }

        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . ($this->userId ?? 'NULL'),
            'phone' => 'nullable|string|max:20',
            'selectedRole' => 'nullable|exists:roles,id',
        ];

        if (!$this->userId) {
            $rules['password'] = 'required|string|min:8|confirmed';
        }

        $this->validate($rules);

        $roleIds = $this->selectedRole ? [$this->selectedRole] : [];

        if ($this->userId) {
            $user = User::findOrFail($this->userId);
            $data = ['name' => $this->name, 'email' => $this->email, 'phone' => $this->phone];
            if ($this->password) {
                $data['password'] = bcrypt($this->password);
            }
            $user->update($data);
            $user->roles()->sync($roleIds);
            session()->flash('message', 'User updated successfully.');
            ActivityLogger::log('updated', 'User', "User '{$this->name}' updated");
        } else {
            $user = User::create([
                'name' => $this->name,
                'email' => $this->email,
                'phone' => $this->phone,
                'password' => bcrypt($this->password),
            ]);
            $user->roles()->sync($roleIds);
            session()->flash('message', 'User created successfully.');
            ActivityLogger::log('created', 'User', "User '{$this->name}' created");
        }

        return redirect()->route('admin.users');
    }

    public function render()
    {
        $roles = Role::orderBy('name')->get();
        return view('admin.users.form', compact('roles'));
    }
}
