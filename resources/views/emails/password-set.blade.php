@component('mail::message')
# {{ __('filament-access-control::default.notifications.password_set.title', ['host' => $host]) }}

{{ __('filament-access-control::default.notifications.password_set.message', ['host' => $host]) }}

@component('mail::button', ['url' => $url])
{{ __('filament-access-control::default.notifications.password_set.button') }}
@endcomponent

{{ __('filament-access-control::default.notifications.password_set.expiry', ['count' => config('auth.passwords.filament.expire'), 'url' => route('filament.password.request')]) }}

{{ __('filament-access-control::default.notifications.salutation') }},<br>
{{ config('filament.brand') }}
@endcomponent
