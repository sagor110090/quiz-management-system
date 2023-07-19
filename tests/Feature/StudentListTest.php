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

class StudentListTest extends TestCase
{
    /**
     * @var \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
     */
    private $user, $quiz;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();

        $data = [
            ['name'=>'student-delete', 'guard_name' => 'web'],
            ['name'=>'student-list', 'guard_name' => 'web'],
            ['name'=>'student-mail', 'guard_name' => 'web'],
        ];

        Role::create(['name' => 'teacher']);
        Permission::query()->insert($data);
        $this->user->givePermissionTo(['student-delete', 'student-list', 'student-mail']);;

        $classroom = Classroom::factory()->create(['teacher_id' => $this->user->id]);

        $this->quiz = Quiz::factory()->create(['classroom_id' => $classroom->id]);
    }

    public function test_it_can_render_student_lists_page()
    {
        Livewire::actingAs($this->user);
        Livewire::test(\App\Http\Livewire\StudentList::class)
            ->call('render')
            ->assertViewIs('livewire.students.student-list');
    }

    public function test_it_can_delete_a_student()
    {
        $student = User::factory()->create();

        Livewire::actingAs($this->user);
        Livewire::test(\App\Http\Livewire\StudentList::class)
            ->set('deleteId', $student->id)
            ->call('destroy');

        Livewire::test(\App\Http\Livewire\StudentList::class)
            ->set('deleteId', $student->id)
            ->call('triggerConfirm', $student->Id);

        Livewire::test(\App\Http\Livewire\StudentList::class)
            ->call('confirmed');

        Livewire::test(\App\Http\Livewire\StudentList::class)
            ->call('cancelled');

        $this->assertDatabaseMissing('users', [
            'id' => $student->id
        ]);
    }

    public function test_it_can_send_student_email()
    {
        $student = User::factory()->create();
        Mail::fake();
        $message =  $this->faker->sentence(10);

        Livewire::actingAs($this->user);
        Livewire::test(\App\Http\Livewire\StudentList::class)
            ->set('message', $message)
            ->call('sendMail');

        Livewire::test(\App\Http\Livewire\StudentList::class)
            ->call('edit', $student->email);

        Mail::assertSent(studentMail::class);
    }

}
