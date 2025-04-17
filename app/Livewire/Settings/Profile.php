<?php

namespace App\Livewire\Settings;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;

class Profile extends Component
{
    use WithFileUploads;
    public string $name = '';
   
   
    public string $email = '';
    public $image;
    public $currentImage = '';
    /**
     * Mount the component.
     */
    public function mount(): void
    {
        $user = Auth::user();
        $this->name = Auth::user()->name;
        $this->email = Auth::user()->email;
        $this->currentImage = $user->image;
    }

    /**
     * Update the profile information for the currently authenticated user.
     */
    public function updateProfileInformation(): void
    {
        $user = Auth::user();
    
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'image' => 'nullable|image|max:2048',
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($user->id),
            ],
        ]);
    
        // Update fields except image first
        $user->fill([
            'name' => $validated['name'],
            'email' => $validated['email'],
        ]);
    
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }
    
        // Handle image upload
        if (isset($validated['image'])) {
            // Delete old image if exists
            if ($user->image && file_exists(public_path('storage/' . $user->image))) {
                unlink(public_path('storage/' . $user->image));
            }
    
            // Store new image
            $path = $validated['image']->store('uploads/user-profile', 'public');
            $user->image = $path;
        }
    
        $user->save();
    
        $this->dispatch('toast', message: 'Profile updated successfully!', type: 'success');
    }
    

    /**
     * Send an email verification notification to the current user.
     */
    public function resendVerificationNotification(): void
    {
        $user = Auth::user();

        if ($user->hasVerifiedEmail()) {
            $this->redirectIntended(default: route('dashboard', absolute: false));

            return;
        }

        $user->sendEmailVerificationNotification();

        Session::flash('status', 'verification-link-sent');
    }
}
