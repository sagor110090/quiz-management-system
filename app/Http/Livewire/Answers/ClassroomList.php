<?php

namespace App\Http\Livewire\Answers;

use App\Models\ClassroomStudent;
use App\Models\User;
use Livewire\Component;

class ClassroomList extends Component
{
    public $student_id;
    public $answers;

    public function mount($student_id)
    {
        $this->student_id = $student_id;
    }

    public function render()
    {
        $classrooms = User::findOrFail($this->student_id)->classrooms;

        return view('livewire.answers.classrooms', [
            'classrooms' => $classrooms,
        ])->extends('layouts.app');
    }
}
