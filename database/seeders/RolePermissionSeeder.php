<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rolesToCreate = ['super-admin', 'admin'];

        foreach ($rolesToCreate as $roleName) {
            Role::create(['name' => $roleName]);
        }

        $permissionsAndGroups = [
            'Member' => ['member.view', 'member.add', 'member.update', 'member.delete'],
            'Founders' => ['founders.view', 'founders.add', 'founders.update', 'founders.delete'],
            'Activities' => ['activities.view', 'activities.add', 'activities.update', 'activities.delete'],
            'RolesAndPermissions' => ['r&p.view', 'r&p.add', 'r&p.update', 'r&p.delete'],
            
        ];
    
        foreach ($permissionsAndGroups as $groupName => $permissions) {
            foreach ($permissions as $permissionName) {
                Permission::create(['name' => $permissionName, 'group_name' => $groupName]);
            }
        }
    }
}
