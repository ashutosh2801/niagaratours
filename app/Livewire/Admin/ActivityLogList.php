<?php

namespace App\Livewire\Admin;

use App\Models\ActivityLog;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.admin')]

class ActivityLogList extends Component
{
    use WithPagination;

    public $search = '';
    public $moduleFilter = '';
    public $actionFilter = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingModuleFilter()
    {
        $this->resetPage();
    }

    public function updatingActionFilter()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = ActivityLog::with('user')->latest();

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('description', 'like', '%' . $this->search . '%')
                    ->orWhere('module', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->moduleFilter) {
            $query->where('module', $this->moduleFilter);
        }

        if ($this->actionFilter) {
            $query->where('action', $this->actionFilter);
        }

        $logs = $query->paginate(20);

        $modules = ActivityLog::select('module')->distinct()->pluck('module');

        return view('livewire.admin.activity-log-list', [
            'logs' => $logs,
            'modules' => $modules,
        ]);
    }
}
