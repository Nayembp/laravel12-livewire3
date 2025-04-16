<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\AppSetting;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(RolePermissionSeeder::class);

        $setting = [
            'app_name' => 'My App',
            'app_logo' => 'logo.png'
        ];

        foreach($setting as $key => $value){
            AppSetting::create([
                'key'    => $key,
                'value'  => $value
            ]);
        }

        $user = User::factory()->create([
            'name' => 'Super-Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('password')
        ]);
        
        $role = Role::where('name', 'super-admin')->first(); 
        $user->assignRole($role);
        $permissions = Permission::all();  
        $role->givePermissionTo($permissions);
    }
}
