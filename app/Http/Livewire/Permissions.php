<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Permission;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Permissions extends Component
{
    use WithPagination;
    use AuthorizesRequests;


     protected $listeners = [
        'confirmed',
        'cancelled',
    ];

	protected $paginationTheme = 'bootstrap';
    public $selected_id, $keyWord,$deleteId, $name;

    public function render()
    {
        $this->authorize('permission-list');

		$keyWord = '%'.$this->keyWord .'%';
        return view('livewire.permissions.index', [
            'permissions' => Permission::latest()
						->orWhere('name', 'LIKE', $keyWord)
						->paginate(10),
        ])->extends('layouts.app');
    }



    public function resetInput()
    {
		$this->name = null;
		$this->guard_name = null;
    }

    public function store()
    {
        $this->authorize('permission-create');

        $this->validate([
            'name' => 'required|unique:permissions,name',
        ]);

        Permission::create([
			'name' => $this-> name,
        ]);

        $this->resetInput();
		$this->emit('closeModal');
		 $this->alert('success', 'Permission Successfully created.');
    }

    public function edit($id)
    {

        $record = Permission::findOrFail($id);

        $this->selected_id = $id;
		$this->name = $record-> name;

    }
    public function show($id)
    {
        $record = Permission::findOrFail($id);

        $this->selected_id = $id;
		$this->name = $record-> name;

    }

    public function update()
    {
        $this->authorize('permission-edit');

        $this->validate([
		'name' => 'required',
        ]);

        if ($this->selected_id) {
			$record = Permission::find($this->selected_id);
            $record->update([
			'name' => $this-> name,
            ]);

            $this->resetInput();
			$this->alert('success', 'Permission Successfully updated.');
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
        $this->alert( 'success', 'Deleted successfully.');
    }

    public function cancelled()
    {
        $this->alert('info', 'Understood');
    }

    public function destroy()
    {
        $this->authorize('permission-delete');

        if ($this->deleteId) {
            $record = Permission::where('id', $this->deleteId);
            $record->delete();
        }
    }


}
