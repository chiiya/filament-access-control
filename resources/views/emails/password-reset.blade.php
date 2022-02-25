@component('mail::message')
# {{ __('filament-access-control::default.notifications.password_reset.title', ['host' => $host]) }}

{{ __('filament-access-control::default.notifications.password_reset.message', ['host' => $host]) }}

@component('mail::button', ['url' => $url])
{{ __('filament-access-control::default.notifications.password_reset.button') }}
@endcomponent

{{ __('filament-access-control::default.notifications.password_reset.expiry', ['count' => config('auth.passwords.filament.expire')]) }}

{{ __('filament-access-control::default.notifications.salutation') }},<br>
{{ config('filament.brand') }}
@endcomponent
