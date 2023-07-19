<?php

namespace App\Http\Livewire;

use App\Models\Classroom;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Quiz;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


class Quizs extends Component
{
    use WithPagination;
     use AuthorizesRequests;

     protected $listeners = [
        'confirmed',
        'cancelled',
        'bulkDelete'
    ];

	protected $paginationTheme = 'bootstrap';
    public $selected_id, $keyWord,$deleteId,$checkedAll, $quiz_name, $per_question_mark, $classroom_id;
    public $checked = [];
    public $perPage = 10;
    public $classrooms = [];




    public function render()
    {
        $this->authorize('quiz-list');



        $this->classrooms = Classroom::all();

		$keyWord = '%'.$this->keyWord .'%';
        return view('livewire.quizzes.index', [
            'quizzes' => Quiz::latest()
						->orWhere('quiz_name', 'LIKE', $keyWord)
						->orWhere('per_question_mark', 'LIKE', $keyWord)
						->orWhere('classroom_id', 'LIKE', $keyWord)
						->paginate($this->perPage),
        ])->extends('layouts.app');
    }

    public function updatingPerPage()
    {
        $this->resetPage();
    }

    public function resetInput()
    {
		$this->quiz_name = null;
		$this->per_question_mark = null;
		$this->classroom_id = null;
    }

    public function store()
    {
        $this->authorize('quiz-create');

        $this->validate([
		'quiz_name' => 'required',
		'per_question_mark' => 'required',
		'classroom_id' => 'required',
        ]);

        Quiz::create([
			'quiz_name' => $this-> quiz_name,
			'per_question_mark' => $this-> per_question_mark,
			'classroom_id' => $this-> classroom_id
        ]);

        $this->resetInput();
		$this->emit('closeModal');
		$this->alert('success', 'Quiz Successfully created.');
    }

    public function edit($id)
    {
        $this->resetInput();
        $record = Quiz::findOrFail($id);
        $this->selected_id = $id;
		$this->quiz_name = $record-> quiz_name;
		$this->per_question_mark = $record-> per_question_mark;
		$this->classroom_id = $record-> classroom_id;

    }
    public function show($id)
    {
        $record = Quiz::findOrFail($id);

        $this->selected_id = $id;
		$this->quiz_name = $record-> quiz_name;
		$this->per_question_mark = $record-> per_question_mark;
		$this->classroom_id = $record-> classroom_id;

    }

    public function update()
    {
        $this->authorize('quiz-edit');

        $this->validate([
		'quiz_name' => 'required',
		'per_question_mark' => 'required',
		'classroom_id' => 'required',
        ]);

        if ($this->selected_id) {
			$record = Quiz::find($this->selected_id);
            $record->update([
			'quiz_name' => $this-> quiz_name,
			'per_question_mark' => $this-> per_question_mark,
			'classroom_id' => $this-> classroom_id
            ]);

            $this->resetInput();
			$this->alert('success', 'Quiz Successfully updated.');
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
        $this->authorize('quiz-delete');

        if ($this->deleteId) {
            $record = Quiz::where('id', $this->deleteId);
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
        $this->authorize('quiz-delete');

        Quiz::whereKey($this->checked)->delete();
        $this->checked = [];
        $this->alert( 'success', 'Deleted successfully.');
    }

    public function updatedCheckedAll($value)
    {
        if ($value) {
            $this->checked = Quiz::pluck('id');
        }else{
            $this->checked = [];
        }
    }


}
