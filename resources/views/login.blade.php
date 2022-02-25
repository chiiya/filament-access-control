<x-filament-access-control::auth-page action="login">
    <div>
        <h2 class="font-bold tracking-tight text-center text-2xl">
            {{ __('filament::login.heading') }}
        </h2>
    </div>

    {{ $this->form }}

    <x-filament::button type="submit" form="login" class="w-full">
        {{ __('filament::login.buttons.submit.label') }}
    </x-filament::button>

    <div class="text-center">
        <a class="text-primary-600 hover:text-primary-700" href="{{ route('filament.password.request') }}">
            {{ __('filament-access-control::default.buttons.forgot_password') }}
        </a>
    </div>
</x-filament-access-control::auth-page>
