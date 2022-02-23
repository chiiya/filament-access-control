<x-filament-access-control::auth-page action="send">
    <div>
        <h2 class="font-bold tracking-tight text-center text-2xl">
            {{ __('filament-access-control::default.pages.reset_password') }}
        </h2>
    </div>

    {{ $this->form }}

    <x-filament::button type="submit" form="send" class="w-full">
        {{ __('filament-access-control::default.buttons.submit') }}
    </x-filament::button>

    <div class="text-center">
        <a class="text-primary-600 hover:text-primary-700" href="{{ route('filament.auth.login') }}">
            {{ __('filament-access-control::default.buttons.back_to_login') }}
        </a>
    </div>
</x-filament-access-control::auth-page>
