<?php

use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use App\Livewire\Auth\Rolepermission;
use App\Livewire\Auth\EditRolePermission;
use App\Livewire\Backend\Users\Admins\Index;
use App\Livewire\Settings\Globalsettings\AppSettings;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth', 'role:super-admin'])->group(function () {
    Route::get('settings/globalsettings', AppSettings::class)->name('settings.globalsettings')->middleware('can:settings.view');
    Route::get('setting/rolepermission', Rolepermission::class)->name('rolepermission.index')->middleware('can:settings.view'); 
    Route::get('setting/{id}/edit-permissions', EditRolePermission::class)->name('rolepermission.edit')->middleware('can:settings.edit');;
    
    Route::get('backend/user/index', Index::class)->name('admin.index')->middleware('can:settings.view');



});


