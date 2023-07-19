<?php

namespace Tests\Feature;

use App\Http\Livewire\Questions;
use App\Mail\studentMail;
use App\Models\Classroom;
use App\Models\Question;
use App\Models\Quiz;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Livewire\Livewire;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;


class QuestionsTest extends TestCase
{
    private $user, $classroom, $quiz;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();

        $data = [
            ['name' => 'question-delete', 'guard_name' => 'web'],
            ['name' => 'question-list', 'guard_name' => 'web'],
            ['name' => 'question-create', 'guard_name' => 'web'],
            ['name' => 'question-edit', 'guard_name' => 'web'],
        ];

        Role::create(['name' => 'teacher']);
        Permission::query()->insert($data);
        $this->user->givePermissionTo(['question-delete', 'question-list', 'question-create', 'question-edit']);;

        $this->classroom = Classroom::factory()->create(['teacher_id' => $this->user->id]);

        $this->quiz = Quiz::factory()->create(['classroom_id' => $this->classroom->id]);
        Question::factory()->create([
            'quiz_id' => $this->quiz->id,
            'answer' => $this->faker->word,
        ]);
    }

    public function test_it_can_render_questions_component()
    {
        Livewire::actingAs($this->user);
        Livewire::test(\App\Http\Livewire\Questions::class)
            ->call('render')
            ->assertViewHas('questions')
            ->assertViewIs('livewire.questions.index');
    }

    public function test_it_can_delete_question()
    {
        $quiz = Question::query()->first();

        Livewire::actingAs($this->user);
        Livewire::test(\App\Http\Livewire\Questions::class)
            ->set('deleteId', $quiz->id)
            ->call('destroy');

        Livewire::test(\App\Http\Livewire\Questions::class)
            ->set('deleteId', $quiz->id)
            ->call('triggerConfirm', $quiz->Id);

        Livewire::test(\App\Http\Livewire\Questions::class)
            ->call('confirmed');

        Livewire::test(\App\Http\Livewire\Questions::class)
            ->call('cancelled');

        $this->assertDatabaseMissing('questions', [
            'id' => $quiz->id
        ]);
    }

    public function test_it_can_create_question_when_it_is_long_written()
    {
        $payload = [
            'question' => $this->faker->sentence,
            'quiz_id' => $this->quiz->id,
            'option' => [
                0 => 'option_one', 1 => 'option_two'
            ],
            'answer' => $this->faker->word,
            'long_written' => 1
        ];

        Livewire::actingAs($this->user);
        Livewire::test(\App\Http\Livewire\Questions::class)
            ->set('question', $payload['question'])
            ->set('quiz_id', $payload['quiz_id'])
            ->set('answer', $payload['answer'])
            ->set('option', $payload['option'])
            ->set('long_written', $payload['long_written'])
            ->call('store');

        $this->assertDatabaseHas('questions', [
            'quiz_id' => $payload['quiz_id'],
            'question' => $payload['question'],
        ]);
    }

    public function test_it_can_create_question_when_it_is_not_long_written()
    {
        $payload = [
            'question' => $this->faker->sentence,
            'quiz_id' => $this->quiz->id,
            'option' => [
                0 => 'option_one', 1 => 'option_two'
            ],
            'answer' => $this->faker->word,
            'long_written' => 0,
            'missing_word' => 0
        ];

        Livewire::actingAs($this->user);
        Livewire::test(\App\Http\Livewire\Questions::class)
            ->set('quiz_id', $payload['quiz_id'])
            ->set('question', $payload['question'])
            ->set('option', $payload['option'])
            ->set('answer', $payload['answer'])
            ->set('long_written', $payload['long_written'])
            ->set('missing_word', $payload['missing_word'])
            ->call('store');

        $this->assertDatabaseHas('questions', [
            'quiz_id' => $payload['quiz_id'],
            'question' => $payload['question'],
        ]);

        $this->assertDatabaseCount('question_options', 2);
    }

    public function test_it_can_show_quizzes()
    {
        $question = Question::query()->first();

        Livewire::actingAs($this->user);
        Livewire::test(\App\Http\Livewire\Questions::class)
            ->call('edit', $question->id);

        Livewire::test(\App\Http\Livewire\Questions::class)
            ->call('show', $question->id);
    }

    public function test_it_can_update_quiz()
    {
        $question = Question::query()->first();

        $payload = [
            'question' => $this->faker->sentence,
            'quiz_id' => $this->quiz->id,
            'option' => [
                0 => 'option_one', 1 => 'option_two'
            ],
            'answer' => $this->faker->word,
            'long_written' => 1,
        ];
        Livewire::actingAs($this->user);
        Livewire::test(\App\Http\Livewire\Questions::class)
            ->set('selected_id', $question->id)
            ->set('quiz_id', $payload['quiz_id'])
            ->set('option', $payload['option'])
            ->set('question', $payload['question'])
            ->set('answer', $payload['answer'])
            ->set('long_written', $payload['long_written'])
            ->call('update');

        $this->assertDatabaseHas('questions', [
            'quiz_id' => $payload['quiz_id'],
            'question' => $payload['question'],
        ]);
    }

    public function test_it_can_bulk_delete()
    {
        $question = Question::query()->first();

        Livewire::actingAs($this->user);
        Livewire::test(\App\Http\Livewire\Questions::class)
            ->set('checked',[ $question->id])
            ->call('bulkDelete');

        Livewire::test(\App\Http\Livewire\Questions::class)
            ->call('bulkDeleteTriggerConfirm');
    }

}
