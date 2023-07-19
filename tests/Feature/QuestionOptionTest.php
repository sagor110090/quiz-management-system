<?php

namespace Tests\Feature;

use App\Models\Classroom;
use App\Models\Question;
use App\Models\QuestionOption;
use App\Models\Quiz;
use App\Models\User;
use Livewire\Livewire;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class QuestionOptionTest extends TestCase
{
    private $user, $classroom, $quiz;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();

        $data = [
            ['name' => 'questionOption-delete', 'guard_name' => 'web'],
            ['name' => 'questionOption-list', 'guard_name' => 'web'],
            ['name' => 'questionOption-create', 'guard_name' => 'web'],
            ['name' => 'questionOption-edit', 'guard_name' => 'web'],
        ];

        Role::create(['name' => 'teacher']);
        Permission::query()->insert($data);
        $this->user->givePermissionTo(['questionOption-delete', 'questionOption-list', 'questionOption-create', 'questionOption-edit']);;

        $this->classroom = Classroom::factory()->create(['teacher_id' => $this->user->id]);

        $this->quiz = Quiz::factory()->create(['classroom_id' => $this->classroom->id]);
        $question = Question::factory()->create([
            'quiz_id' => $this->quiz->id,
            'answer' => $this->faker->word,
        ]);

        QuestionOption::factory()->create([
            'question_id' => $question->id
        ]);
    }

    public function test_it_can_render_question_option_component()
    {
        Livewire::actingAs($this->user);
        Livewire::test(\App\Http\Livewire\QuestionOptions::class)
            ->call('render')
            ->assertViewHas('questionOptions')
            ->assertViewIs('livewire.question-options.index');
    }

    public function test_it_can_delete_question()
    {
        $question_option = QuestionOption::query()->first();

        Livewire::actingAs($this->user);
        Livewire::test(\App\Http\Livewire\QuestionOptions::class)
            ->set('deleteId', $question_option->id)
            ->call('destroy');

        Livewire::test(\App\Http\Livewire\QuestionOptions::class)
            ->set('deleteId', $question_option->id)
            ->call('triggerConfirm', $question_option->Id);

        Livewire::test(\App\Http\Livewire\QuestionOptions::class)
            ->call('confirmed');

        Livewire::test(\App\Http\Livewire\QuestionOptions::class)
            ->call('cancelled');

        $this->assertDatabaseMissing('question_options', [
            'id' => $question_option->id
        ]);
    }

    public function test_it_can_create_question_options()
    {
        $question = Question::query()->first();

        $payload = [
            'option_name' => $this->faker->name,
            'question_id' => $question->id
        ];

        Livewire::actingAs($this->user);
        Livewire::test(\App\Http\Livewire\QuestionOptions::class)
            ->set('selected_id', $question->id)
            ->set('option_name', $payload['option_name'])
            ->set('question_id', $payload['question_id'])
            ->call('store');

        $this->assertDatabaseHas('question_options', [
            'question_id' => $payload['question_id'],
            'option_name' => $payload['option_name'],
        ]);
    }


    public function test_it_can_show_question_options()
    {
        $question_option = QuestionOption::query()->first();

        Livewire::actingAs($this->user);
        Livewire::test(\App\Http\Livewire\QuestionOptions::class)
            ->call('edit', $question_option->id);

        Livewire::test(\App\Http\Livewire\QuestionOptions::class)
            ->call('show', $question_option->id);
    }

    public function test_it_can_update_question_option()
    {
        $question = Question::query()->first();

        $payload = [
            'option_name' => $this->faker->name,
            'question_id' => $question->id
        ];
        Livewire::actingAs($this->user);
        Livewire::test(\App\Http\Livewire\QuestionOptions::class)
            ->set('selected_id', $question->id)
            ->set('option_name', $payload['option_name'])
            ->set('question_id', $payload['question_id'])
            ->call('update');

        $this->assertDatabaseHas('question_options', [
            'question_id' => $payload['question_id'],
            'option_name' => $payload['option_name'],
        ]);
    }

    public function test_it_can_bulk_delete()
    {
        $question_option = QuestionOption::query()->first();

        Livewire::actingAs($this->user);
        Livewire::test(\App\Http\Livewire\QuestionOptions::class)
            ->set('checked', [$question_option->id])
            ->call('bulkDelete');

        Livewire::test(\App\Http\Livewire\QuestionOptions::class)
            ->call('bulkDeleteTriggerConfirm');
    }

}
