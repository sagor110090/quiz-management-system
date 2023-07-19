<?php

namespace App\Http\Livewire;

use App\Models\Question;
use App\Models\QuestionOption;
use App\Models\Quiz;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Questions extends Component
{
    use WithPagination;
    use AuthorizesRequests;
    use WithFileUploads;

    protected $listeners = [
        'confirmed',
        'cancelled',
        'bulkDelete',
    ];

    protected $paginationTheme = 'bootstrap';
    public $selected_id, $keyWord, $deleteId, $checkedAll, $question, $quiz_id;
    public $checked = [];
    public $perPage = 10;
    public $inputs = [];
    public $i = 0;
    public $quizzes = [];
    public $option;
    public $questionOption;
    public $answer;
    public $answerOptionShow = false;
    public $long_written = 0;
    public $missing_word = 0;
    public $image;

    public function render()
    {
        $this->authorize('question-list');

        $this->quizzes = Quiz::all();

        $keyWord = '%' . $this->keyWord . '%';
        return view('livewire.questions.index', [
            'questions' => Question::latest()
                ->orWhere('question', 'LIKE', $keyWord)
                ->orWhere('quiz_id', 'LIKE', $keyWord)
                ->paginate($this->perPage),
        ])->extends('layouts.app');
    }

    public function add()
    {
        $this->i = $this->i + 1;
        array_push($this->inputs, $this->i);
    }

    public function removeOption($i)
    {
        unset($this->inputs[$i]);
        unset($this->option[$i]);
    }

    public function updatedOption($value)
    {
        $this->answerOptionShow = true;
    }

    public function updatingPerPage()
    {
        $this->resetPage();
    }

    public function resetInput()
    {
        $this->question = null;
        $this->quiz_id = null;
        $this->answer = null;
        $this->option = null;
        $this->questionOption = 0;
    }

    public function updatedAnswer($value, $key)
    {
        $this->answer = $value;
    }

    public function updatedLongWritten($value)
    {
        $this->missing_word = 0;
    }
    public function updatedMissingWord($value)
    {
        $this->long_written = 0;
    }

    public function store()
    {
        $this->authorize('question-create');

        if ($this->long_written) {
            $this->validate([
                'question' => 'required',
                'quiz_id' => 'required',

            ], [
                'quiz_id.required' => 'Please select quiz',
            ]);

        } else {
            $this->validate([
                'question' => 'required',
                'quiz_id' => 'required',
                'option.*' => 'required',
                'answer' => 'required',
            ], [
                'option.*.required' => 'Please enter option',
                'answer.required' => 'Please enter answer',
                'quiz_id.required' => 'Please select quiz',
            ]);
        }

        // dd($this->option, $this->answer, $this->long_written, $this->missing_word);

        $question = Question::create([
            'question' => $this->question,
            'quiz_id' => $this->quiz_id,
            'answer' => $this->answer,
            'long_written' => $this->long_written ? 1 : 0,
            'missing_word' => $this->missing_word ? 1 : 0,
            'image' => $this->image ? $this->image->store('questions', 'public') : null,
        ]);
        if (!$this->long_written && !$this->missing_word) {
            foreach ($this->option as $key => $value) {
                QuestionOption::create([
                    'question_id' => $question->id,
                    'option_name' => $this->option[$key],
                ]);
            }
        }

        $this->resetInput();
        $this->emit('closeModal');
        $this->alert('success', 'Question Successfully created.');
    }

    public function edit($id)
    {
        $this->resetInput();
        $record = Question::findOrFail($id);
        $this->selected_id = $id;
        $this->question = $record->question;
        $this->quiz_id = $record->quiz_id;
        $this->option = $record->questionOptions->pluck('option_name')->toArray();
        $this->inputs = $record->questionOptions->pluck('id')->toArray();
        $this->answer = $record->answer;
        $this->long_written = $record->long_written;
        $this->missing_word = $record->missing_word;
        $this->image = $record->image;
    }
    public function show($id)
    {
        $record = Question::findOrFail($id);

        $this->selected_id = $id;
        $this->question = $record->question;
        $this->quiz_id = $record->quiz_id;
        $this->questionOptions = $record->questionOptions;
        $this->answer = $record->answer;
        $this->long_written = $record->long_written;
        $this->missing_word = $record->missing_word;
        $this->image = $record->image;
    }

    public function update()
    {
        $this->authorize('question-edit');

        if ($this->long_written) {
            $this->validate([
                'question' => 'required',
                'quiz_id' => 'required',

            ], [
                'quiz_id.required' => 'Please select quiz',
            ]);

        } else {
            $this->validate([
                'question' => 'required',
                'quiz_id' => 'required',
                'option.*' => 'required',
                'answer' => 'required',
            ], [
                'option.*.required' => 'Please enter option',
                'answer.required' => 'Please enter answer',
                'quiz_id.required' => 'Please select quiz',
            ]);
        }

        if ($this->selected_id) {
            $record = Question::find($this->selected_id);
            $record->update([
                'question' => $this->question,
                'quiz_id' => $this->quiz_id,
                'answer' => $this->answer,
                'long_written' => $this->long_written ? 1 : 0,
                'image' => $this->image ? $this->image->store('questions', 'public') : null,
            ]);

            QuestionOption::where('question_id', $this->selected_id)->delete();
            if (!$this->long_written) {
                foreach ($this->option as $key => $value) {
                    QuestionOption::create([
                        'question_id' => $record->id,
                        'option_name' => $this->option[$key],

                    ]);
                }
            }

            $this->resetInput();
            $this->alert('success', 'Question Successfully updated.');
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
        $this->authorize('question-delete');

        if ($this->deleteId) {
            $record = Question::where('id', $this->deleteId);
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
        $this->authorize('question-delete');

        Question::whereKey($this->checked)->delete();
        $this->checked = [];
        $this->alert('success', 'Deleted successfully.');
    }

    public function updatedCheckedAll($value)
    {
        if ($value) {
            $this->checked = Question::pluck('id');
        } else {
            $this->checked = [];
        }
    }
}
