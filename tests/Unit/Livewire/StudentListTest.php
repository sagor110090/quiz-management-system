<?php

namespace Tests\Unit\Livewire;

use App\Models\Classroom;
use App\Models\User;
use Livewire\Livewire;
use Tests\TestCase;

class StudentListTest extends TestCase
{
    public function test_it_can_render_student_list_page()
    {
        $this->expectException(\Illuminate\Auth\Access\AuthorizationException::class);
        $this->withoutExceptionHandling();
        $user = User::factory()->create();
        $classroom =  Classroom::factory()->create(['teacher_id' => $user->id]);

//        $this->expectException('Illuminate\Auth\Access\AuthorizationException');


        Livewire::test(\App\Http\Livewire\StudentList::class)
            ->call('render')
            ->assertset('classroom_id', $classroom->id)
            ->assertViewIs('livewire.students.student-list');
    }

}
