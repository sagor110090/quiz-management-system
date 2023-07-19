<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\QuestionOption;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


class QuestionOptions extends Component
{
    use WithPagination;
     use AuthorizesRequests;

     protected $listeners = [
        'confirmed',
        'cancelled',
        'bulkDelete'
    ];

	protected $paginationTheme = 'bootstrap';
    public $selected_id, $keyWord,$deleteId,$checkedAll, $option_name, $question_id;
    public $checked = [];
    public $perPage = 10;


    public function render()
    {
        $this->authorize('questionOption-list');

		$keyWord = '%'.$this->keyWord .'%';
        return view('livewire.question-options.index', [
            'questionOptions' => QuestionOption::latest()
						->orWhere('option_name', 'LIKE', $keyWord)
						->orWhere('question_id', 'LIKE', $keyWord)
						->paginate($this->perPage),
        ])->extends('layouts.app');
    }

    public function updatingPerPage()
    {
        $this->resetPage();
    }

    public function resetInput()
    {		
		$this->option_name = null;
		$this->question_id = null;
    }

    public function store()
    {
        $this->authorize('questionOption-create');

        $this->validate([
		'option_name' => 'required',
		'question_id' => 'required',
        ]);

        QuestionOption::create([ 
			'option_name' => $this-> option_name,
			'question_id' => $this-> question_id
        ]);

        $this->resetInput();
		$this->emit('closeModal');
		$this->alert('success', 'Question Option Successfully created.');
    }

    public function edit($id)
    {
        $this->resetInput();
        $record = QuestionOption::findOrFail($id);
        $this->selected_id = $id; 
		$this->option_name = $record-> option_name;
		$this->question_id = $record-> question_id;

    }
    public function show($id)
    {
        $record = QuestionOption::findOrFail($id);

        $this->selected_id = $id; 
		$this->option_name = $record-> option_name;
		$this->question_id = $record-> question_id;

    }

    public function update()
    {
        $this->authorize('questionOption-edit');

        $this->validate([
		'option_name' => 'required',
		'question_id' => 'required',
        ]);

        if ($this->selected_id) {
			$record = QuestionOption::find($this->selected_id);
            $record->update([ 
			'option_name' => $this-> option_name,
			'question_id' => $this-> question_id
            ]);

            $this->resetInput();
			$this->alert('success', 'Question Option Successfully updated.');
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
        $this->authorize('questionOption-delete');

        if ($this->deleteId) {
            $record = QuestionOption::where('id', $this->deleteId);
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
        $this->authorize('questionOption-delete');

        QuestionOption::whereKey($this->checked)->delete();
        $this->checked = [];
        $this->alert( 'success', 'Deleted successfully.');
    }

    public function updatedCheckedAll($value)
    {
        if ($value) {
            $this->checked = QuestionOption::pluck('id');
        }else{
            $this->checked = [];
        }
    }


}
