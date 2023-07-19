<?php

namespace Tests\Unit\Livewire;

use App\Http\Livewire\Users;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Livewire;
use Mockery\Mock;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class UsersTest extends TestCase
{
    /**
     * @var Users
     */
    private $usersComponent, $user;

    protected function setUp(): void
    {
        parent::setUp();


        $this->user = User::factory()->create();

        $data = [
            ['name' => 'user-list', 'guard_name' => 'web'],
            ['name' => 'user-delete', 'guard_name' => 'web'],
            ['name' => 'user-create', 'guard_name' => 'web'],
            ['name' => 'user-edit', 'guard_name' => 'web'],
        ];

        Role::create(['name' => 'teacher']);
        Permission::query()->insert($data);
        $this->user->givePermissionTo(['user-list', 'user-delete', 'user-create', 'user-edit']);
    }

    public function test_render_component()
    {
        $this->withoutExceptionHandling();

        Livewire::actingAs($this->user);
        Livewire::test(Users::class)
            ->call('render')
            ->assertViewIs('livewire.users.index')
            ->assertViewHas('users');
    }

    public function test_can_store_user()
    {
        $this->withoutExceptionHandling();
        Role::create([
            'name' => 'student'
        ]);

        $payload = [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->email,
            'password' => $this->faker->password,
            'selected_roles' => ['student'],
        ];

        Livewire::actingAs($this->user);
        Livewire::test(Users::class)
            ->set('name', $payload['name'])
            ->set('email', $payload['email'])
            ->set('password', $payload['password'])
            ->set('password_confirmation', $payload['password'])
            ->set('selected_roles', $payload['selected_roles'])
            ->call('store')
            ->assertViewIs('livewire.users.index');

        unset($payload['password']);
        unset($payload['selected_roles']);
        $this->assertDatabaseHas('users', $payload);
    }

    public function test_it_can_show_users()
    {
        $user = User::factory()->create();
        $role = Role::create(['name' => 'student']);
        $user->assignRole($role);

        Livewire::actingAs($this->user);
        Livewire::test(\App\Http\Livewire\Users::class)
            ->call('edit', $user->id);

        Livewire::test(\App\Http\Livewire\Users::class)
            ->call('show', $user->id);
    }

    public function test_it_can_update_users()
    {
        $user = User::factory()->create();

         $payload = [
             'name' => $this->faker->name,
             'email' => $user->email,
             'password' => $this->faker->password,
             'roles' => ['student'],
         ];

        Livewire::actingAs($this->user);
        Livewire::test(\App\Http\Livewire\Users::class)
            ->set('selected_id', $user->id)
            ->set('name', $payload['name'])
            ->set('email', $payload['email'])
            ->set('password', $payload['password'])
            ->set('password_confirmation', $payload['password'])
            ->set('roles', $payload['roles'])
            ->call('update');

        unset($payload['password']);
        unset($payload['roles']);
        $this->assertDatabaseHas('users', $payload);
    }

    public function test_it_can_delete_a_classroom()
    {
        $user = User::factory()->create();

        Livewire::actingAs($this->user);
        Livewire::test(\App\Http\Livewire\Users::class)
            ->set('deleteId', $user->id)
            ->call('destroy');

        Livewire::test(\App\Http\Livewire\Users::class)
            ->set('deleteId', $user->id)
            ->call('triggerConfirm', $user->Id);

        Livewire::test(\App\Http\Livewire\Users::class)
            ->call('confirmed');

        Livewire::test(\App\Http\Livewire\Users::class)
            ->call('cancelled');

        $this->assertDatabaseMissing('classrooms', [
            'id' => $user->id
        ]);
    }
}
