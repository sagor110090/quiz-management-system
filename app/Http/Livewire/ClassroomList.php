<?php

namespace App\Http\Livewire;

use App\Models\Classroom;
use Livewire\Component;

class ClassroomList extends Component
{
    public function render()
    {
        return view('livewire.classroom-list',[
            'classrooms' => Classroom::all(),
        ])->extends('layouts.frontend');
    }
}
