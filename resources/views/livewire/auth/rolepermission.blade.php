 <div>

    @if (session()->has('message'))
        <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
            {{ session('message') }}
        </div>
    @endif


    <div class="p-3 bg-white dark:bg-zinc-900 shadow rounded-lg">        
      <div class="flex justify-between items-center">
          <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-100">
              Role and Permission
          </h2>

          @if ($showAddRoleForm || $showEditRoleForm)
            <flux:button wire:navigate href="{{ route('rolepermission.index') }}" icon="arrow-left" variant="danger" size="xs">
              Back
            </flux:button>
          @else
            <flux:button wire:click="addRoleForm" icon="plus" variant="danger" size="xs">
                Add Role
            </flux:button>        
          @endif
      
          

      </div>
    </div>

      @if ($showAddRoleForm)
          @include('livewire.auth.layouts.role-add-form')
      @elseif($showEditRoleForm)
        @include('livewire.auth.layouts.role-edit-form')
      @else
        @include('livewire.auth.layouts.role-table')
      @endif   
      
      

        
</div> 
