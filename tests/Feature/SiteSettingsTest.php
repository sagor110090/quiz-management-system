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

class SiteSettingsTest extends TestCase
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
            ['name'=>'siteSetting-list', 'guard_name' => 'web'],
            ['name'=>'siteSetting-delete', 'guard_name' => 'web'],
            ['name'=>'siteSetting-create', 'guard_name' => 'web'],
            ['name'=>'siteSetting-edit', 'guard_name' => 'web'],
        ];

        Role::create(['name' => 'teacher']);
        Permission::query()->insert($data);
        $this->user->givePermissionTo(['siteSetting-list', 'siteSetting-delete', 'siteSetting-create', 'siteSetting-edit']);

        SiteSetting::create([
            'website_name' => $this->faker->firstName,
            'website_logo' => $this->faker->image,
            'website_favicon' => $this->faker->image,
        ]);
    }

    public function test_it_can_render_site_settings_page()
    {
        Livewire::actingAs($this->user);
        Livewire::test(\App\Http\Livewire\SiteSettings::class)
            ->call('render')
            ->assertViewIs('livewire.site-settings.index');
    }

    public function test_it_can_update_siteSettings()
    {
        $this->withoutExceptionHandling();

        Livewire::actingAs($this->user);
        Livewire::test(\App\Http\Livewire\SiteSettings::class, [
            'website_name' => $website_name = SiteSetting::first()->website_name,
            'website_logo' => null,
            'website_favicon' => null,
        ])
            ->set('website_name',  $this->faker->name)
            ->set('website_logo', null)
            ->set('website_favicon', null)
            ->call('update');

        $this->assertDatabaseMissing('site_settings', [
            'website_name' => $website_name
        ]);
    }

}
