<?php

namespace App\Http\Livewire;

use App\Models\Answer;
use App\Models\Quiz;
use Livewire\Component;

class QuizList extends Component
{
    public $quiz_id;
    public $answers;

    public function mount($quiz_id)
    {
        $this->quiz_id = $quiz_id;
        $this->answers = Answer::where('quiz_id', $this->quiz_id)->where('user_id', auth()->user()->id)->get();

    }

    public function render()
    {
        return view('livewire.quiz-list',[
            'quiz' => Quiz::findOrFail($this->quiz_id)
        ])->extends('layouts.frontend');
    }

    public function ansStore()
    {
        $quiz = Quiz::find(request()->quiz_id);
        if (request()->question) {
            for ($i=0; $i < sizeof(request()->question) ; $i++) {
                if (request()->short_question_answer[$i][0] == request()->short_question_correct[$i]) {
                    $mark = $quiz->per_question_mark;
                } else {
                    $mark = 0;
                }
                Answer::create([
                    'user_id' => auth()->user()->id,
                    'quiz_id' => request()->quiz_id,
                    'question' => request()->question[$i],
                    'short_question_answer' =>  request()->short_question_answer[$i][0],
                    'short_question_correct' => request()->short_question_correct[$i],
                    'mark' => $mark,
                    'missing_word' => request()->missing_word[$i],
                ]);
            }
        }
        if (request()->long_question) {
            for ($i=0; $i < sizeof(request()->long_question) ; $i++) {
                Answer::create([
                    'user_id' => auth()->user()->id,
                    'quiz_id' => request()->quiz_id,
                    'question' => request()->long_question[$i],
                    'long_question_answer' => request()->long_question_answer[$i],
                    'mark' => request()->mark,
                ]);
            }
        }


        return redirect()->back();


    }
}
