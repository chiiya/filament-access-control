<x-filament-panels::page.simple>
    <x-filament-panels::form wire:submit="verify">
        <p>{{ __('filament-access-control::default.messages.enter_code') }}</p>

        {{ $this->form }}

        <x-filament-panels::form.actions
            :actions="$this->getCachedFormActions()"
            :full-width="$this->hasFullWidthFormActions()"
        />
    </x-filament-panels::form>

    <div class="text-center">
        <a class="text-primary-600 hover:text-primary-700" href="{{ filament()->getLoginUrl() }}">
            {{ __('filament-access-control::default.buttons.back_to_login') }}
        </a>
    </div>
</x-filament-panels::page.simple>
