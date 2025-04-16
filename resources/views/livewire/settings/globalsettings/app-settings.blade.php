<section class="w-full">
    @include('livewire.settings.globalsettings.layouts.heading')

    <x-settings.appsettinglayout :heading="__('Basic Settings')" :subheading=" __('Update the appearance settings for your app')">
        <form wire:submit="updateBasicSettings" class="my-6 w-full space-y-6">
            <flux:input class="max-w-lg" wire:model="app_name" :label="__('App Name')" type="text" required autofocus autocomplete="app_name" />
            <flux:input wire:model="app_logo" :label="__('Logo')" type="file" />
            @if ($app_logo)
            <img src="{{$app_logo->temporaryUrl() }}" alt="Current Logo" class="w-24 h-auto mt-2">
            @else
            <img src="{{ asset($logo_preview) }}" alt="Current Logo" class="w-24 h-auto mt-2">
            @endif


            <div class="flex items-center gap-4">
                <div class="flex items-center justify-end">
                    <flux:button variant="primary" type="submit" class="w-full">{{ __('Save') }}</flux:button>
                </div>
            </div>
        </form>
    </x-settings.appsettinglayout>
</section>

