<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Models\Permission;
use DB;


class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the user's initials
     */
    public function initials(): string
    {
        return Str::of($this->name)
            ->explode(' ')
            ->map(fn (string $name) => Str::of($name)->substr(0, 1))
            ->implode('');
    }


    //This area for checkBok Loop for select roles permission
    public static function getpermissionGroups(){
        
        $permission_groups = DB::table('permissions')
                                ->select('group_name')
                                ->groupBy('group_name')
                                ->get();

        return $permission_groups;
    }

    public static function getpermissionByGroupName($group_name){
        
        $permissions = DB::table('permissions')
                            ->select('name','id')
                            ->where('group_name', $group_name)
                            ->get();
        return $permissions;
    }

    //this is for edit roles permission checkbox selected
    public static function roleHasPermissions($roles, $permissions)
    {
        foreach ($permissions as $permission) {
            if (!$roles->hasPermissionTo($permission->name)) {
                return false;
            }
        }
        return true;
    }
    
}
