<?php

namespace Tests\Feature;

use App\Mail\studentMail;
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

class AnswersListTest extends TestCase
{

    private $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();

        $data = [
            ['name' => 'student-list', 'guard_name' => 'web'],
        ];

        Role::create(['name' => 'teacher']);
        Permission::query()->insert($data);
        $this->user->givePermissionTo(['student-list']);
    }


    public function test_it_can_render_answers_list_page()
    {
        $student = User::factory()->create([
            'name' => $name = $this->faker->name
        ]);

       $role =  Role::create(['name' => 'student']);
       $student->assignRole($role);

        Livewire::actingAs($this->user);
        Livewire::test(\App\Http\Livewire\AnswersList::class)
            ->call('render')
            ->assertViewHas('students')
            ->assertViewIs('livewire.answers.answers-list');
    }

}
