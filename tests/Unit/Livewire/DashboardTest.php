<?php

namespace Tests\Unit\Livewire;

use App\Models\Classroom;
use App\Models\User;
use Livewire\Livewire;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    public function test_it_can_render_dashboard_page()
    {
        Livewire::test(\App\Http\Livewire\Dashboard::class)
            ->call('render')
            ->assertViewIs('livewire.dashboard');
    }

}
