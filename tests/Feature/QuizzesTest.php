<?php

namespace Tests\Feature;

use App\Mail\studentMail;
use App\Models\Classroom;
use App\Models\Quiz;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Livewire\Livewire;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class QuizzesTest extends TestCase
{
    private $user, $classroom, $quiz;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();

        $data = [
            ['name' => 'quiz-delete', 'guard_name' => 'web'],
            ['name' => 'quiz-list', 'guard_name' => 'web'],
            ['name' => 'quiz-create', 'guard_name' => 'web'],
            ['name' => 'quiz-edit', 'guard_name' => 'web'],
        ];

        Role::create(['name' => 'teacher']);
        Permission::query()->insert($data);
        $this->user->givePermissionTo(['quiz-delete', 'quiz-list', 'quiz-create', 'quiz-edit']);;

        $this->classroom = Classroom::factory()->create(['teacher_id' => $this->user->id]);

        $this->quiz = Quiz::factory()->create(['classroom_id' => $this->classroom->id]);
    }

    public function test_it_can_render_quiz_page()
    {
        Livewire::actingAs($this->user);
        Livewire::test(\App\Http\Livewire\Quizs::class)
            ->call('render')
            ->assertViewHas('quizzes')
            ->assertViewIs('livewire.quizzes.index');
    }

    public function test_it_can_delete_quiz()
    {
        $quiz = Quiz::query()->first();

        Livewire::actingAs($this->user);
        Livewire::test(\App\Http\Livewire\Quizs::class)
            ->set('deleteId', $quiz->id)
            ->call('destroy');

        Livewire::test(\App\Http\Livewire\Quizs::class)
            ->set('deleteId', $quiz->id)
            ->call('triggerConfirm', $quiz->Id);

        Livewire::test(\App\Http\Livewire\Quizs::class)
            ->call('confirmed');

        Livewire::test(\App\Http\Livewire\Quizs::class)
            ->call('cancelled');

        $this->assertDatabaseMissing('quizzes', [
            'id' => $quiz->id
        ]);
    }

    public function test_it_can_create_quizzes()
    {
        Livewire::actingAs($this->user);
        Livewire::test(\App\Http\Livewire\Quizs::class)
            ->set('quiz_name', $name = $this->faker->name)
            ->set('per_question_mark', rand(1, 100))
            ->set('classroom_id', $this->classroom->id)
            ->call('store');

        $this->assertDatabaseHas('quizzes', [
            'quiz_name' => $name,
            'classroom_id' => $this->classroom->id,
        ]);
    }

    public function test_it_can_show_quizzes()
    {
        $quiz = Quiz::query()->first();

        Livewire::actingAs($this->user);
        Livewire::test(\App\Http\Livewire\Quizs::class)
            ->call('edit', $quiz->id);

        Livewire::test(\App\Http\Livewire\Quizs::class)
            ->call('show', $quiz->id);
    }

    public function test_it_can_update_quiz()
    {
        Livewire::actingAs($this->user);
        Livewire::test(\App\Http\Livewire\Quizs::class)
            ->set('selected_id', $this->quiz->id)
            ->set('quiz_name', $name = $this->faker->name)
            ->set('per_question_mark', $mark = rand(1, 100))
            ->set('classroom_id', $this->classroom->id)
            ->call('update');

        $this->assertDatabaseHas('quizzes', [
            'quiz_name' => $name,
            'per_question_mark' => $mark,
        ]);
    }

}
