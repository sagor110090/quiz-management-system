<?php

namespace App\Http\Livewire;

use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class Users extends Component
{
    use WithPagination;
    use WithFileUploads;
    use AuthorizesRequests;

    protected $listeners = [
        'confirmed',
        'cancelled',
    ];

    protected $paginationTheme = 'bootstrap';
    public $selected_id, $keyWord, $deleteId, $name, $email, $image, $password, $password_confirmation, $roles;

    public $selected_roles = [];

    public function render()
    {
        $this->authorize('user-list');

        $this->roles = Role::pluck('name', 'name')->all();

        $keyWord = '%' . $this->keyWord . '%';
        return view('livewire.users.index', [
            'users' => User::latest()
                ->orWhere('name', 'LIKE', $keyWord)
                ->orWhere('email', 'LIKE', $keyWord)
                ->orWhere('image', 'LIKE', $keyWord)
                ->paginate(10),
        ])->extends('layouts.app');
    }

    public function resetInput()
    {
        $this->name = null;
        $this->email = null;
        $this->image = null;
        $this->selected_roles = null;
        $this->image = null;
        $this->password = null;
        $this->password_confirmation = null;
        $this->roles = null;
        $this->image = null;
    }

    public function store()
    {
        $this->authorize('user-create');

        $this->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed',
            'selected_roles' => 'required',
            'image' => 'nullable|image|max:1024', // 1MB Max
        ]);

        $image = '';

        if ($this->image) {
            $image = $this->image->store('uploads', 'public');
        }

        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'image' => $image,
            'password' => bcrypt($this->password),
        ]);
        $user->assignRole($this->selected_roles);

        $this->resetInput();
        $this->emit('closeModal');
        $this->alert('success', 'User Successfully created.');
    }

    public function edit($id)
    {
        $record = User::findOrFail($id);

        $this->selected_id = $id;
        $this->name = $record->name;
        $this->email = $record->email;
        $this->image = $record->image;

        $this->selected_roles = $record->roles->pluck('name', 'name')->all();
    }
    public function show($id)
    {
        $record = User::findOrFail($id);

        $this->selected_id = $id;
        $this->name = $record->name;
        $this->email = $record->email;
        $this->image = $record->image;

    }

    public function update()
    {
        $this->authorize('user-edit');

        $this->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $this->selected_id,
            'password' => 'confirmed',
            'roles' => 'required',
            'image' => 'nullable|image|max:1024', // 1MB Max

        ]);

        $image = '';

        if ($this->image) {
            $image = $this->image->store('uploads', 'public');
        }


        if ($this->selected_id) {
            $record = User::find($this->selected_id);

            $record->update([
                'name' => $this->name,
                'email' => $this->email,
                'image' => $image,
                'password' => bcrypt($this->password),
            ]);
            DB::table('model_has_roles')
            ->where('model_id', $this->selected_id)
            ->delete();
            $record->assignRole($this->selected_roles);

            $this->resetInput();
            $this->alert('success', 'User Successfully updated.');
        }
    }

    public function triggerConfirm($id)
    {
        $this->deleteId = $id;
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
        $this->authorize('user-delete');

        if ($this->deleteId) {
            $record = User::where('id', $this->deleteId);
            $record->delete();
        }
    }

}
