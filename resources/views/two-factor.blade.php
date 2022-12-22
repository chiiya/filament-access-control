<form wire:submit.prevent="verify" class="space-y-8">
    <p>{{ __('filament-access-control::default.messages.enter_code') }}</p>

    {{ $this->form }}

    <x-filament::button type="submit" form="verify" class="w-full">
        {{ __('filament-access-control::default.buttons.submit') }}
    </x-filament::button>

    <div class="text-center">
        <a class="text-primary-600 hover:text-primary-700" href="{{ route('filament.auth.login') }}">
            {{ __('filament-access-control::default.buttons.back_to_login') }}
        </a>
    </div>
</form>
