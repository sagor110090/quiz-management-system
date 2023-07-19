<?php

namespace App\Http\Livewire;

use App\Models\Classroom as ModelsClassroom;
use Livewire\Component;

class Classroom extends Component
{
    public $classroom_id;

    public function mount($classroom_id)
    {
        $this->classroom_id = $classroom_id;
    }

    public function render()
    {
        return view('livewire.classroom',[
            'classroom' => ModelsClassroom::findOrFail($this->classroom_id),
        ])->extends('layouts.frontend');
    }
}
