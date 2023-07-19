<?php

namespace App\Http\Livewire;

use App\Models\ClassroomStudent;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class AnswersList extends Component
{
    use AuthorizesRequests;


    public $answers = [];
    public $keyWord = '';

    public function render()
    {
        $this->authorize('student-list');

        $keyWord = '%' . $this->keyWord . '%';

        $this->students = User::where('name','like',"%$keyWord")->whereHas("roles", function($q){ $q->where("name", "student"); })->get();
        return view('livewire.answers.answers-list',[
            'students' => $this->students
        ])->extends('layouts.app');
    }


}
