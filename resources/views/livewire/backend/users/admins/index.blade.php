<div>
   

  <div class="rounded-2xl border border-gray-200 bg-white pt-4 mt-2 dark:border-gray-800 dark:bg-white/[0.03]">

    <div class="mb-4 flex flex-col gap-2 px-5 sm:flex-row sm:items-center sm:justify-between sm:px-6">
      <div>
        <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">
          Admins List
        </h3>
      </div>
      <div class="flex flex-col gap-3 sm:flex-row sm:items-center">
        <form>
          <div class="relative">
            <span class="pointer-events-none absolute top-1/2 left-4 -translate-y-1/2">
              <!-- Search Icon -->
              <svg class="fill-gray-500 dark:fill-gray-400" width="20" height="20" viewBox="0 0 20 20">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M3.04199 9.37381C3.04199 5.87712 5.87735 3.04218 9.37533 3.04218C12.8733 3.04218 15.7087 5.87712 15.7087 9.37381C15.7087 12.8705 12.8733 15.7055 9.37533 15.7055C5.87735 15.7055 3.04199 12.8705 3.04199 9.37381ZM9.37533 1.54218C5.04926 1.54218 1.54199 5.04835 1.54199 9.37381C1.54199 13.6993 5.04926 17.2055 9.37533 17.2055C11.2676 17.2055 13.0032 16.5346 14.3572 15.4178L17.1773 18.2381C17.4702 18.531 17.945 18.5311 18.2379 18.2382C18.5308 17.9453 18.5309 17.4704 18.238 17.1775L15.4182 14.3575C16.5367 13.0035 17.2087 11.2671 17.2087 9.37381C17.2087 5.04835 13.7014 1.54218 9.37533 1.54218Z" />
              </svg>
            </span>
            <input 
                  type="text" 
                  placeholder="Search..." 
                  wire:model.live.debounce.300ms="search"
                  class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-[42px] w-full rounded-lg border border-gray-300 bg-transparent py-2.5 pr-4 pl-[42px] text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden xl:w-[300px] dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
              />

          </div>
        </form>
      </div>
    </div>

    <!-- admins Table -->
    <div class="custom-scrollbar max-w-full overflow-x-auto px-5 sm:px-6">
      <table class="min-w-full table-auto">
        <thead class="border-y border-gray-100 py-3 dark:border-gray-800">
          <tr>
            <th class="py-3 font-normal text-left whitespace-nowrap"> Name </th>
            <th class="py-3 font-normal text-center whitespace-nowrap">Contact</th>
            <th class="py-3 font-normal text-center whitespace-nowrap">Status</th>
            <th class="py-3 font-normal text-center whitespace-nowrap">Actions</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
          @forelse ($admins as $admin)
          
            <tr class="align-top">
                <td class="py-4 px-3 whitespace-nowrap text-gray-800 dark:text-white">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 overflow-hidden rounded-full">
                          <img src="{{ asset(auth()->user()->image) }}"  alt="brand">
                        </div>
                        <div>
                          <span class="block font-medium text-gray-800 text-theme-sm dark:text-white/90">
                            {{ $admin->name }}
                          </span>
                          <span class="block text-gray-500 text-theme-xs dark:text-gray-400">
                            @foreach($admin->roles as $role)                            
                                {{ $role->name }}                            
                            @endforeach
                          </span>
                        </div>
                      </div>                    
                </td>
              <td class="py-4 px-3 whitespace-nowrap text-gray-800 dark:text-white">
                Email: {{ $admin->email }} <br>
                Phone: {{ $admin->phone }} 
              </td>
              <td class="py-4 px-3 whitespace-nowrap text-gray-800 dark:text-white">
                <flux:field variant="inline">
                    <flux:switch 
                        :checked="$admin->status === 'active'" 
                        wire:click="toggleStatus({{ $admin->id }})" 
                    />
            
                        <flux:error name="status" />
                    </flux:field>
                </td>
            
            
              
              <td class="py-4 px-3 whitespace-nowrap">
                <div class="flex gap-2">
                    <flux:button size="xs" variant="primary" icon="pencil" wire:click="editadmin({{ $admin->id }})" aria-label="Edit admin" />
                   
                    @if(!$admin->hasRole('super-admin'))                       
                
                        <flux:button size="xs" variant="danger" icon="trash"
                            x-on:click.prevent="
                                if (confirm('Are you sure you want to delete this admin?')) {
                                    $wire.deleteadmin({{ $admin->id }})
                                }" aria-label="Delete admin" />
                    @endif
                </div>
              </td>
            
            </tr>
          @empty
            <tr>
              <td colspan="3" class="px-4 py-4 text-center text-gray-500 dark:text-gray-400">
                No admins found.
              </td>
            </tr>
          @endforelse

          
        </tbody>       
      </table>  
      <div class="mt-4 mb-3">
        {{ $admins->links() }}
      </div>    
    </div>

  
    

 
</div>
