@component('mail::message')

<p>Dear {{ $body['appointment']['doctor']['name'] }},</p>

<p>
    I hope this email finds you well. I am writing on behalf of <b>{{ $body['appointment']['user']['name'] }}</b> to inform you of the cancellation of their upcoming appointment scheduled for <b>{{ date('d M,Y',strtotime($body['appointment']['appointment_date'])) }} {{ $body['appointment']['appointment_time'] }} at {{ $body['appointment']['clinic_name'] }} </b> . We deeply regret any inconvenience this may cause and appreciate your understanding.
</p>

Thanks,<br>
{{ config('app.name') }}
@endcomponent
