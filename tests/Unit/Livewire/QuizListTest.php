<?php

namespace Tests\Unit\Livewire;

use App\Models\Classroom;
use App\Models\Quiz;
use App\Models\User;
use http\Env\Request;
use Livewire\Livewire;
use Tests\TestCase;

class QuizListTest extends TestCase
{
    /**
     * @var \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
     */
    private $user;
    /**
     * @var \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
     */
    private $classroom;
    /**
     * @var \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
     */
    private $quiz;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();

        $this->classroom =  Classroom::factory()->create(['teacher_id' => $this->user->id]);

        $this->quiz= Quiz::factory()->create(['classroom_id' => $this->classroom->id]);
    }

    public function test_it_can_render_quiz_list_page()
    {
        Livewire::actingAs($this->user);
        Livewire::test(\App\Http\Livewire\QuizList::class, [
            'quiz_id' => $this->quiz->id
        ])
            ->call('render')
            ->assertset(  'quiz_id' , $this->quiz->id)
            ->assertViewHas('quiz')
            ->assertViewIs('livewire.quiz-list');
    }
}
