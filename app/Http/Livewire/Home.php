<?php

namespace App\Http\Livewire;


use App\Models\ClassroomStudent;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Home extends Component
{
    public $classroom_id;

    public function render()
    {
        return view('livewire.home')->extends('layouts.frontend');
    }

    public function store()
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }
        $this->validate([
            'classroom_id' => 'required',
        ]);

        $classroom = DB::table('classrooms')->where('classroom_unique_id', $this->classroom_id)->first();


        if (ClassroomStudent::where('user_id', auth()->user()->id)->where('classroom_id', $this->classroom_id)->count()) {
            return redirect()->route('classroom.show', $classroom->id);
        }

        ClassroomStudent::insert([
            'classroom_id' => $classroom->id,
            'user_id' => auth()->user()->id,
        ]);

        return redirect()->route('classroom.show', $classroom->id);
    }
}
