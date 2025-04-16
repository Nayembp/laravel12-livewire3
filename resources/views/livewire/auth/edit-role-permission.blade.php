<div>
    <div class="bg-white dark:bg-gray-900 shadow rounded-lg p-6 mt-2 mb-6">
        @if (session()->has('message'))
            <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
                {{ session('message') }}
            </div>
        @endif

        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100">
                Edit Role's Permission
            </h3>
            <flux:button wire:navigate href="{{ route('rolepermission.index') }}" icon="arrow-left" variant="danger" size="xs">
                Back
            </flux:button>
        </div>

        <form wire:submit.prevent="updatePermission">
            <div class="space-y-6">
                <div>
                    
                    <div class="mt-1 text-gray-900 dark:text-gray-100 font-semibold">
                        Role Name: <span class="font-semibold text-green-600 dark:text-green-400">{{ $currentRole->name }}</span> 
                    </div>
                </div>

                <hr class="border-gray-300 dark:border-gray-700">

                @foreach($permission_groups as $group)
                    @php
                        $permissions = \App\Models\User::getpermissionByGroupName($group->group_name);
                    @endphp

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <div class="flex items-center space-x-2">
                                <input type="checkbox"
                                       wire:click="toggleGroupPermissions('{{ $group->group_name }}')"
                                       @checked($this->groupChecked($group->group_name))
                                       class="text-indigo-600 dark:bg-gray-700 dark:border-gray-600 rounded">
                                <label class="text-sm font-semibold text-gray-800 dark:text-gray-200">
                                    {{ $group->group_name }}
                                </label>
                            </div>
                        </div>

                        <div class="flex flex-wrap gap-4">
                           <!-- Change this section in your blade file -->
                            @foreach($permissions as $permission)
                            <div class="flex items-center space-x-1">
                                <input type="checkbox"
                                    wire:model="selectedPermissions"
                                    value="{{ $permission->name }}" 
                                    id="perm_{{ $permission->id }}"
                                    class="text-indigo-600 dark:bg-gray-700 dark:border-gray-600 rounded">
                                <label for="perm_{{ $permission->id }}"
                                    class="text-sm text-gray-700 dark:text-gray-300">
                                    {{ $permission->name }}
                                </label>
                            </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
                <div class="flex justify-end">      
                    <flux:button type="submit" class="mt-2" size="sm">
                        Assign permission
                    </flux:button>
                </div>  

               
            </div>
        </form>
    </div>
</div>
