@component('mail::message')
# Welcome to {{ config('app.name') }}

- {{ $details['message'] }}

@component('mail::button', ['url' => ''])
Visit our website
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
