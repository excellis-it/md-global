@component('mail::message')
{{-- @dd($userMembership) --}}
Hi {{ $details['name'] }},

Your membership plan has been purchased successfully. Please find the details below: <br><br> 
Plan Name :- {{ $details['plan_name'] }} <br>
Plan Price :- USD {{ $details['plan_price'] }} <br>

Thanks,<br>
{{ config('app.name') }}
@endcomponent
