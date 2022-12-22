<div class="space-y-8">
    <p class="text-center">
        {{ __('filament-access-control::default.messages.account_expired') }}
    </p>

    <div class="text-center">
        <a class="text-primary-600 hover:text-primary-700" href="{{ route('filament.auth.login') }}">
            {{ __('filament-access-control::default.buttons.back_to_login') }}
        </a>
    </div>
</div>
