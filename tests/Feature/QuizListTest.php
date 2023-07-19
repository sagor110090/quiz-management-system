<?php

namespace Tests\Feature;

use App\Models\Classroom;
use App\Models\Quiz;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class QuizListTest extends TestCase
{
    /**
     * @var \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
     */
    private $user, $quiz;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();

        $classroom =  Classroom::factory()->create(['teacher_id' => $this->user->id]);

        $this->quiz= Quiz::factory()->create(['classroom_id' => $classroom->id]);
    }

    public function test_it_can_store_answer_to_quiz()
    {
        $user = User::factory()->create();
        Classroom::factory()->create(['teacher_id' => $this->user->id]);

       $response =  $this->actingAs($this->user)->post("/classroom/{$this->quiz->id}/quiz", [
            'question' => [
                1,2
            ],
           'quiz_id' => $this->quiz->id,
           'short_question_answer' => [
               [ 'test answer one'],
               [ 'test answer two'],
           ],
           'short_question_correct' => [
               'test answer one',
               'test answer two',
           ],
           'missing_word' => [
               'missing word one', 'missing word two'
           ]
        ]);

       $response->assertStatus(302);
    }

    public function test_it_can_store_answer_to_quiz_when_long_question_is_present()
    {
        $user = User::factory()->create();
        Classroom::factory()->create(['teacher_id' => $this->user->id]);

       $response =  $this->actingAs($this->user)->post("/classroom/{$this->quiz->id}/quiz", [
            'long_question' => [
                1,2
            ],
           'quiz_id' => $this->quiz->id,
           'long_question_answer' => [
                'test answer one',
               'test answer two',
           ],
           'mark' => rand(1,100)
        ]);

       $response->assertStatus(302);
    }

}
