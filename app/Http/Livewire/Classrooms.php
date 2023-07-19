<?php

namespace App\Http\Livewire;

use App\Models\Classroom;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Livewire\WithPagination;

class Classrooms extends Component
{
    use WithPagination;
    use AuthorizesRequests;

    protected $listeners = [
        'confirmed',
        'cancelled',
        'bulkDelete',
    ];

    protected $paginationTheme = 'bootstrap';
    public $selected_id, $keyWord, $deleteId, $checkedAll, $classroom_name, $classroom_unique_id, $teacher_id;
    public $checked = [];
    public $perPage = 10;

    public function render()
    {
        $this->authorize('classroom-list');

        $keyWord = '%' . $this->keyWord . '%';
        return view('livewire.classrooms.index', [
            'classrooms' => Classroom::latest()
                ->orWhere('classroom_name', 'LIKE', $keyWord)
                ->orWhere('classroom_unique_id', 'LIKE', $keyWord)
                ->orWhere('teacher_id', 'LIKE', $keyWord)
                ->paginate($this->perPage),
        ])->extends('layouts.app');
    }

    public function updatingPerPage()
    {
        $this->resetPage();
    }

    public function resetInput()
    {
        $this->classroom_name = null;
        $this->classroom_unique_id = null;
        $this->teacher_id = null;
    }

    public function updatedClassroomName()
    {
        $this->classroom_unique_id = rand(1, 99999);
    }

    public function store()
    {
        $this->authorize('classroom-create');

        $this->validate([
            'classroom_name' => 'required',
            'classroom_unique_id' => 'required',
        ]);

        Classroom::create([
            'classroom_name' => $this->classroom_name,
            'classroom_unique_id' => $this->classroom_unique_id,
            'teacher_id' => auth()->user()->id,
        ]);

        $this->resetInput();
        $this->emit('closeModal');
        $this->alert('success', 'Classroom Successfully created.');
    }

    public function edit($id)
    {
        $this->resetInput();
        $record = Classroom::findOrFail($id);
        $this->selected_id = $id;
        $this->classroom_name = $record->classroom_name;
        $this->classroom_unique_id = $record->classroom_unique_id;
        $this->teacher_id = $record->teacher_id;

    }
    public function show($id)
    {
        $record = Classroom::findOrFail($id);

        $this->selected_id = $id;
        $this->classroom_name = $record->classroom_name;
        $this->classroom_unique_id = $record->classroom_unique_id;
        $this->teacher_id = $record->teacher_id;

    }

    public function update()
    {
        $this->authorize('classroom-edit');

        $this->validate([
            'classroom_name' => 'required',
            'classroom_unique_id' => 'required',
        ]);

        if ($this->selected_id) {
            $record = Classroom::find($this->selected_id);
            $record->update([
                'classroom_name' => $this->classroom_name,
                'classroom_unique_id' => $this->classroom_unique_id,
                'teacher_id' => auth()->user()->id,
            ]);

            $this->resetInput();
            $this->alert('success', 'Classroom Successfully updated.');
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
        $this->authorize('classroom-delete');

        if ($this->deleteId) {
            $record = Classroom::where('id', $this->deleteId);
            $record->delete();
        }
    }

    public function bulkDeleteTriggerConfirm()
    {
        $this->confirm('Do you want to delete?', [
            'toast' => false,
            'position' => 'center',
            'showConfirmButton' => true,
            'cancelButtonText' => 'Cancel',
            'onConfirmed' => 'bulkDelete',
            'onCancelled' => 'cancelled',
        ]);
    }

    public function bulkDelete()
    {
        $this->authorize('classroom-delete');

        Classroom::whereKey($this->checked)->delete();
        $this->checked = [];
        $this->alert('success', 'Deleted successfully.');
    }

    public function updatedCheckedAll($value)
    {
        if ($value) {
            $this->checked = Classroom::pluck('id');
        } else {
            $this->checked = [];
        }
    }

}
