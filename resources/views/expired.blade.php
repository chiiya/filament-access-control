<x-filament-access-control::auth-page action="authenticate">
    <div>
        <h2 class="font-bold tracking-tight text-center text-2xl">
            {{ __('filament-access-control::default.pages.account_expired') }}
        </h2>
    </div>

    <p class="text-center">
        {{ __('filament-access-control::default.messages.account_expired') }}
    </p>

    <div class="text-center">
        <a class="text-primary-600 hover:text-primary-700" href="{{ route('filament.auth.login') }}">
            {{ __('filament-access-control::default.buttons.back_to_login') }}
        </a>
    </div>
</x-filament-access-control::auth-page>
