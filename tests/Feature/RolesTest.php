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

class RolesTest extends TestCase
{
    /**
     * @var \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
     */
    private $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();

        $data = [
            ['name'=>'role-list', 'guard_name' => 'web'],
            ['name'=>'role-delete', 'guard_name' => 'web'],
            ['name'=>'role-create', 'guard_name' => 'web'],
            ['name'=>'role-edit', 'guard_name' => 'web'],
        ];

        Role::create(['name' => 'teacher']);
        Permission::query()->insert($data);
        $this->user->givePermissionTo(['role-list', 'role-delete', 'role-create', 'role-edit']);;

        $classroom = Classroom::factory()->create(['teacher_id' => $this->user->id]);

        $this->quiz = Quiz::factory()->create(['classroom_id' => $classroom->id]);
    }

    public function test_it_can_render_roles_page()
    {
        Livewire::actingAs($this->user);
        Livewire::test(\App\Http\Livewire\Roles::class)
            ->call('render')
            ->assertViewHas('roles')
            ->assertViewIs('livewire.roles.index');
    }

    public function test_it_can_delete_permission()
    {
        $role = Permission::create([
            'name' => 'test-permission' ,
            'guard_name' => 'web'
        ]);

        Livewire::actingAs($this->user);
        Livewire::test(\App\Http\Livewire\Roles::class)
            ->set('deleteId', $role->id)
            ->call('destroy');

        Livewire::test(\App\Http\Livewire\Roles::class)
            ->set('deleteId', $role->id)
            ->call('triggerConfirm', $role->Id);

        Livewire::test(\App\Http\Livewire\Roles::class)
            ->call('confirmed');

        Livewire::test(\App\Http\Livewire\Roles::class)
            ->call('cancelled');

        $this->assertDatabaseMissing('roles', [
            'id' => $role->id
        ]);
    }

    public function test_it_can_store_permission()
    {
        Permission::create( ['name'=>'role-edits', 'guard_name' => 'web']);

        Livewire::actingAs($this->user);
        Livewire::test(\App\Http\Livewire\Roles::class)
            ->set('name', $name = $this->faker->name)
            ->set('selected_permission',  [ 'name'=>'role-edits'])
            ->call('store');

        $this->assertDatabaseHas('roles', [
           'name' => $name
        ]);
    }

    public function test_it_can_show_permissions()
    {
        $role = Role::create([
            'name' => 'test-role' ,
            'guard_name' => 'web'
        ]);

        Livewire::actingAs($this->user);
        Livewire::test(\App\Http\Livewire\Roles::class)
            ->set('name',  $this->faker->name)
            ->set('selected_id', $role->id)
            ->call('edit', $role->id);

        Livewire::test(\App\Http\Livewire\Roles::class)
            ->set('name', $this->faker->name)
            ->set('selected_id', $role->id)
            ->call('show', $role->id);
    }

    public function test_it_can_update_roles()
    {
        Permission::create( ['name'=>'role-edits', 'guard_name' => 'web']);

        $role = Role::create([
            'name' => 'test-role' ,
            'guard_name' => 'web'
        ]);

        Livewire::actingAs($this->user);
        Livewire::test(\App\Http\Livewire\Roles::class)
            ->set('name', $name = $this->faker->name)
            ->set('selected_permission', ['name'=>'role-edits'])
            ->set('selected_id', $role->id)
            ->call('update');

        $this->assertDatabaseHas('roles', [
           'name' => $name
        ]);
    }

}
