<?php

namespace App\Http\Livewire;

use App\Mail\studentMail;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;
use Livewire\WithPagination;

class StudentList extends Component
{
    use AuthorizesRequests;
    use WithPagination;

    protected $listeners = [
        'confirmed',
        'cancelled',
    ];

    public $students = [];
    public $keyWord = '';
    public $deleteId = null;
    public $email = null;
    public $message = null;


    public function render()
    {
        $this->authorize('student-list');

        $keyWord = '%' . $this->keyWord . '%';
        $this->students = User::where('name','like',"%$keyWord")->whereHas("roles", function($q){ $q->where("name", "student"); })->get();


        return view('livewire.students.student-list')->extends('layouts.app');
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

    public function edit($email){
        $this->email = $email;
    }

    public function sendMail(){
        $this->authorize('student-mail');
        // send Mail to student

        $details = [
            'message' => $this->message,
        ];

        // check if mail is sent or not
        Mail::to($this->email)->send(new studentMail($details));
        $this->message = null;
        $this->alert('success', 'Mail sent successfully');
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
        $this->authorize('student-delete');

        if ($this->deleteId) {
            $record = User::where('id', $this->deleteId);
            $record->delete();
        }
    }
}
