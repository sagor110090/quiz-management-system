<?php

namespace App\Http\Livewire\Answers;

use App\Models\Answer;
use Livewire\Component;

class QuizDetail extends Component
{
    public $quiz_id;
    public $answers;
    public $student_id;
    public $answer;
    public $mark;


    public function mount($quiz_id,$student_id)
    {
        $this->quiz_id = $quiz_id;
        $this->student_id = $student_id;
        $this->answers = Answer::where('quiz_id', $this->quiz_id)->where('user_id', $this->student_id)->get();
    }


    public function render()
    {
        return view('livewire.answers.quiz-detail')->extends('layouts.app');
    }

    public function show($id)
    {
        $this->answer = Answer::findOrFail($id);
        $this->mark=null;
    }
    public function storeMark()
    {
        $this->answer->mark = $this->mark;
        $this->answer->save();
        return redirect('/quizDetail/'.$this->quiz_id.'/'.$this->student_id);
    }
}
