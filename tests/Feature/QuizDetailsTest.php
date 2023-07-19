<?php

namespace Tests\Feature;

use App\Mail\studentMail;
use App\Models\Answer;
use App\Models\Classroom;
use App\Models\Quiz;
use App\Models\SiteSetting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Mail;
use Livewire\Livewire;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class QuizDetailsTest extends TestCase
{
    /**
     * @var \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
     */
    private $user, $quiz, $student, $answer;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();

        $classroom = Classroom::factory()->create(['teacher_id' => $this->user->id]);

        $this->quiz = Quiz::factory()->create(['classroom_id' => $classroom->id]);

        $this->student = User::factory()->create();
        $this->answer = Answer::factory()->create([
            'user_id' => $this->student->id,
            'quiz_id' => $this->quiz->id,
            'mark' => rand(1, 100),
        ]);
    }

    public function test_it_can_render_quiz_details_page()
    {
        Livewire::actingAs($this->user);
        Livewire::test(\App\Http\Livewire\Answers\QuizDetail::class, [
            'quiz_id' => $this->quiz->id,
            'student_id' => $this->student->id
        ])
            ->call('render')
            ->assertViewIs('livewire.answers.quiz-detail');
    }

    public function test_it_can_show_quiz_details()
    {
        Livewire::actingAs($this->user);
        Livewire::test(\App\Http\Livewire\Answers\QuizDetail::class, [
            'quiz_id' => $this->quiz->id,
            'student_id' => $this->student->id
        ])
            ->call('show', $this->answer->id)
            ->assertViewIs('livewire.answers.quiz-detail');
    }

    public function test_it_can_store_quiz_mark()
    {
        Livewire::actingAs($this->user);
        Livewire::test(\App\Http\Livewire\Answers\QuizDetail::class, [
            'quiz_id' => $this->quiz->id,
            'student_id' => $this->student->id
        ])
            ->set('mark', $mark = rand(1,100))
            ->set('answer', $this ->answer)
            ->call('storeMark')
            ->assertViewIs('livewire.answers.quiz-detail');

        $this->assertDatabaseHas('answers', [
           'mark' => $mark ,
            'id' => $this->answer->id
        ]);
    }

}
