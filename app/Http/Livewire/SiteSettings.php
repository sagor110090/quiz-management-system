<?php

namespace App\Http\Livewire;

use App\Models\SiteSetting;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class SiteSettings extends Component
{
    use WithPagination;
    use AuthorizesRequests;
    use WithFileUploads;

    protected $listeners = [
        'confirmed',
        'cancelled',
    ];

    protected $paginationTheme = 'bootstrap';
    public $website_name, $website_logo,$website_favicon;

    public function mount()
    {
        $record = SiteSetting::findOrFail(1);
        $this->website_name = $record->website_name;
        $this->website_logo = $record->website_logo;
        $this->website_favicon = $record->website_favicon;
    }

    public function render()
    {
        $this->authorize('siteSetting-edit');
        return view('livewire.site-settings.index')->extends('layouts.app');
    }

    public function update()
    {
        $this->authorize('siteSetting-edit');

        $this->validate([
            'website_name' => 'required',
            'website_logo' => 'nullable|image|max:1024', // 1MB Max
            'website_favicon' => 'nullable|image|max:1024', // 1MB Max
        ]);
        $image = '';
        $website_favicon = '';

        if ($this->website_logo) {
            $image = $this->website_logo->store('uploads', 'public');
        }
        if ($this->website_favicon) {
            $website_favicon = $this->website_favicon->store('uploads', 'public');
        }

        $record = SiteSetting::find(1);
        $record->update([
            'website_name' => $this->website_name,
            'website_logo' => $image,
            'website_favicon' => $website_favicon,
        ]);

        $this->alert('success', 'SiteSetting Successfully updated.');
    }

}
