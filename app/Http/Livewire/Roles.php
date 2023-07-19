<?php

namespace App\Http\Livewire;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class Roles extends Component
{
    use WithPagination;
    use AuthorizesRequests;

    protected $listeners = [
        'confirmed',
        'cancelled',
    ];

    protected $paginationTheme = 'bootstrap';

    public $selected_id, $keyWord, $deleteId, $name, $guard_name, $permission;

    public $selected_permission = [];

    public $rolePermissions = [];

    public function mount()
    {

    }

    public function render()
    {
        $this->authorize('role-list');

        $this->permission = Permission::get();

        $keyWord = '%' . $this->keyWord . '%';
        return view('livewire.roles.index', [
            'roles' => Role::latest()
                ->orWhere('name', 'LIKE', $keyWord)
                ->paginate(10),
        ])->extends('layouts.app');
    }

    public function resetInput()
    {
        $this->name = null;
        $this->selected_permission = [];
    }

    public function store()
    {
        $this->authorize('role-create');

        $this->validate([
            'name' => 'required|unique:roles,name',
            'selected_permission' => 'required',
        ]);
        $role = Role::create([
            'name' => $this->name,
        ]);
        $role->syncPermissions($this->selected_permission);

        $this->resetInput();
        $this->emit('closeModal');
        $this->alert('success', 'Role Successfully created.');
    }

    public function edit($id)
    {
        $record = Role::findOrFail($id);

        $this->selected_permission = DB::table('role_has_permissions')
            ->where('role_has_permissions.role_id', $id)
            ->pluck('role_has_permissions.permission_id', 'role_has_permissions.permission_id')
            ->all();
        $this->selected_id = $id;
        $this->name = $record->name;

    }

    public function show($id)
    {
        $record = Role::findOrFail($id);

        $this->rolePermissions = Permission::join('role_has_permissions', 'role_has_permissions.permission_id', 'permissions.id')
            ->where('role_has_permissions.role_id', $id)
            ->get();

        $this->selected_id = $id;
        $this->name = $record->name;

    }

    public function update()
    {
        $this->authorize('role-edit');

        $this->validate([
            'name' => 'required',
            'selected_permission' => 'required',
        ]);

        if ($this->selected_id) {
            $record = Role::find($this->selected_id);
            $record->update([
                'name' => $this->name,
            ]);
            $record->syncPermissions($this->selected_permission);

            $this->resetInput();
            $this->alert('success', 'Role Successfully updated.');
        }
    }

    public function triggerConfirm($id)
    {
        $this->datetId = $id;
        $this->confirm('Do you want to delete?', [
            'toast' => false,
            'position' => 'center',
            'showConfirmButton' => true,
            'cancelButtonText' => 'Cancel',
            'onConfirmed' => 'confirmed',
            'onCancelled' => 'cancelled',
        ]);
    }

    public function confirmed()
    {
        $this->destroy();
        $this->alert('success', 'Deleted successfully.');
    }

    public function cancelled()
    {
        $this->alert('info', 'Understood');
    }

    public function destroy()
    {
        $this->authorize('role-delete');

        if ($this->deleteId) {
            $record = Role::where('id', $this->deleteId);
            $record->delete();
        }
    }

}
