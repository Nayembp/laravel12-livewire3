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
            <a href="#"
               class="text-sm text-indigo-600 hover:text-indigo-800 font-medium">
                Back
            </a>
        </div>

        <form wire:submit.prevent="updatePermission">
            <div class="space-y-6">
                <div>
                    <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Role Name:</label>
                    <div class="mt-1 text-gray-900 dark:text-gray-100 font-semibold">
                        {{ $currentRole->name }}
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
                            @foreach($permissions as $permission)
                                <div class="flex items-center space-x-1">
                                    <input type="checkbox"
                                           wire:model="selectedPermissions"
                                           value="{{ $permission->id }}"
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

                <button type="submit"
                        class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-medium rounded-md shadow-sm">
                    Submit
                </button>
            </div>
        </form>
    </div>
</div>
