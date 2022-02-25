@component('mail::message')
# {{ __('filament-access-control::default.notifications.two_factor.title', ['host' => $host]) }}

{{ __('filament-access-control::default.notifications.two_factor.message') }}

# {{ $code }}

{{ __('filament-access-control::default.notifications.salutation') }},<br>
{{ config('filament.brand') }}
@endcomponent
