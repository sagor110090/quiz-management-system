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

class ClassroomsTest extends TestCase
{
    private $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();

        $data = [
            ['name' => 'classroom-delete', 'guard_name' => 'web'],
            ['name' => 'classroom-list', 'guard_name' => 'web'],
            ['name' => 'classroom-create', 'guard_name' => 'web'],
            ['name' => 'classroom-edit', 'guard_name' => 'web'],
        ];

        Role::create(['name' => 'teacher']);
        Permission::query()->insert($data);
        $this->user->givePermissionTo(['classroom-delete', 'classroom-list', 'classroom-create', 'classroom-edit']);;

        Classroom::factory(2)->create(['teacher_id' => $this->user->id]);
    }

    public function test_it_can_render_classroom_page()
    {
        Livewire::actingAs($this->user);
        Livewire::test(\App\Http\Livewire\Classrooms::class)
            ->call('render')
            ->assertViewIs('livewire.classrooms.index');
    }

    public function test_it_can_delete_a_classroom()
    {
        $classroom = Classroom::query()->first();

        Livewire::actingAs($this->user);
        Livewire::test(\App\Http\Livewire\Classrooms::class)
            ->set('deleteId', $classroom->id)
            ->call('destroy');

        Livewire::test(\App\Http\Livewire\Classrooms::class)
            ->set('deleteId', $classroom->id)
            ->call('triggerConfirm', $classroom->Id);

        Livewire::test(\App\Http\Livewire\Classrooms::class)
            ->call('confirmed');

        Livewire::test(\App\Http\Livewire\Classrooms::class)
            ->call('cancelled');

        $this->assertDatabaseMissing('classrooms', [
            'id' => $classroom->id
        ]);
    }

    public function test_it_can_create_classrooms()
    {
        Livewire::actingAs($this->user);
          Livewire::test(\App\Http\Livewire\Classrooms::class)
              ->set('classroom_name', $name = $this->faker->name)
              ->set('classroom_unique_id', $unique_id = $this->faker->uuid)
              ->call('store');

        $this->assertDatabaseHas('classrooms', [
            'classroom_name' => $name,
            'classroom_unique_id' => $unique_id,
        ]);
    }

    public function test_it_can_show_classrooms()
    {
        $classroom = Classroom::query()->first();

        Livewire::actingAs($this->user);
        Livewire::test(\App\Http\Livewire\Classrooms::class)
            ->call('edit', $classroom->id);

         Livewire::test(\App\Http\Livewire\Classrooms::class)
             ->call('show', $classroom->id);
    }

    public function test_it_can_update_classrooms()
    {
        $classroom = Classroom::query()->first();

        Livewire::actingAs($this->user);
        Livewire::test(\App\Http\Livewire\Classrooms::class)
            ->set('selected_id', $classroom->id)
            ->set('classroom_name', $name = $this->faker->name)
            ->set('classroom_unique_id', $unique_id = $this->faker->uuid)
            ->call('update');

        $this->assertDatabaseHas('classrooms', [
            'classroom_name' => $name,
            'classroom_unique_id' => $unique_id,
            'teacher_id' => $this->user->id,
        ]);
    }

}
