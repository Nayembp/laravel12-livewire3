<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Livewire\WithPagination;
class Rolepermission extends Component
{
    use WithPagination;

    public $showAddRoleForm = false;
    public $showEditRoleForm = false;

    public $RoleName = '';
    public $editingRoleId = null;

 

    public function render()
    {
        
        $roles = Role::with('permissions')->latest()->paginate(10);
        $permissions = Permission::all();
        return view('livewire.auth.rolepermission', [
            'roles' => $roles,
            'permissions' => $permissions
        ]);
    }

   

    public function loadRoles()
    {
        $this->roles = Role::with('permissions')->latest()->get();
    }

    public function addRoleForm()
    {
        $this->reset(['RoleName', 'showEditRoleForm']);
        $this->showAddRoleForm = true;
    }

   
    public function roleStore()
    {
        $validated = $this->validate([
            'RoleName' => 'required|string|min:3|unique:roles,name',
        ]);

        Role::create(['name' => $validated['RoleName']]);       

        $this->reset(['RoleName', 'showAddRoleForm']);
        $this->resetErrorBag();
        $this->dispatch('toast', message: 'Role added successfully!');
    }

    public function editRole($id)
    {
        $role = Role::findOrFail($id);
        $this->editingRoleId = $role->id;
        $this->RoleName = $role->name;

        $this->showEditRoleForm = true;
        $this->showAddRoleForm = false;
        $this->resetErrorBag();
    }

    public function updateRole()
    {
        $this->validate([
            'RoleName' => 'required|string|min:3|unique:roles,name,' . $this->editingRoleId,
        ]);

        $role = Role::findOrFail($this->editingRoleId);
        $role->name = $this->RoleName;
        $role->save();

        session()->flash('message', 'Role updated successfully!');
        $this->reset(['RoleName', 'editingRoleId', 'showEditRoleForm']);
        $this->resetErrorBag();
        $this->loadRoles(); // Refresh list live
    }

    public function deleteRole($id)
    {
        $role = Role::findOrFail($id);
        $role->delete();
       
        $this->dispatch('toast', ['message' => 'Role deleted successfully!']);

    }
}
