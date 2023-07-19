<?php

namespace Tests\Unit\Livewire;

use App\Models\Classroom;
use App\Models\User;
use Livewire\Livewire;
use Tests\TestCase;

class ClassRoomTest extends TestCase
{
    public function test_it_can_render_classroom_page()
    {
        $user = User::factory()->create();
        $classroom =  Classroom::factory()->create(['teacher_id' => $user->id]);


        Livewire::test(\App\Http\Livewire\Classroom::class, [
            'classroom_id' => $classroom->id
        ])
            ->call('render')
            ->assertset('classroom_id', $classroom->id)
            ->assertViewIs('livewire.classroom');
    }

    public function test_it_can_render_classroom_list_page()
    {
        $user = User::factory()->create();
        Classroom::factory(3)->create(['teacher_id' => $user->id]);

        Livewire::test(\App\Http\Livewire\ClassroomList::class)
            ->call('render')
            ->assertViewHas('classrooms')
            ->assertViewIs('livewire.classroom-list');
    }

}
