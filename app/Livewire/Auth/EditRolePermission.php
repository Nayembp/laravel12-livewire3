<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class EditRolePermission extends Component
{
    public $roleId;
    public $currentRole;
    public $selectedPermissions = [];
    public $permission_groups = [];
    public $groupPermissions = [];

    public function mount($id)
    {
        $this->roleId = $id;
        $this->currentRole = Role::with('permissions')->findOrFail($id);
        $this->selectedPermissions = $this->currentRole->permissions->pluck('id')->toArray();

        $groups = User::getpermissionGroups();
        $this->permission_groups = $groups;

        foreach ($groups as $group) {
            $this->groupPermissions[$group->group_name] =
                User::getpermissionByGroupName($group->group_name)->pluck('id')->toArray();
        }
    }

    public function render()
    {
        return view('livewire.auth.edit-role-permission');
    }

    public function toggleGroupPermissions($group)
    {
        $groupPerms = $this->groupPermissions[$group] ?? [];

        if ($this->groupChecked($group)) {
            $this->selectedPermissions = array_diff($this->selectedPermissions, $groupPerms);
        } else {
            $this->selectedPermissions = array_unique(array_merge($this->selectedPermissions, $groupPerms));
        }
    }

    public function groupChecked($group)
    {
        $groupPerms = $this->groupPermissions[$group] ?? [];
        return count(array_intersect($this->selectedPermissions, $groupPerms)) === count($groupPerms);
    }

    public function updatePermission()
    {
        if (!$this->currentRole) {
            session()->flash('message', 'No role selected.');
            return;
        }

        $this->currentRole->syncPermissions($this->selectedPermissions);

        session()->flash('message', 'Permissions updated successfully.');
        return redirect()->route('rolepermission.index');
    }
}
