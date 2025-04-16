<div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow mb-2 mt-2">
    <h2 class="text-xl font-semibold mb-4 text-gray-800 dark:text-gray-100">Add New Role</h2>          

    <form wire:submit.prevent="roleStore" class="flex flex-col md:flex-row md:items-center md:space-x-4 space-y-3 md:space-y-0">
       
        <div class="flex flex-col">
            <flux:input.group>
                <flux:input wire:model="RoleName" placeholder="Role Name" />
                <flux:button  type="submit" icon="plus">Save</flux:button>
            </flux:input.group>
            
            @error('RoleName')
                <span class="text-red-600 text-sm mt-3">{{ $message }}</span>
            @enderror
        </div>                                        
    </form>
</div>