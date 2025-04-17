<?php

namespace App\Livewire\Settings\Globalsettings;

use Livewire\Component;
use App\Models\AppSetting;
use Livewire\WithFileUploads;

class AppSettings extends Component
{
    use WithFileUploads;
    public $app_name, $app_logo, $logo_preview;
   

    public function mount()
    {
        $this->app_name = AppSetting::where('key', 'app_name')->value('value');
        $this->logo_preview = AppSetting::where('key', 'app_logo')->value('value');
    }

    public function render()
    {
        return view('livewire.settings.globalsettings.app-settings');
    }

    protected function setSetting($key, $value)
    {
        AppSetting::updateOrCreate(
            ['key' => $key],
            ['value' => $value]
        );
    }


    public function updateBasicSettings()
    {
        $this->validate([
            'app_name' => 'required|string|max:255',
            'app_logo' => 'nullable|image|max:2048', 
        ]);
      
        $this->setSetting('app_name', $this->app_name);

        
        if ($this->app_logo) {
            $oldLogo = settings('app_logo');

            if ($oldLogo && file_exists(public_path('storage/' . $oldLogo))) {
                unlink(public_path('storage/' . $oldLogo));
            }
            
            $path = $this->app_logo->store('uploads/logo', 'public');
            $this->setSetting('app_logo', $path);
        }

        $this->dispatch('toast', message: 'Settings updated successfully!', type: 'success');
    }




}
