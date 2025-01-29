@component('mail::message')
Hi {{ $maildata['name'] }},

Welcome to {{ config('app.name') }}. Your account has been created successfully. Please login to your account.

@component('mail::button', ['url' => route('login')])
Login
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
