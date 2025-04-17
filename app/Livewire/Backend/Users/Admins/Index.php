<?php

namespace App\Livewire\Backend\Users\Admins;

use Spatie\Permission\Models\Role;
use Livewire\Component;
use App\Models\User;
use Livewire\WithPagination;
class Index extends Component
{
    
    use WithPagination;

    public $search = '';

    public function render()
    {
        $admins = User::with('roles')
            ->when($this->search, fn($query) => 
                $query->where('name', 'like', '%' . $this->search . '%')
            )
            ->latest()
            ->paginate(10);

        return view('livewire.backend.users.admins.index', compact('admins'));
    }

    public function toggleStatus($userId)
    {
        abort_unless(auth()->user()->can('user.update'), 403);

        $user = User::findOrFail($userId);        
        $user->status = $user->status === 'active' ? 'inactive' : 'active';
        $user->save();

        $this->dispatch('toast', message: 'User status updated to ' . ucfirst($user->status), type: 'success');

    }


    public function deleteadmin($id)
    {
        try {
            $admin = User::findOrFail($id);
            
            if ($admin->id === auth()->id()) {
                $this->dispatch('toast', message: 'You cannot delete yourself!', type: 'error');
                return;
            }

            if ($admin->hasRole('super-admin')) {
                $this->dispatch('toast', message: 'You cannot delete a Super Admin!', type: 'error');
                return;
            }
            $admin->delete();
            $this->dispatch('toast', message: 'Admin deleted successfully.', type: 'success');
        } catch (\Exception $e) {
            $this->dispatch('toast', message: 'Failed to delete admin: ' . $e->getMessage(), type: 'error');
        }
    }


}
