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

class PermissionTest extends TestCase
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
            ['name'=>'permission-list', 'guard_name' => 'web'],
            ['name'=>'permission-delete', 'guard_name' => 'web'],
            ['name'=>'permission-create', 'guard_name' => 'web'],
            ['name'=>'permission-edit', 'guard_name' => 'web'],
        ];

        Role::create(['name' => 'teacher']);
        Permission::query()->insert($data);
        $this->user->givePermissionTo(['permission-list', 'permission-delete', 'permission-create', 'permission-edit']);;

        $classroom = Classroom::factory()->create(['teacher_id' => $this->user->id]);

        $this->quiz = Quiz::factory()->create(['classroom_id' => $classroom->id]);
    }

    public function test_it_can_render_permissions_page()
    {
        Livewire::actingAs($this->user);
        Livewire::test(\App\Http\Livewire\Permissions::class)
            ->call('render')
            ->assertViewHas('permissions')
            ->assertViewIs('livewire.permissions.index');
    }

    public function test_it_can_delete_permission()
    {
        $permission = Permission::create([
            'name' => 'test-permission' ,
            'guard_name' => 'web'
        ]);

        Livewire::actingAs($this->user);
        Livewire::test(\App\Http\Livewire\Permissions::class)
            ->set('deleteId', $permission->id)
            ->call('destroy');

        Livewire::test(\App\Http\Livewire\Permissions::class)
            ->set('deleteId', $permission->id)
            ->call('triggerConfirm', $permission->Id);

        Livewire::test(\App\Http\Livewire\Permissions::class)
            ->call('confirmed');

        Livewire::test(\App\Http\Livewire\Permissions::class)
            ->call('cancelled');

        $this->assertDatabaseMissing('permissions', [
            'id' => $permission->id
        ]);
    }

    public function test_it_can_store_permission()
    {
        Livewire::actingAs($this->user);
        Livewire::test(\App\Http\Livewire\Permissions::class)
            ->set('name', $name = $this->faker->name)
            ->call('store');

        $this->assertDatabaseHas('permissions', [
           'name' => $name
        ]);
    }

    public function test_it_can_show_permissions()
    {
        $permission = Permission::create([
            'name' => 'test-permission' ,
            'guard_name' => 'web'
        ]);

        Livewire::actingAs($this->user);
        Livewire::test(\App\Http\Livewire\Permissions::class)
            ->set('name',  $this->faker->name)
            ->set('selected_id', $permission->id)
            ->call('edit', $permission->id);

        Livewire::test(\App\Http\Livewire\Permissions::class)
            ->set('name', $this->faker->name)
            ->set('selected_id', $permission->id)
            ->call('show', $permission->id);
    }

    public function test_it_can_update_permissions()
    {
        $permission = Permission::create([
            'name' => 'test-permission' ,
            'guard_name' => 'web'
        ]);

        Livewire::actingAs($this->user);
        Livewire::test(\App\Http\Livewire\Permissions::class)
            ->set('name', $name = $this->faker->name)
            ->set('selected_id', $permission->id)
            ->call('update');

        $this->assertDatabaseHas('permissions', [
           'name' => $name
        ]);
    }

}
