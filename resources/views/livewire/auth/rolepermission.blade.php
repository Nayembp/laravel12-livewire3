 <div>
  <section class="w-full">
    @include('livewire.settings.globalsettings.layouts.heading')

    <x-settings.appsettinglayout :heading="__('Role and Permission')" :subheading=" __('Add, update, delete the roles and permissions of your users')">
     
            
        <div class="flex justify-end">           

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
      

        @if ($showAddRoleForm)
            @include('livewire.auth.layouts.role-add-form')
        @elseif($showEditRoleForm)
          @include('livewire.auth.layouts.role-edit-form')
        @else
          @include('livewire.auth.layouts.role-table')
        @endif   
        
          
      </x-settings.appsettinglayout>
    </section>
  
        
</div> 
